@extends('layouts.main')

@section('title', 'Laporan Analisis Magang (Admin)')

@section('styles')
<style>
    /* Styling khusus cetak laporan */
    @media print {
        header, footer, .no-print, #filter-section {
            display: none !important;
        }
        body {
            background-color: white !important;
            color: black !important;
        }
        main {
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .card, .table-card {
            background: white !important;
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            color: black !important;
        }
        th {
            background-color: #f1f5f9 !important;
            color: black !important;
            border-bottom: 2px solid #ddd !important;
        }
        td, th {
            border: 1px solid #ddd !important;
            padding: 8px !important;
            color: black !important;
        }
        h1, h2, h3, p, span {
            color: black !important;
        }
        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 2rem;
        }
        .print-header h1 {
            font-size: 24px;
            font-weight: 800;
        }
    }
</style>
@endsection

@section('content')
<!-- Header khusus print (disembunyikan di layar biasa) -->
<div class="hidden print-header">
    <h1>LAPORAN ANALISIS SELEKSI PENDAFTAR MAGANG</h1>
    <p>Form Pendaftaran Magang - Tanggal Cetak: {{ date('d M Y H:i') }}</p>
    <hr style="border: 1px solid #333; margin-top: 10px;" />
</div>

<div class="space-y-8">
    <!-- Top Header -->
    <div class="sm:flex sm:items-center sm:justify-between no-print">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-slate-900">Laporan & Analisis Statistik</h1>
            <p class="text-xs md:text-sm text-slate-500">Ringkasan matrik seleksi pendaftar magang mahasiswa dan analisis data kuota lowongan.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Laporan (PDF)
            </button>
        </div>
    </div>

    <!-- Summary Stats Widgets -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1 -->
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm card">
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Pendaftar</p>
            <h3 class="text-2xl md:text-3xl font-bold text-slate-900 mt-1">{{ $stats['total_pendaftar'] }}</h3>
            <p class="text-[10px] text-slate-400 mt-1">mahasiswa terdaftar</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm card">
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Disetujui (Approved)</p>
            <h3 class="text-2xl md:text-3xl font-bold text-emerald-700 mt-1">{{ $stats['approved'] }}</h3>
            <p class="text-[10px] text-slate-400 mt-1">lolos seleksi administratif</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm card">
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Ditolak (Rejected)</p>
            <h3 class="text-2xl md:text-3xl font-bold text-rose-700 mt-1">{{ $stats['rejected'] }}</h3>
            <p class="text-[10px] text-slate-400 mt-1">tidak memenuhi kriteria</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm card">
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Menunggu (Pending)</p>
            <h3 class="text-2xl md:text-3xl font-bold text-amber-700 mt-1">{{ $stats['pending'] }}</h3>
            <p class="text-[10px] text-slate-400 mt-1">belum ditinjau</p>
        </div>
    </div>

    <!-- Charts and Breakdowns -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- University Origin Stats -->
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col justify-between card">
            <div class="space-y-1">
                <h3 class="text-sm font-bold text-slate-900">Distribusi Universitas</h3>
                <p class="text-xs text-slate-500">Asal universitas pelamar terbanyak.</p>
            </div>
            
            <div class="space-y-4 mt-5">
                @if($universityStats->isEmpty())
                    <p class="text-xs text-slate-400 italic text-center py-4">Belum ada data pelamar.</p>
                @else
                    @php
                        $maxTotal = $universityStats->max('total') ?: 1;
                    @endphp
                    @foreach($universityStats as $uni)
                        @php
                            $percentage = ($uni->total / $maxTotal) * 100;
                        @endphp
                        <div class="space-y-1">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-medium text-slate-700 truncate max-w-[180px]" title="{{ $uni->university }}">{{ $uni->university }}</span>
                                <span class="font-bold text-slate-900">{{ $uni->total }} orang</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-blue-600 h-full rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Vacancies Analysis Breakdown -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl p-6 shadow-sm card">
            <div class="space-y-1">
                <h3 class="text-sm font-bold text-slate-900">Analisis Keterisian Kuota</h3>
                <p class="text-xs text-slate-500">Persentase penerimaan pelamar terhadap kuota awal lowongan.</p>
            </div>

            <div class="mt-5 space-y-3.5 overflow-y-auto max-h-[220px] pr-1">
                @if($lowongansBreakdown->isEmpty())
                    <p class="text-xs text-slate-400 italic text-center py-4">Belum ada data lowongan.</p>
                @else
                    @foreach($lowongansBreakdown as $lowongan)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 border border-slate-200">
                            <div>
                                <h4 class="text-xs font-bold text-slate-800">{{ $lowongan->posisi }}</h4>
                                <p class="text-[10px] text-slate-500">{{ $lowongan->departement->name }} &bull; Total pelamar: {{ $lowongan->pendaftars_count }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-xs font-bold text-slate-900">Diterima: {{ $lowongan->approved_count }}</div>
                                <div class="text-[9px] text-slate-500 font-medium">Kuota Awal: {{ $lowongan->quota + $lowongan->approved_count }}</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div id="filter-section" class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm no-print">
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Filter Status -->
            <div class="space-y-1">
                <label for="status" class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Filter Status</label>
                <select id="status" name="status" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Approved" {{ request('status') === 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Filter Lowongan -->
            <div class="space-y-1">
                <label for="lowongan_id" class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Filter Posisi</label>
                <select id="lowongan_id" name="lowongan_id" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:border-blue-500">
                    <option value="">Semua Posisi</option>
                    @foreach($allLowongans as $item)
                        <option value="{{ $item->id }}" {{ request('lowongan_id') == $item->id ? 'selected' : '' }}>{{ $item->posisi }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                    Terapkan
                </button>
                <a href="{{ route('admin.laporan.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg border border-slate-300 transition-colors text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Applicants Details Report -->
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm table-card">
        <div class="p-5 border-b border-slate-200 flex justify-between items-center no-print bg-slate-50">
            <h3 class="text-sm font-bold text-slate-900">Detail Laporan Data Pelamar</h3>
            <span class="text-xs text-slate-500 font-semibold">Total pelamar disaring: {{ $pendaftars->count() }} orang</span>
        </div>

        @if($pendaftars->isEmpty())
            <div class="p-12 text-center text-slate-400 italic text-xs bg-white">Tidak ditemukan data pelamar yang cocok dengan kriteria filter.</div>
        @else
            <div class="overflow-x-auto bg-white">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-slate-700">
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Nama Pelamar</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Posisi Magang</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Universitas</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Jurusan</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">IPK</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Tanggal Daftar</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($pendaftars as $applicant)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="p-4 text-sm font-semibold text-slate-900">{{ $applicant->name }}</td>
                                <td class="p-4 text-sm text-slate-750 text-slate-700">{{ $applicant->lowongan->posisi ?? 'Lowongan Dihapus' }}</td>
                                <td class="p-4 text-sm text-slate-700">{{ $applicant->university }}</td>
                                <td class="p-4 text-sm text-slate-600">{{ $applicant->major }}</td>
                                <td class="p-4 text-sm">
                                    <span class="font-bold {{ $applicant->ipk >= 3.50 ? 'text-emerald-700' : 'text-slate-700' }}">
                                        {{ number_format($applicant->ipk, 2) }}
                                    </span>
                                </td>
                                <td class="p-4 text-xs text-slate-500">{{ $applicant->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-4 text-sm">
                                    <span class="inline-flex px-2 py-0.5 rounded text-xs font-bold border
                                        {{ $applicant->status === 'Approved' ? 'bg-emerald-50 text-emerald-800 border-emerald-250' : ($applicant->status === 'Rejected' ? 'bg-rose-50 text-rose-800 border-rose-250' : 'bg-amber-50 text-amber-800 border-amber-250') }}">
                                        {{ $applicant->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
