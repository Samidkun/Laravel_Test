@extends('layouts.main')

@section('title', 'Manage Lowongan (Admin)')

@section('content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-slate-900">Master Lowongan</h1>
            <p class="text-xs md:text-sm text-slate-500">Kelola kuota, departemen, dan kualifikasi lowongan magang aktif.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.lowongan.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Lowongan
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm card-primary">
        @if($lowongans->isEmpty())
            <div class="p-12 text-center flex flex-col items-center justify-center space-y-4">
                <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Belum Ada Lowongan</h3>
                    <p class="text-xs text-slate-500">Mulai dengan menambahkan data lowongan kerja magang baru.</p>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-slate-700">
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">No</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Posisi</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Departemen</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Kuota</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Deskripsi</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider">Dibuat Oleh</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($lowongans as $idx => $lowongan)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-4 text-sm text-slate-500">{{ $idx + 1 }}</td>
                                <td class="p-4 text-sm font-semibold text-slate-900">{{ $lowongan->posisi }}</td>
                                <td class="p-4 text-sm">
                                    <span class="inline-flex px-2 py-0.5 rounded bg-slate-100 border border-slate-200 text-xs font-medium text-slate-650 text-slate-700">
                                        {{ $lowongan->departement->name }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm">
                                    <span class="inline-flex px-2 py-0.5 rounded text-xs font-bold {{ $lowongan->quota <= 2 ? 'bg-rose-50 text-rose-800 border border-rose-200' : 'bg-emerald-50 text-emerald-800 border border-emerald-200' }}">
                                        {{ $lowongan->quota }} orang
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-slate-600 max-w-xs truncate" title="{{ $lowongan->deskripsi }}">
                                    {{ $lowongan->deskripsi }}
                                </td>
                                <td class="p-4 text-xs text-slate-500">
                                    {{ $lowongan->creator->name ?? 'Admin' }}
                                </td>
                                <td class="p-4 text-sm text-right space-x-1 whitespace-nowrap">
                                    <!-- Edit Link -->
                                    <a href="{{ route('admin.lowongan.edit', $lowongan->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-white hover:bg-amber-50 text-amber-700 hover:text-amber-800 font-semibold text-xs rounded-lg border border-slate-250 border-slate-300 hover:border-amber-400 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.lowongan.destroy', $lowongan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-white hover:bg-rose-50 text-rose-700 hover:text-rose-800 font-semibold text-xs rounded-lg border border-slate-250 border-slate-300 hover:border-rose-400 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
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
