@extends('layouts.main')

@section('title', 'Seleksi Pendaftaran Magang (Admin)')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-slate-900">Seleksi Pendaftaran Magang</h1>
        <p class="text-xs md:text-sm text-slate-500">Tinjau profil akademik, CV pelamar, dan lakukan persetujuan seleksi administratif.</p>
    </div>

    <!-- Table Card -->
    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm card-primary">
        @if($pendaftars->isEmpty())
            <div class="p-12 text-center flex flex-col items-center justify-center space-y-4">
                <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Belum Ada Pelamar</h3>
                    <p class="text-xs text-slate-500">Saat ini belum ada pelamar baru yang mengirimkan formulir.</p>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-slate-700">
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">No</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Pelamar</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Posisi Dilamar</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Universitas & Jurusan</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">IPK</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Dokumen CV</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Status</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider text-right">Aksi Persetujuan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($pendaftars as $idx => $pendaftar)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="p-4 text-sm text-slate-500">{{ $idx + 1 }}</td>
                                <td class="p-4 text-sm">
                                    <div class="font-semibold text-slate-900">{{ $pendaftar->name }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">{{ $pendaftar->gender }}, {{ $pendaftar->dob->age }} tahun</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">Telp: {{ $pendaftar->no_telp }}</div>
                                </td>
                                <td class="p-4 text-sm">
                                    @if($pendaftar->lowongan)
                                        <div class="font-semibold text-slate-800">{{ $pendaftar->lowongan->posisi }}</div>
                                        <div class="text-xs text-blue-600">{{ $pendaftar->lowongan->departement->name }}</div>
                                    @else
                                        <span class="text-slate-400 italic text-xs">Lowongan Dihapus</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm">
                                    <div class="text-slate-800 font-medium">{{ $pendaftar->university }}</div>
                                    <div class="text-xs text-slate-500">{{ $pendaftar->major }}</div>
                                </td>
                                <td class="p-4 text-sm">
                                    <span class="font-bold px-2 py-0.5 rounded text-xs {{ $pendaftar->ipk >= 3.50 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : ($pendaftar->ipk >= 3.00 ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-rose-50 text-rose-800 border border-rose-200') }} border">
                                        {{ number_format($pendaftar->ipk, 2) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm">
                                    @if($pendaftar->path_cv)
                                        <a href="{{ Storage::url($pendaftar->path_cv) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-800 font-semibold text-xs rounded-lg border border-slate-300 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Unduh CV
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic text-xs">Tidak ada file</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm">
                                    <span class="inline-flex px-2 py-0.5 rounded text-xs font-bold border
                                        {{ $pendaftar->status === 'Approved' ? 'bg-emerald-50 text-emerald-800 border-emerald-250' : ($pendaftar->status === 'Rejected' ? 'bg-rose-50 text-rose-800 border-rose-250' : 'bg-amber-50 text-amber-800 border-amber-250') }}">
                                        {{ $pendaftar->status }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-right space-x-1 whitespace-nowrap">
                                    <!-- Form Approve -->
                                    <form action="{{ route('admin.pendaftar.status', $pendaftar->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Approved">
                                        <button type="submit" {{ $pendaftar->status === 'Approved' ? 'disabled' : '' }} class="inline-flex items-center px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-lg transition-colors disabled:opacity-40 disabled:pointer-events-none shadow-sm">
                                            Setujui
                                        </button>
                                    </form>

                                    <!-- Form Reject -->
                                    <form action="{{ route('admin.pendaftar.status', $pendaftar->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" {{ $pendaftar->status === 'Rejected' ? 'disabled' : '' }} class="inline-flex items-center px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs rounded-lg transition-colors disabled:opacity-40 disabled:pointer-events-none shadow-sm">
                                            Tolak
                                        </button>
                                    </form>
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
