<?php

namespace App\Http\Controllers;

use App\Models\MasterLowongan;
use App\Models\TransaksiPendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    /**
     * Public page: Display list of open vacancies.
     */
    public function publicIndex()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.lowongan.index');
        }

        // Fetch vacancies with departments
        $lowongans = MasterLowongan::with('departement')->get();
        return view('pendaftaran.index', compact('lowongans'));
    }

    /**
     * Public page: Display registration form.
     */
    public function create($lowonganId = null)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.lowongan.index')->with('error', 'Halaman ini hanya dapat diakses oleh pelamar.');
        }

        $lowongans = MasterLowongan::all();
        $selectedLowongan = null;
        if ($lowonganId) {
            $selectedLowongan = MasterLowongan::findOrFail($lowonganId);
        }
        return view('pendaftaran.create', compact('lowongans', 'selectedLowongan'));
    }

    /**
     * Public action: Save registration.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.lowongan.index')->with('error', 'Halaman ini hanya dapat diakses oleh pelamar.');
        }

        $request->validate([
            'id_lowongan' => 'required|exists:master_lowongans,id',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'dob' => 'required|date',
            'adres' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'university' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'ipk' => 'required|numeric|min:0|max:4.00',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048', // Max 2MB pdf/doc/docx
        ], [
            'id_lowongan.required' => 'Pilih lowongan magang yang ingin dilamar.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'gender.required' => 'Pilih jenis kelamin Anda.',
            'dob.required' => 'Tanggal lahir wajib diisi.',
            'adres.required' => 'Alamat lengkap wajib diisi.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'university.required' => 'Nama universitas wajib diisi.',
            'major.required' => 'Jurusan wajib diisi.',
            'ipk.required' => 'IPK wajib diisi.',
            'ipk.numeric' => 'IPK harus berupa angka.',
            'ipk.max' => 'IPK maksimal adalah 4.00.',
            'cv.required' => 'File CV wajib diunggah.',
            'cv.mimes' => 'Format file CV harus PDF, DOC, atau DOCX.',
            'cv.max' => 'Ukuran file CV maksimal 2MB.',
        ]);

        $pathCv = null;
        if ($request->hasFile('cv')) {
            $pathCv = $request->file('cv')->store('cv_uploads', 'public');
        }

        TransaksiPendaftar::create([
            'user_id' => Auth::id(),
            'id_lowongan' => $request->id_lowongan,
            'name' => $request->name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'adres' => $request->adres,
            'no_telp' => $request->no_telp,
            'university' => $request->university,
            'major' => $request->major,
            'ipk' => $request->ipk,
            'status' => 'Pending',
            'path_cv' => $pathCv,
        ]);

        return redirect()->route('pendaftaran.my_status')->with('success', 'Pendaftaran Anda berhasil dikirim! Status persetujuan dapat dipantau di halaman ini.');
    }

    /**
     * Public page: Display status of the logged-in user's applications.
     */
    public function myApplications()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.lowongan.index')->with('error', 'Halaman ini hanya dapat diakses oleh pelamar.');
        }
        $pendaftars = TransaksiPendaftar::with('lowongan.departement')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('pendaftaran.status', compact('pendaftars'));
    }

    /**
     * Admin page: List all applicants.
     */
    public function adminIndex()
    {
        $pendaftars = TransaksiPendaftar::with('lowongan.departement')->get();
        return view('admin.pendaftar.index', compact('pendaftars'));
    }

    /**
     * Admin action: Approve/Reject applicant.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        $pendaftar = TransaksiPendaftar::findOrFail($id);
        $oldStatus = $pendaftar->status;
        $newStatus = $request->status;

        $pendaftar->update([
            'status' => $newStatus,
        ]);

        // If new status is Approved and old was not, decrement lowongan quota (optional but nice touch!)
        if ($newStatus === 'Approved' && $oldStatus !== 'Approved') {
            $lowongan = $pendaftar->lowongan;
            if ($lowongan && $lowongan->quota > 0) {
                $lowongan->decrement('quota');
            }
        }
        // If status was Approved and now changes to something else, increment lowongan quota
        elseif ($oldStatus === 'Approved' && $newStatus !== 'Approved') {
            $lowongan = $pendaftar->lowongan;
            if ($lowongan) {
                $lowongan->increment('quota');
            }
        }

        return redirect()->route('admin.pendaftar.index')->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}
