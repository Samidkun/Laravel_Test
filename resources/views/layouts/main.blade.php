<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Magang') - Form Pendaftaran Magang</title>
    
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
    @yield('styles')
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col selection:bg-blue-600 selection:text-white relative">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 bg-white border-b border-slate-200 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('pendaftaran.index') }}" class="flex items-center gap-2.5 group">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-extrabold text-base shadow-sm">
                        M
                    </div>
                    <span class="font-bold text-lg tracking-tight text-slate-900">
                        Portal<span class="text-blue-600">Magang</span>
                    </span>
                </a>

                @auth
                    <nav class="hidden md:flex items-center gap-6">
                        <a href="{{ route('pendaftaran.index') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('pendaftaran.index') ? 'text-blue-600 font-semibold' : 'text-slate-500 hover:text-slate-900' }}">
                            Lowongan Kerja
                        </a>
                        <a href="{{ route('pendaftaran.create') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('pendaftaran.create*') ? 'text-blue-600 font-semibold' : 'text-slate-500 hover:text-slate-900' }}">
                            Form Pendaftaran
                        </a>
                        <a href="{{ route('pendaftaran.my_status') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('pendaftaran.my_status') ? 'text-blue-600 font-semibold' : 'text-slate-500 hover:text-slate-900' }}">
                            Status Lamaran
                        </a>
                    </nav>
                @endauth
            </div>

            <!-- Auth & Roles Navigation -->
            <div class="flex items-center gap-4">
                @auth
                    <!-- Admin Navigation -->
                    @if(Auth::user()->role === 'admin')
                        <div class="flex items-center gap-1 bg-slate-100 border border-slate-200 rounded-lg p-0.5">
                            <a href="{{ route('admin.lowongan.index') }}" class="px-3 py-1.5 rounded-md text-xs font-semibold {{ request()->routeIs('admin.lowongan.*') ? 'bg-white text-slate-900 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-900' }} transition-all">
                                Lowongan
                            </a>
                            <a href="{{ route('admin.pendaftar.index') }}" class="px-3 py-1.5 rounded-md text-xs font-semibold {{ request()->routeIs('admin.pendaftar.*') ? 'bg-white text-slate-900 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-900' }} transition-all">
                                Pendaftar
                            </a>
                            <a href="{{ route('admin.laporan.index') }}" class="px-3 py-1.5 rounded-md text-xs font-semibold {{ request()->routeIs('admin.laporan.*') ? 'bg-white text-slate-900 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-900' }} transition-all">
                                Laporan
                            </a>
                        </div>
                    @endif

                    <!-- User Profile & Logout -->
                    <div class="flex items-center gap-3 border-l border-slate-200 pl-4">
                        <div class="hidden sm:block text-right">
                            <div class="text-xs font-bold text-slate-900">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">{{ Auth::user()->role }}</div>
                        </div>

                        <!-- Logout Form Button -->
                        <form action="{{ route('logout') }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" title="Keluar dari akun" class="p-2 bg-slate-100 hover:bg-rose-50 text-slate-500 hover:text-white rounded-lg border border-slate-200 hover:border-rose-100 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-all">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Alerts and Flash messages -->
        @if(session('success'))
            <div class="mb-6 flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl" id="global-alert">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('global-alert').remove()" class="text-emerald-550 hover:text-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 flex items-center justify-between p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl" id="global-error-flash">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button onclick="document.getElementById('global-error-flash').remove()" class="text-rose-550 hover:text-rose-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-55 border border-rose-200 text-rose-800 rounded-xl" id="global-error">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="text-sm font-bold">Terdapat beberapa kesalahan input:</span>
                    </div>
                    <button onclick="document.getElementById('global-error').remove()" class="text-rose-550 hover:text-rose-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-slate-200 bg-white py-6 no-print">
        <div class="max-w-7xl mx-auto px-4 text-center sm:flex sm:justify-between sm:items-center text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} Portal Pendaftaran Magang. All rights reserved.</p>
            <p class="mt-2 sm:mt-0 flex justify-center gap-4">
                <span>Corporate System</span>
                <span>&bull;</span>
                <span>Laravel & Tailwind CSS</span>
            </p>
        </div>
    </footer>

</body>
</html>
