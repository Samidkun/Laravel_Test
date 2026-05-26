@extends('layouts.main')

@section('title', 'Tambah Lowongan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="space-y-1">
        <h1 class="text-xl md:text-2xl font-bold text-slate-900">Tambah Lowongan Baru</h1>
        <p class="text-xs text-slate-500">Buat lowongan magang baru untuk departemen terpilih.</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm card-primary">
        <form action="{{ route('admin.lowongan.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Departemen -->
            <div class="space-y-1">
                <label for="dept_id" class="block text-xs font-semibold text-slate-700">Departemen <span class="text-rose-500">*</span></label>
                <select id="dept_id" name="dept_id" class="w-full px-3 py-2 bg-white border border-slate-350 border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors">
                    <option value="" disabled selected>-- Pilih Departemen --</option>
                    @foreach($departements as $dept)
                        <option value="{{ $dept->id }}" {{ old('dept_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                @error('dept_id')
                    <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Posisi & Kuota -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="sm:col-span-2 space-y-1">
                    <label for="posisi" class="block text-xs font-semibold text-slate-700">Nama Posisi <span class="text-rose-500">*</span></label>
                    <input type="text" id="posisi" name="posisi" value="{{ old('posisi') }}" placeholder="Backend Developer Intern" class="w-full px-3 py-2 bg-white border border-slate-350 border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors">
                    @error('posisi')
                        <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="quota" class="block text-xs font-semibold text-slate-700">Kuota (Orang) <span class="text-rose-500">*</span></label>
                    <input type="number" id="quota" name="quota" value="{{ old('quota') }}" min="1" placeholder="5" class="w-full px-3 py-2 bg-white border border-slate-350 border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors">
                    @error('quota')
                        <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="space-y-1">
                <label for="deskripsi" class="block text-xs font-semibold text-slate-700">Deskripsi Pekerjaan <span class="text-rose-500">*</span></label>
                <textarea id="deskripsi" name="deskripsi" rows="5" placeholder="Tulis deskripsi tugas, kualifikasi minimum, dan persyaratan lowongan magang..." class="w-full px-3 py-2 bg-white border border-slate-350 border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="pt-3 flex gap-3 border-t border-slate-100">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg transition-colors shadow-sm">
                    Simpan Lowongan
                </button>
                <a href="{{ route('admin.lowongan.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-lg border border-slate-300 transition-colors text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
