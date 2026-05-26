@extends('layouts.main')

@section('title', 'Status Lamaran Magang')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="space-y-1">
            <h1 class="text-xl md:text-2xl font-bold text-slate-900">Status Lamaran Magang Anda</h1>
            <p class="text-xs text-slate-500">Pantau proses pengajuan berkas dan hasil evaluasi secara berkala.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('pendaftaran.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-lg border border-slate-300 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Lowongan
            </a>
        </div>
    </div>

    <!-- Status List -->
    <div class="space-y-6">
        @if($pendaftars->isEmpty())
            <div class="bg-white border border-slate-200 rounded-xl p-12 text-center flex flex-col items-center justify-center space-y-4 shadow-sm">
                <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Belum Ada Lamaran</h3>
                    <p class="text-xs text-slate-500">Anda belum mendaftar untuk posisi magang manapun saat ini.</p>
                </div>
                <div class="pt-2">
                    <a href="{{ route('pendaftaran.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg shadow-sm transition-colors">
                        Mulai Daftar Magang
                    </a>
                </div>
            </div>
        @else
            @foreach($pendaftars as $applicant)
                <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm space-y-6 {{ $applicant->status === 'Approved' ? 'card-success' : ($applicant->status === 'Rejected' ? 'card-danger' : 'card-warning') }}">
                    <!-- Top Summary -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-4">
                        <div class="space-y-1">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold tracking-wide uppercase bg-slate-100 border border-slate-200 text-slate-700">
                                {{ $applicant->lowongan->departement->name ?? 'N/A' }}
                            </span>
                            <h3 class="text-base font-bold text-slate-900 pt-1">
                                {{ $applicant->lowongan->posisi ?? 'Posisi Dihapus' }}
                            </h3>
                            <p class="text-[10px] text-slate-400">Dikirim pada {{ $applicant->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="flex items-center">
                            @if($applicant->status === 'Pending')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Pending (Menunggu Review)
                                </span>
                            @elseif($applicant->status === 'Approved')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Disetujui (Approved)
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-800 border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Ditolak (Rejected)
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Steps Timeline -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative">
                        <!-- Step 1: Submit -->
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full bg-blue-50 border-2 border-blue-600 flex items-center justify-center text-blue-600 font-bold text-xs">
                                    ✓
                                </div>
                                <div class="w-0.5 h-full bg-slate-200 hidden md:block mt-2"></div>
                            </div>
                            <div class="space-y-0.5">
                                <h4 class="text-xs font-bold text-slate-900">Formulir Masuk</h4>
                                <p class="text-[11px] text-slate-500 leading-relaxed">Berkas CV Anda sudah terdaftar di sistem kami.</p>
                            </div>
                        </div>

                        <!-- Step 2: Evaluation -->
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full {{ $applicant->status !== 'Pending' ? 'bg-blue-50 border-blue-600 text-blue-600' : 'bg-slate-100 border-slate-300 text-slate-400' }} border-2 flex items-center justify-center font-bold text-xs">
                                    @if($applicant->status !== 'Pending') ✓ @else 2 @endif
                                </div>
                            </div>
                            <div class="space-y-0.5">
                                <h4 class="text-xs font-bold {{ $applicant->status !== 'Pending' ? 'text-slate-900' : 'text-slate-400' }}">Peninjauan Berkas</h4>
                                <p class="text-[11px] {{ $applicant->status !== 'Pending' ? 'text-slate-500' : 'text-slate-400' }} leading-relaxed">Tim rekrutmen sedang memeriksa kelayakan data Anda.</p>
                            </div>
                        </div>

                        <!-- Step 3: Result -->
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full 
                                    {{ $applicant->status === 'Approved' ? 'bg-emerald-50 border-emerald-600 text-emerald-600' : ($applicant->status === 'Rejected' ? 'bg-rose-50 border-rose-600 text-rose-600' : 'bg-slate-100 border-slate-300 text-slate-400') }} 
                                    border-2 flex items-center justify-center font-bold text-xs">
                                    @if($applicant->status === 'Approved') ✓ @elseif($applicant->status === 'Rejected') ✕ @else 3 @endif
                                </div>
                            </div>
                            <div class="space-y-0.5">
                                <h4 class="text-xs font-bold 
                                    {{ $applicant->status === 'Approved' ? 'text-emerald-700' : ($applicant->status === 'Rejected' ? 'text-rose-700' : 'text-slate-400') }}">
                                    Keputusan Akhir
                                </h4>
                                <p class="text-[11px] {{ $applicant->status !== 'Pending' ? 'text-slate-500' : 'text-slate-450' }} leading-relaxed">
                                    @if($applicant->status === 'Approved')
                                        Lolos seleksi berkas. Kami akan segera menghubungi Anda untuk tahap wawancara.
                                    @elseif($applicant->status === 'Rejected')
                                        Mohon maaf, profil Anda belum sesuai dengan kebutuhan lowongan saat ini.
                                    @else
                                        Menunggu konfirmasi kelulusan dari Administrator.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Applicant details summary card -->
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg grid grid-cols-2 sm:grid-cols-4 gap-4 text-[11px]">
                        <div>
                            <span class="text-slate-400 uppercase tracking-wider block font-semibold">Universitas</span>
                            <span class="font-bold text-slate-700 mt-0.5 block">{{ $applicant->university }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 uppercase tracking-wider block font-semibold">Jurusan</span>
                            <span class="font-bold text-slate-700 mt-0.5 block">{{ $applicant->major }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 uppercase tracking-wider block font-semibold">IPK Dilaporkan</span>
                            <span class="font-bold text-slate-700 mt-0.5 block">{{ number_format($applicant->ipk, 2) }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 uppercase tracking-wider block font-semibold">Dokumen CV</span>
                            <span class="font-bold mt-0.5 block">
                                <a href="{{ Storage::url($applicant->path_cv) }}" target="_blank" class="text-blue-600 hover:underline">Download CV</a>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
