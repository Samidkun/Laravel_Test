@extends('layouts.main')

@section('title', 'Lowongan Magang Aktif')

@section('content')
<div class="space-y-8">
    <!-- Hero Banner -->
    <div class="bg-white border border-slate-200 rounded-lg p-8 md:p-10 shadow-sm card-primary">
        <div class="max-w-3xl space-y-4">
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-xs font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                Program Magang Mahasiswa 2026
            </span>
            <h1 class="text-2xl md:text-4xl font-bold tracking-tight text-slate-900 leading-tight">
                Mulai Karir Profesional Anda di <span class="text-blue-600">Portal Pendaftaran Magang</span>
            </h1>
            <p class="text-slate-600 text-sm md:text-base leading-relaxed">
                Temukan lowongan magang terbaik yang sesuai dengan bidang studi dan keahlian Anda. Dapatkan pengalaman berharga secara langsung dengan berkolaborasi bersama tim profesional industri.
            </p>
            <div class="pt-2 flex flex-wrap gap-3">
                <a href="{{ route('pendaftaran.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg transition-colors shadow-sm">
                    Daftar Magang
                </a>
                <a href="#lowongan-list" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-lg border border-slate-350 border-slate-300 transition-colors">
                    Lihat Lowongan ({{ $lowongans->count() }})
                </a>
            </div>
        </div>
    </div>

    <!-- Vacancies List Section -->
    <div id="lowongan-list" class="space-y-6">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Lowongan Magang Tersedia</h2>
            <p class="text-xs text-slate-500">Pilih posisi lowongan magang aktif di bawah ini untuk memulai pendaftaran.</p>
        </div>

        @if($lowongans->isEmpty())
            <div class="flex flex-col items-center justify-center p-12 bg-white border border-slate-200 rounded-xl text-center space-y-4 shadow-sm">
                <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Tidak ada lowongan</h3>
                    <p class="text-xs text-slate-500">Saat ini belum ada lowongan magang baru yang dirilis.</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($lowongans as $lowongan)
                    <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm flex flex-col justify-between hover:border-blue-500 hover:shadow-md transition-all card-info">
                        <div class="space-y-4">
                            <!-- Header card -->
                            <div class="flex items-start justify-between gap-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold tracking-wide uppercase bg-slate-100 border border-slate-200 text-slate-700">
                                    {{ $lowongan->departement->name }}
                                </span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $lowongan->quota <= 2 ? 'bg-rose-50 text-rose-800 border border-rose-200' : 'bg-emerald-50 text-emerald-800 border border-emerald-200' }}">
                                    Kuota: {{ $lowongan->quota }}
                                </span>
                            </div>

                            <!-- Position -->
                            <div>
                                <h3 class="text-base font-bold text-slate-900">
                                    {{ $lowongan->posisi }}
                                </h3>
                                <p class="text-[10px] text-slate-400 mt-0.5">Dirilis {{ $lowongan->created_at->diffForHumans() }}</p>
                            </div>

                            <!-- Description -->
                            <p class="text-xs text-slate-650 leading-relaxed line-clamp-3">
                                {{ $lowongan->deskripsi }}
                            </p>
                        </div>

                        <!-- CTA Button -->
                        <div class="pt-4 mt-4 border-t border-slate-100">
                            @if($lowongan->quota > 0)
                                <a href="{{ route('pendaftaran.create_with_id', $lowongan->id) }}" class="w-full flex items-center justify-center gap-1.5 px-3 py-2 bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white font-semibold text-xs rounded-lg border border-blue-200 hover:border-blue-600 transition-colors text-center">
                                    Lamar Posisi Ini
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                <button disabled class="w-full px-3 py-2 bg-slate-100 text-slate-400 font-semibold text-xs rounded-lg border border-slate-200 cursor-not-allowed">
                                    Kuota Terpenuhi
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
