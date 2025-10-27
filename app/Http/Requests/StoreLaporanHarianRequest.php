<?php
namespace App\Http\Requests;

use App\Models\LaporanHarian;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreLaporanHarianRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya Anggota (2) dan Karu (3) yang boleh create
        // Admin (1) dan Pimpinan (5) juga boleh (sesuai kode lama)
        return in_array($this->user()->role_id, [1, 2, 3, 5]);
    }

    public function rules(): array
    {
        return [
            'id_kat'        => ['required', 'exists:kat_lap_harian,id_kat'],
            'jam_s'         => ['required', 'date_format:H:i'],
            'jam_f'         => ['required', 'date_format:H:i', 'after:jam_s'],
            'ket_lap'       => ['required', 'string', 'min:10'],
            'dokumentasi'   => ['required', 'array', 'min:1'],
            'dokumentasi.*' => [
                'file',
                'mimes:jpg,jpeg,png,mp4,mov,3gp,qt', // Izinkan format gambar & video
                'max:25600',                         // Max 25MB per file
            ],
        ];
    }

    /**
     * [LOGIC KUSTOM] Tambahkan validasi kustom dari kode lama.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user  = Auth::user();
            $today = today();

            // 1. Cek Limit 4 Laporan
            $jumlahLaporan = LaporanHarian::where('user_id', $user->id)
                ->whereDate('tgl_lap', $today)
                ->count();

            if ($jumlahLaporan >= 4) {
                $validator->errors()->add('limit', 'Anda sudah mencapai batas maksimal 4 laporan untuk hari ini.');
            }

            // 2. Cek Waktu Selesai Laporan Terakhir
            $lastReport = LaporanHarian::where('user_id', $user->id)
                ->whereDate('tgl_lap', $today)
                ->latest('jam_f')
                ->first();

            if ($lastReport) {
                $jamSelesaiTerakhir = Carbon::parse($lastReport->jam_f);
                $jamMulaiInput      = Carbon::parse($this->input('jam_s'));

                // Cek jika jam mulai baru < jam selesai terakhir
                if ($jamMulaiInput->lt($jamSelesaiTerakhir)) {
                    $validator->errors()->add('jam_s', 'Jam mulai tidak boleh kurang dari jam selesai laporan terakhir Anda (pukul ' . $jamSelesaiTerakhir->format('H:i') . ' WIB).');
                }
            }
        });
    }
}
