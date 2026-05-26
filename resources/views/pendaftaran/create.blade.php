@extends('layouts.main')

@section('title', 'Form Pendaftaran Magang')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="space-y-1">
        <h1 class="text-xl md:text-2xl font-bold text-slate-900">Formulir Pendaftaran Magang</h1>
        <p class="text-xs md:text-sm text-slate-500">Isi data lengkap Anda untuk mendaftar seleksi program magang mahasiswa.</p>
    </div>

    <!-- Form card -->
    <div class="bg-white border border-slate-200 rounded-xl p-6 md:p-8 shadow-sm">
        <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Lowongan Pilihan -->
            <div class="space-y-1">
                <label for="id_lowongan" class="block text-xs font-semibold text-slate-700">Posisi Magang yang Dilamar <span class="text-rose-500">*</span></label>
                <select id="id_lowongan" name="id_lowongan" class="w-full px-3 py-2 bg-white border border-slate-350 border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors">
                    <option value="" disabled {{ !$selectedLowongan ? 'selected' : '' }}>-- Pilih Posisi --</option>
                    @foreach($lowongans as $lowongan)
                        <option value="{{ $lowongan->id }}" 
                            {{ (old('id_lowongan') == $lowongan->id || ($selectedLowongan && $selectedLowongan->id == $lowongan->id)) ? 'selected' : '' }}
                            {{ $lowongan->quota <= 0 ? 'disabled' : '' }}>
                            {{ $lowongan->posisi }} ({{ $lowongan->departement->name }}) {{ $lowongan->quota <= 0 ? '- [Kuota Penuh]' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('id_lowongan')
                    <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Nama Lengkap -->
                <div class="space-y-1">
                    <label for="name" class="block text-xs font-semibold text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Ahmad Dahlan" class="w-full px-3 py-2 bg-white border border-slate-350 border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors">
                    @error('name')
                        <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-slate-700">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <div class="flex gap-4 pt-1.5">
                        <label class="inline-flex items-center gap-2 cursor-pointer text-sm text-slate-700">
                            <input type="radio" name="gender" value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'checked' : '' }} class="form-radio text-blue-600 border-slate-300 focus:ring-blue-500">
                            <span>Laki-laki</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer text-sm text-slate-700">
                            <input type="radio" name="gender" value="Perempuan" {{ old('gender') === 'Perempuan' ? 'checked' : '' }} class="form-radio text-blue-600 border-slate-300 focus:ring-blue-500">
                            <span>Perempuan</span>
                        </label>
                    </div>
                    @error('gender')
                        <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div class="space-y-1">
                    <label for="dob" class="block text-xs font-semibold text-slate-700">Tanggal Lahir <span class="text-rose-500">*</span></label>
                    <input type="date" id="dob" name="dob" value="{{ old('dob') }}" class="w-full px-3 py-2 bg-white border border-slate-350 border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors">
                    @error('dob')
                        <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div class="space-y-1">
                    <label for="no_telp" class="block text-xs font-semibold text-slate-700">Nomor Telepon <span class="text-rose-500">*</span></label>
                    <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp') }}" placeholder="081234567890" class="w-full px-3 py-2 bg-white border border-slate-350 border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors">
                    @error('no_telp')
                        <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Alamat Lengkap -->
            <div class="space-y-1">
                <label for="adres" class="block text-xs font-semibold text-slate-700">Alamat Lengkap <span class="text-rose-500">*</span></label>
                <textarea id="adres" name="adres" rows="3" placeholder="Tulis alamat tempat tinggal Anda sekarang..." class="w-full px-3 py-2 bg-white border border-slate-350 border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors">{{ old('adres') }}</textarea>
                @error('adres')
                    <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Universitas -->
                <div class="space-y-1">
                    <label for="university" class="block text-xs font-semibold text-slate-700">Universitas <span class="text-rose-500">*</span></label>
                    <input type="text" id="university" name="university" value="{{ old('university') }}" placeholder="Universitas Indonesia" class="w-full px-3 py-2 bg-white border border-slate-350 border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors">
                    @error('university')
                        <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jurusan -->
                <div class="space-y-1">
                    <label for="major" class="block text-xs font-semibold text-slate-700">Jurusan <span class="text-rose-500">*</span></label>
                    <input type="text" id="major" name="major" value="{{ old('major') }}" placeholder="Teknik Informatika" class="w-full px-3 py-2 bg-white border border-slate-350 border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors">
                    @error('major')
                        <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- IPK -->
                <div class="space-y-1">
                    <label for="ipk" class="block text-xs font-semibold text-slate-700">IPK (Maks 4.00) <span class="text-rose-500">*</span></label>
                    <input type="number" id="ipk" name="ipk" value="{{ old('ipk') }}" step="0.01" min="0" max="4.00" placeholder="3.75" class="w-full px-3 py-2 bg-white border border-slate-350 border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors">
                    @error('ipk')
                        <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Upload CV -->
            <div class="space-y-1">
                <label for="cv" class="block text-xs font-semibold text-slate-700">Unggah berkas CV (PDF/DOC/DOCX, Maks 2MB) <span class="text-rose-500">*</span></label>
                <div class="relative w-full flex flex-col items-center justify-center p-5 border border-slate-300 rounded-lg bg-slate-50 hover:bg-slate-100 transition-colors cursor-pointer">
                    <svg class="w-7 h-7 text-slate-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <span class="text-xs text-slate-500 font-medium">Klik atau tarik file dokumen Anda kemari</span>
                    <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                </div>
                @error('cv')
                    <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="pt-3 flex gap-3 border-t border-slate-100">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg transition-colors shadow-sm">
                    Kirim Lamaran
                </button>
                <a href="{{ route('pendaftaran.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-lg border border-slate-300 transition-colors text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
