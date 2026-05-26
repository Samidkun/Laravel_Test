<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Portal Pendaftaran Magang</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md space-y-6">
        <!-- Logo Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex w-10 h-10 rounded-lg bg-blue-600 items-center justify-center text-white font-extrabold text-xl shadow-sm">
                M
            </div>
            <h2 class="text-xl font-bold text-slate-900">Portal Pendaftaran Magang</h2>
            <p class="text-xs text-slate-500">Silakan masuk menggunakan akun Anda untuk melanjutkan.</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white border border-slate-200 rounded-xl p-8 shadow-sm">
            
            <!-- Success Alert -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-lg font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Alert -->
            @if(session('error'))
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-lg font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email -->
                <div class="space-y-1">
                    <label for="email" class="block text-xs font-semibold text-slate-700">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@test.com" class="w-full px-3 py-2 bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors" required autofocus>
                    @error('email')
                        <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <label for="password" class="block text-xs font-semibold text-slate-700">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" class="w-full px-3 py-2 bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg text-sm text-slate-800 transition-colors" required>
                    @error('password')
                        <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 block text-xs text-slate-650 cursor-pointer select-none">Ingat saya di perangkat ini</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg transition-colors shadow-sm">
                    Masuk
                </button>
            </form>
        </div>

        <!-- Info / Credentials Help -->
        <div class="p-4 bg-white border border-slate-200 rounded-xl text-center text-xs text-slate-500 space-y-2">
            <span class="font-bold text-slate-700 block">Akun Pengujian Demo:</span>
            <div class="flex justify-center gap-4 text-slate-650">
                <div>
                    <span class="text-blue-600 font-semibold">Admin:</span> admin@test.com
                </div>
                <div>
                    <span class="text-indigo-600 font-semibold">Guest:</span> guest@test.com
                </div>
            </div>
            <div class="text-[10px] text-slate-400">Kata sandi: <span class="font-mono">password</span></div>
        </div>
    </div>

</body>
</html>
