<?php
namespace App\Http\Controllers;

use App\Models\LaporanHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
// <- Import model laporan

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $user   = Auth::user();
        $roleId = $user->role_id;

        $stats = [
            'laporanBulanIni' => 0,
            'diverifikasi'    => 0,
            'ditolak'         => 0,
        ];

        $laporanTerkini = collect(); // Default koleksi kosong

        // Role ID: 1=Admin, 4=Pawas, 5=Pimpinan (Bisa lihat semua data)
        if (in_array($roleId, [1, 4, 5])) {
            $stats['laporanBulanIni'] = LaporanHarian::whereMonth('tgl_lap', now()->month)
                ->whereYear('tgl_lap', now()->year)
                ->count();
            $stats['diverifikasi'] = LaporanHarian::whereMonth('tgl_lap', now()->month)
                ->whereYear('tgl_lap', now()->year)
                ->where('st_lap', 'verified')
                ->count();
            $stats['ditolak'] = LaporanHarian::whereMonth('tgl_lap', now()->month)
                ->whereYear('tgl_lap', now()->year)
                ->where('st_lap', 'rejected')
                ->count();

            $laporanTerkini = LaporanHarian::with('user')->latest()->take(5)->get();
        }
        // Role ID: 2=Staff, 3=Karu (Hanya lihat data pribadi)
        else {
            $stats['laporanBulanIni'] = LaporanHarian::where('user_id', $user->id)
                ->whereMonth('tgl_lap', now()->month)
                ->whereYear('tgl_lap', now()->year)
                ->count();
            $stats['diverifikasi'] = LaporanHarian::where('user_id', $user->id)
                ->whereMonth('tgl_lap', now()->month)
                ->whereYear('tgl_lap', now()->year)
                ->where('st_lap', 'verified')
                ->count();
            $stats['ditolak'] = LaporanHarian::where('user_id', $user->id)
                ->whereMonth('tgl_lap', now()->month)
                ->whereYear('tgl_lap', now()->year)
                ->where('st_lap', 'rejected')
                ->count();

            $laporanTerkini = LaporanHarian::where('user_id', $user->id)
                ->with('user') // Walaupun usernya sama, kita eager load biar konsisten
                ->latest()
                ->take(5)
                ->get();
        }

        // Kirim data 'stats' dan 'laporanTerkini' ke view
        return view('dashboard', [
            'stats'          => $stats,
            'laporanTerkini' => $laporanTerkini,
        ]);
    }
}
