<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreLaporanHarianRequest;
use App\Models\KategoriLaporanHarian;
// [OPSIONAL] Kita mungkin akan butuh ini nanti
use App\Models\LaporanHarian;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

// Import DB Facade

class LaporanHarianController extends Controller
{
    /**
     * Tampilkan daftar laporan (berdasarkan role).
     */
    public function index(Request $request): View
    {
        $user  = Auth::user();
        $query = LaporanHarian::with('user', 'regu', 'kategori', 'verifikasi')->latest('tgl_lap')->latest('jam_s');

        // [BARU] Ambil input filter
        $searchNama  = $request->input('search_nama');
        $searchBulan = $request->input('search_bulan');
        $searchTahun = $request->input('search_tahun');
        $searchStart = $request->input('search_start');
        $searchEnd   = $request->input('search_end');

        // [LOGIC ROLE]
        // Admin (1) & Pimpinan (5) lihat semua
        if (in_array($user->role_id, [1, 5])) {
            // Terapkan filter HANYA untuk role ini
            if ($searchNama) {
                $query->whereHas('user', function ($q) use ($searchNama) {
                    $q->where('nama', 'like', "%{$searchNama}%");
                });
            }
            if ($searchBulan) {
                $query->whereMonth('tgl_lap', $searchBulan);
            }
            if ($searchTahun) {
                $query->whereYear('tgl_lap', $searchTahun);
            }
            if ($searchStart && $searchEnd) {
                $query->whereBetween('tgl_lap', [$searchStart, $searchEnd]);
            }
        }
        // Pengawas (4) & Karu (3) lihat regunya
        elseif (in_array($user->role_id, [3, 4])) {
            $query->where('regu_id', $user->regu_id);
            // Pengawas juga bisa filter di regunya
            if ($searchNama) {
                $query->whereHas('user', function ($q) use ($searchNama) {
                    $q->where('nama', 'like', "%{$searchNama}%");
                });
            }
            if ($searchStart && $searchEnd) {
                $query->whereBetween('tgl_lap', [$searchStart, $searchEnd]);
            }
        }
        // Anggota (2) lihat laporannya sendiri
        else {
            $query->where('user_id', $user->id);
        }

        $laporanHarian = $query->paginate(10)->withQueryString();

        // [BARU] Siapkan data untuk form filter
        $usersList = in_array($user->role_id, [1, 5])
            ? User::orderBy('nama')->get()
            : User::where('regu_id', $user->regu_id)->orderBy('nama')->get();

        return view('laporan.index', compact(
            'laporanHarian',
            'usersList',
            'searchNama',
            'searchBulan',
            'searchTahun',
            'searchStart',
            'searchEnd'
        ));
    }

    /**
     * [LOGIC UTAMA] Tampilkan form tambah laporan.
     */
    public function create(): View | RedirectResponse
    {
        $user  = Auth::user();
        $today = today();
        $now   = now();

        // 1. Cek Role (Pengawas Role 4 tidak boleh create)
        if ($user->role_id == 4) {
            return redirect()->route('dashboard')->with('error', 'Pengawas tidak dapat membuat laporan harian.');
        }

        // 2. Ambil laporan hari ini
        $laporanHariIni = LaporanHarian::where('user_id', $user->id)
            ->whereDate('tgl_lap', $today)
            ->get();

        $jumlahLaporan = $laporanHariIni->count();

        // 3. Cek Limit 4 Laporan
        if ($jumlahLaporan >= 4) {
            return view('laporan.create', [
                'canCreate'       => false,
                'blockReason'     => 'Anda sudah mencapai batas maksimal 4 laporan untuk hari ini.',
                'kategoriList'    => collect(),
                'jamMulaiDefault' => $now->format('H:i'),
            ]);
        }

        // 4. Cek Waktu Selesai Laporan Terakhir
        $lastReport      = $laporanHariIni->sortByDesc('jam_f')->first();
        $jamMulaiDefault = $now->format('H:i');

        if ($lastReport) {
            $jamSelesaiTerakhir  = Carbon::parse($lastReport->jam_f);
            $jamMulaiPalingCepat = $jamSelesaiTerakhir->addMinute(); // Jeda 1 menit

            if ($now->lt($jamMulaiPalingCepat)) {
                return view('laporan.create', [
                    'canCreate'       => false,
                    'blockReason'     => 'Anda belum bisa input. Laporan terakhir Anda baru selesai pukul ' . $jamSelesaiTerakhir->subMinute()->format('H:i') . ' WIB.',
                    'kategoriList'    => collect(),
                    'jamMulaiDefault' => $jamMulaiPalingCepat->format('H:i'),
                ]);
            }
            $jamMulaiDefault = $jamMulaiPalingCepat->format('H:i');
        }

        // 5. Lolos semua cek, siapkan form
        $kategoriList = KategoriLaporanHarian::orderBy('nm_kategori')->get();

        return view('laporan.create', [
            'canCreate'       => true,
            'blockReason'     => '',
            'kategoriList'    => $kategoriList,
            'jamMulaiDefault' => $jamMulaiDefault,
        ]);
    }

    /**
     * Simpan laporan baru.
     */
    public function store(StoreLaporanHarianRequest $request): RedirectResponse
    {
        $data  = $request->validated();
        $user  = Auth::user();
        $today = today();

        // Gunakan DB Transaction untuk memastikan data konsisten
        DB::beginTransaction();
        try {
            // 1. Buat Nomor Laporan (Contoh: LAP/2025/10/XYZ123)
            $noLap = 'LAP/' . $today->year . '/' . $today->month . '/' . strtoupper(Str::random(6));

            // 2. Simpan Laporan Utama
            $laporan = LaporanHarian::create([
                'no_lap'  => $noLap,
                'tgl_lap' => $today,
                'jam_s'   => $data['jam_s'],
                'jam_f'   => $data['jam_f'],
                'user_id' => $user->id,
                'regu_id' => $user->regu_id,
                'id_kat'  => $data['id_kat'],
                'laporan' => KategoriLaporanHarian::find($data['id_kat'])->nm_kategori,
                'ket_lap' => $data['ket_lap'],
                'st_lap'  => 'pending',
            ]);

            // 3. Handle File Dokumentasi
            if ($request->hasFile('dokumentasi')) {
                foreach ($request->file('dokumentasi') as $file) {
                    $ext     = $file->getClientOriginalExtension();
                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
                    $path    = $file->store($isImage ? 'laporan/images' : 'laporan/videos', 'public');

                    $laporan->dokumentasi()->create([
                        'n_d_lap' => $path,
                        'x_lap'   => $ext,
                    ]);
                }
            }

            DB::commit(); // Semua sukses
            return redirect()->route('laporan.index')->with('success', 'Laporan harian berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika ada error
                            // Hapus file yang mungkin sudah ter-upload jika error
            if (isset($laporan) && $laporan->dokumentasi) {
                foreach ($laporan->dokumentasi as $doc) {
                    Storage::disk('public')->delete($doc->n_d_lap);
                }
            }
            return back()->with('error', 'Terjadi kesalahan saat menyimpan laporan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail laporan.
     */
    public function show(LaporanHarian $laporan): View
    {
        $laporan->load('user.role', 'regu', 'kategori', 'verifikasi.pengawas', 'dokumentasi');
        // Otorisasi: Pastikan user boleh lihat
        $this->authorize('view', $laporan);
        return view('laporan.show', compact('laporan'));
    }

    /**
     * Tampilkan form edit laporan.
     */
    public function edit(LaporanHarian $laporan): View
    {
        $this->authorize('update', $laporan);

        $kategoriList = KategoriLaporanHarian::orderBy('nm_kategori')->get();

        return view('laporan.edit', compact('laporan', 'kategoriList'));
    }

    /**
     * Update laporan.
     */
    public function update(Request $request, LaporanHarian $laporan): RedirectResponse
    {
        // $this->authorize('update', $laporan);

        // Nanti kita buat UpdateLaporanHarianRequest
        $data = $request->validate([
            'id_kat'         => ['required', 'exists:kat_lap_harian,id_kat'],
            'jam_s'          => ['required', 'date_format:H:i'],
            'jam_f'          => ['required', 'date_format:H:i', 'after:jam_s'],
            'ket_lap'        => ['required', 'string', 'min:10'],
            'dokumentasi'    => ['nullable', 'array'],
            'dokumentasi.*'  => ['file', 'mimes:jpg,jpeg,png,mp4,mov,3gp,qt', 'max:25600'],
            // [BARU] Logic untuk hapus file lama
            'deleted_docs'   => ['nullable', 'array'],
            'deleted_docs.*' => ['integer'], // kirim ID d_lap_harian
        ]);

        DB::beginTransaction();
        try {
            // 1. Update data laporan utama
            $laporan->update([
                'jam_s'   => $data['jam_s'],
                'jam_f'   => $data['jam_f'],
                'id_kat'  => $data['id_kat'],
                'laporan' => KategoriLaporanHarian::find($data['id_kat'])->nm_kategori,
                'ket_lap' => $data['ket_lap'],
            ]);

            // 2. Hapus dokumentasi lama (jika ada)
            if (! empty($data['deleted_docs'])) {
                foreach ($laporan->dokumentasi as $doc) {
                    if (in_array($doc->id_d_lap, $data['deleted_docs'])) {
                        Storage::disk('public')->delete($doc->n_d_lap);
                        $doc->delete();
                    }
                }
            }

            // 3. Tambah dokumentasi baru (jika ada)
            if ($request->hasFile('dokumentasi')) {
                foreach ($request->file('dokumentasi') as $file) {
                    $ext     = $file->getClientOriginalExtension();
                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
                    $path    = $file->store($isImage ? 'laporan/images' : 'laporan/videos', 'public');

                    $laporan->dokumentasi()->create([
                        'n_d_lap' => $path,
                        'x_lap'   => $ext,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate laporan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus laporan.
     */
    public function destroy(LaporanHarian $laporan): RedirectResponse
    {
        $this . authorize('delete', $laporan);

        try {
            DB::beginTransaction();
            // 1. Hapus semua file dokumentasi
            foreach ($laporan->dokumentasi as $doc) {
                Storage::disk('public')->delete($doc->n_d_lap);
                $doc->delete();
            }
            // 2. Hapus data verifikasi (jika ada)
            $laporan->verifikasi()->delete();
                                // 3. Hapus laporan utama
            $laporan->delete(); // Soft delete

            DB::commit();
            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }

    /**
     * [BARU] Approve Laporan (Pawas)
     */
    public function approve(LaporanHarian $laporan): RedirectResponse
    {
        $this->authorize('approve', $laporan); // Perlu buat Policy

        $laporan->update(['st_lap' => 'verified']);

        // Buat data di tabel verifikasi
        $laporan->verifikasi()->updateOrCreate(
            ['lap_harian_id' => $laporan->id_lap],
            ['pengawas_id' => Auth::id(), 'ket_reject' => null]
        );

        return back()->with('success', 'Laporan berhasil di-approve.');
    }

    /**
     * [BARU] Reject Laporan (Pawas)
     */
    public function reject(Request $request, LaporanHarian $laporan): RedirectResponse
    {
        $this->authorize('approve', $laporan);

        $request->validate(['ket_reject' => 'required|string|min:5']);

        $laporan->update(['st_lap' => 'rejected']);

        // Buat data di tabel verifikasi
        $laporan->verifikasi()->updateOrCreate(
            ['lap_harian_id' => $laporan->id_lap],
            ['pengawas_id' => Auth::id(), 'ket_reject' => $request->input('ket_reject')]
        );

        return back()->with('success', 'Laporan berhasil di-reject.');
    }
}
