<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Regu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = User::with('role', 'regu');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('users.index', compact('users', 'search'));
    }

    public function create(): View
    {
        $roles = Role::all();
        $regus = Regu::all();
        return view('users.create', compact('roles', 'regus'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $userData    = $request->safe()->except(['tmt', 'fb', 'ig', 'tw']);
        $profileData = $request->safe()->only(['tmt', 'fb', 'ig', 'tw']);

        if ($request->hasFile('f_ust')) {
            $userData['f_ust'] = $request->file('f_ust')->store('avatars', 'public');
        }

        $userData['password'] = Hash::make($userData['password']);

        $user = User::create($userData);

        if (! empty(array_filter($profileData))) {
            $profileData['user_id'] = $user->id;
            $user->profile()->create($profileData);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user): View | RedirectResponse
    {
        $authUser = Auth::user();

        // 1. Admin/Pimpinan (Role 1 & 5) bisa lihat semua
        if (in_array($authUser->role_id, [1, 5])) {
            // Lanjutkan, tidak perlu dicek
        }
        // 2. Karu/Pawas (Role 3 & 4) hanya bisa lihat regunya
        elseif (in_array($authUser->role_id, [3, 4])) {
            if (! $authUser->regu_id) {
                return redirect()->route('users.index')->with('error', 'Anda tidak terdaftar di regu manapun.');
            }
            if ($authUser->regu_id !== $user->regu_id) {
                return redirect()->route('users.index')->with('error', 'Anda hanya bisa melihat detail anggota regu Anda.');
            }
        }
        // 3. Role lain (cth: Anggota) tidak bisa lihat profil orang lain
        else {
            return redirect()->route('dashboard')->with('error', 'Anda tidak punya hak akses.');
        }

        // --- Jika Lolos Otorisasi ---

        // Eager load semua relasi
        $user->load('role', 'regu', 'profile', 'laporanHarian');

        // Hitung TMT
        $tmt            = $user->profile?->tmt;
        $bergabungSejak = $tmt ? $tmt->diffForHumans() : 'Belum Diatur';

        // Hitung Total Laporan
        $totalLaporan = $user->laporanHarian->count();

        return view('users.show', compact('user', 'bergabungSejak', 'totalLaporan'));
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        $regus = Regu::all();
        return view('users.edit', compact('user', 'roles', 'regus'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {

        $userData    = $request->safe()->except(['tmt', 'fb', 'ig', 'tw']);
        $profileData = $request->safe()->only(['tmt', 'fb', 'ig', 'tw']);

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($userData['password']);
        } else {
            unset($userData['password']);
        }

        if ($request->hasFile('f_ust')) {
            if ($user->f_ust) {
                Storage::disk('public')->delete($user->f_ust);
            }
            $userData['f_ust'] = $request->file('f_ust')->store('avatars', 'public');
        }

        $user->update($userData);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user (Delete)
     */
    public function destroy(User $user): RedirectResponse
    {
        // Pastikan tidak menghapus diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus foto profil jika ada
        if ($user->f_ust) {
            Storage::disk('public')->delete($user->f_ust);
        }

        $user->delete(); // Ini akan soft delete jika model menggunakan SoftDeletes

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    /**
     * Ganti status user (Aktif/Non-aktif)
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->status = ! $user->status;
        $user->save();

        $message = $user->status ? 'User berhasil diaktifkan.' : 'User berhasil dinonaktifkan.';

        return back()->with('success', $message);
    }

    public function checkUsername(Request $request): JsonResponse
    {
        $username = $request->input('username');
        if (! $username) {
            return response()->json(['available' => false]);
        }

        $isTaken = User::where('username', $username)->exists();

        return response()->json(['available' => ! $isTaken]);
    }

    /**
     * [AJAX] Cek ketersediaan email.
     */
    public function checkEmail(Request $request): JsonResponse
    {
        $email = $request->input('email');
        if (! $email) {
            return response()->json(['available' => false]);
        }

        $isTaken = User::where('email', $email)->exists();

        return response()->json(['available' => ! $isTaken]);
    }
}
