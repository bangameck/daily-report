<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreReguRequest;
use App\Http\Requests\UpdateReguRequest;
use App\Models\Regu;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReguController extends Controller
{
    /**
     * Tampilkan daftar semua regu.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query  = Regu::with('kepalaRegu'); // Eager load relasi 'kepalaRegu'

        if ($search) {
            $query->where('nm_regu', 'like', "%{$search}%")
                ->orWhereHas('kepalaRegu', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
        }

        $regus = $query->latest()->paginate(10)->withQueryString();

        return view('regu.index', compact('regus', 'search'));
    }

    /**
     * Tampilkan form tambah regu.
     */
    public function create(): View
    {
        // Ambil hanya user dengan role "karu" (role_id = 3)
        $karuUsers = User::where('role_id', 3)
            ->whereDoesntHave('kepalaReguDi') // 'kepalaReguDi' adalah relasi hasOne dari User ke Regu
            ->orderBy('nama')
            ->get();
        return view('regu.create', compact('karuUsers'));
    }

    /**
     * Simpan regu baru.
     */
    public function store(StoreReguRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('f_regu')) {
            $data['f_regu'] = $request->file('f_regu')->store('regu_avatars', 'public');
        }

        Regu::create($data);

        return redirect()->route('regu.index')->with('success', 'Regu berhasil ditambahkan.');
    }

    /**
     * (Opsional) Tampilkan detail regu.
     */
    public function show(Regu $regu): View
    {
        $regu->load('anggota', 'kepalaRegu'); // Load relasi anggota dan karu
        return view('regu.show', compact('regu'));
    }

    /**
     * Tampilkan form edit regu.
     */
    public function edit(Regu $regu): View
    {
        // Ambil hanya user dengan role "karu" (role_id = 3)
        $availableKaru = User::where('role_id', 3)
            ->whereDoesntHave('kepalaReguDi')
            ->orderBy('nama')
            ->get();
        $currentKaru = null;
        if ($regu->karu) {
            $currentKaru = User::find($regu->karu);
        }
        if ($currentKaru && ! $availableKaru->contains($currentKaru)) {
            $karuUsers = $availableKaru->prepend($currentKaru);
        } else {
            $karuUsers = $availableKaru;
        }

        return view('regu.edit', compact('regu', 'karuUsers'));
    }

    /**
     * Update data regu.
     */
    public function update(UpdateReguRequest $request, Regu $regu): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('f_regu')) {
            // Hapus foto lama jika ada
            if ($regu->f_regu) {
                Storage::disk('public')->delete($regu->f_regu);
            }
            $data['f_regu'] = $request->file('f_regu')->store('regu_avatars', 'public');
        }

        $regu->update($data);

        return redirect()->route('regu.index')->with('success', 'Regu berhasil diperbarui.');
    }

    /**
     * Hapus regu.
     */
    public function destroy(Regu $regu): RedirectResponse
    {
        // Hapus foto profil regu jika ada
        if ($regu->f_regu) {
            Storage::disk('public')->delete($regu->f_regu);
        }

        $regu->delete(); // Soft delete

        return redirect()->route('regu.index')->with('success', 'Regu berhasil dihapus.');
    }
}
