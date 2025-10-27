<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreKategoriLaporanRequest; // Model kita
use App\Http\Requests\UpdateKategoriLaporanRequest;
use App\Models\KategoriLaporanHarian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriLaporanController extends Controller
{
    /**
     * Tampilkan daftar kategori.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query  = KategoriLaporanHarian::query();

        if ($search) {
            $query->where('nm_kategori', 'like', "%{$search}%");
        }

        // Kita eager load jumlah laporan yg terkait, agar bisa ditampilkan
        $kategoris = $query->withCount('laporanHarian')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('kategori.index', compact('kategoris', 'search'));
    }

    /**
     * Tampilkan form tambah kategori.
     */
    public function create(): View
    {
        return view('kategori.create');
    }

    /**
     * Simpan kategori baru.
     */
    public function store(StoreKategoriLaporanRequest $request): RedirectResponse
    {
        KategoriLaporanHarian::create($request->validated());

        return redirect()->route('kategori-laporan.index')->with('success', 'Kategori laporan berhasil ditambahkan.');
    }

    /**
     * (Kita tidak pakai show() untuk kategori, biarkan)
     */
    public function show(KategoriLaporanHarian $kategori_laporan)
    {
        return redirect()->route('kategori-laporan.index');
    }

    /**
     * Tampilkan form edit kategori.
     */
    public function edit(KategoriLaporanHarian $kategori_laporan): View
    {
        return view('kategori.edit', compact('kategori_laporan'));
    }

    /**
     * Update data kategori.
     */
    public function update(UpdateKategoriLaporanRequest $request, KategoriLaporanHarian $kategori_laporan): RedirectResponse
    {
        $kategori_laporan->update($request->validated());

        return redirect()->route('kategori-laporan.index')->with('success', 'Kategori laporan berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(KategoriLaporanHarian $kategori_laporan): RedirectResponse
    {
        // [PENTING] Cek relasi sebelum menghapus
        if ($kategori_laporan->laporanHarian()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena sedang digunakan oleh satu atau lebih laporan.');
        }

        $kategori_laporan->delete(); // Soft delete

        return redirect()->route('kategori-laporan.index')->with('success', 'Kategori laporan berhasil dihapus.');
    }
}
