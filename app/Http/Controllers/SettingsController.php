<?php
namespace App\Http\Controllers;

use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Menampilkan halaman settings.
     */
    public function index(): View
    {
        // Kita hanya perlu mengambil data user, karena di view kita akan pakai Auth::user()
        // jadi controller ini bisa sangat simpel.
        return view('settings.index');
    }
}
