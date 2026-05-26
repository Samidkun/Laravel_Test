<?php

namespace App\Http\Controllers;

use App\Models\MasterLowongan;
use App\Models\TransaksiPendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display the reports page.
     */
    public function index(Request $request)
    {
        // Summary Stats
        $stats = [
            'total_pendaftar' => TransaksiPendaftar::count(),
            'approved' => TransaksiPendaftar::where('status', 'Approved')->count(),
            'rejected' => TransaksiPendaftar::where('status', 'Rejected')->count(),
            'pending' => TransaksiPendaftar::where('status', 'Pending')->count(),
            'total_lowongan' => MasterLowongan::count(),
            'total_quota' => MasterLowongan::sum('quota'),
        ];

        // Applicants per vacancy breakdown
        $lowongansBreakdown = MasterLowongan::withCount([
            'pendaftars',
            'pendaftars as approved_count' => function ($query) {
                $query->where('status', 'Approved');
            }
        ])->with('departement')->get();

        // Applicants per university
        $universityStats = TransaksiPendaftar::select('university', DB::raw('count(*) as total'))
            ->groupBy('university')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // Applicants per department summary
        $departmentStats = DB::table('master_departements')
            ->leftJoin('master_lowongans', 'master_departements.id', '=', 'master_lowongans.dept_id')
            ->leftJoin('transaksi_pendaftars', 'master_lowongans.id', '=', 'transaksi_pendaftars.id_lowongan')
            ->select('master_departements.name as department_name', DB::raw('count(transaksi_pendaftars.id) as total_pendaftar'))
            ->groupBy('master_departements.id', 'master_departements.name')
            ->orderBy('total_pendaftar', 'desc')
            ->get();

        // Applicants list for reporting
        $pendaftars = TransaksiPendaftar::with('lowongan.departement')
            ->when($request->status, function ($q, $status) {
                return $q->where('status', $status);
            })
            ->when($request->lowongan_id, function ($q, $lowonganId) {
                return $q->where('id_lowongan', $lowonganId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $allLowongans = MasterLowongan::all();

        return view('admin.laporan.index', compact('stats', 'lowongansBreakdown', 'universityStats', 'departmentStats', 'pendaftars', 'allLowongans'));
    }
}
