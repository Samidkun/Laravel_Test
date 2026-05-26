<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartement;
use App\Models\MasterLowongan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterLowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lowongans = MasterLowongan::with(['departement', 'creator', 'updater'])->get();
        return view('admin.lowongan.index', compact('lowongans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departements = MasterDepartement::all();
        return view('admin.lowongan.create', compact('departements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dept_id' => 'required|exists:master_departements,id',
            'posisi' => 'required|string|max:255',
            'quota' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
        ]);

        // Get admin user or fallback
        $userId = Auth::id() ?? User::where('role', 'admin')->first()?->id;

        MasterLowongan::create([
            'dept_id' => $request->dept_id,
            'posisi' => $request->posisi,
            'quota' => $request->quota,
            'deskripsi' => $request->deskripsi,
            'user_created' => $userId,
            'user_updated' => $userId,
        ]);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $lowongan = MasterLowongan::findOrFail($id);
        $departements = MasterDepartement::all();
        return view('admin.lowongan.edit', compact('lowongan', 'departements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'dept_id' => 'required|exists:master_departements,id',
            'posisi' => 'required|string|max:255',
            'quota' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
        ]);

        $lowongan = MasterLowongan::findOrFail($id);
        
        // Get admin user or fallback
        $userId = Auth::id() ?? User::where('role', 'admin')->first()?->id;

        $lowongan->update([
            'dept_id' => $request->dept_id,
            'posisi' => $request->posisi,
            'quota' => $request->quota,
            'deskripsi' => $request->deskripsi,
            'user_updated' => $userId,
        ]);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lowongan = MasterLowongan::findOrFail($id);
        $lowongan->delete();

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil dihapus.');
    }
}
