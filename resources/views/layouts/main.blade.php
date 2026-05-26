<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Magang') - AdminLTE</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:300,400,400i,600,700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f4f6f9;
        }
        /* Custom AdminLTE top borders */
        .card-primary {
            border-top: 3px solid #007bff;
        }
        .card-success {
            border-top: 3px solid #28a745;
        }
        .card-warning {
            border-top: 3px solid #ffc107;
        }
        .card-danger {
            border-top: 3px solid #dc3545;
        }
        .card-info {
            border-top: 3px solid #17a2b8;
        }

        /* Sidebar & Content Transitions */
        #main-sidebar {
            width: 250px;
            transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        #content-wrapper {
            transition: padding-left 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Desktop layout (md and up) */
        @media (min-width: 768px) {
            body.logged-in #main-sidebar {
                transform: translateX(0);
            }
            body.logged-in #content-wrapper {
                padding-left: 250px;
            }
            /* Collapsed state on desktop */
            body.logged-in.sidebar-collapse #main-sidebar {
                transform: translateX(-250px);
            }
            body.logged-in.sidebar-collapse #content-wrapper {
                padding-left: 0;
            }
        }

        /* Mobile layout (smaller than md) */
        @media (max-width: 767.98px) {
            body.logged-in #main-sidebar {
                transform: translateX(-250px);
            }
            body.logged-in #content-wrapper {
                padding-left: 0;
            }
            /* Open state on mobile */
            body.logged-in.sidebar-open #main-sidebar {
                transform: translateX(0);
            }
            body.logged-in.sidebar-open #sidebar-overlay {
                display: block !important;
            }
        }
    </style>
    @yield('styles')
</head>
<body class="bg-[#f4f6f9] text-slate-800 min-h-screen flex flex-col selection:bg-blue-600 selection:text-white relative @auth logged-in @endauth">

    <div class="flex flex-1 min-h-screen relative">
        @auth
        <!-- Left Sidebar (AdminLTE Dark Theme) -->
        <aside id="main-sidebar" class="fixed inset-y-0 left-0 z-50 bg-[#343a40] text-[#c2c7d0] flex flex-col shadow-lg border-r border-[#4b545c]/30 no-print">
            <!-- Brand Logo -->
            <div class="h-14 flex items-center gap-3 px-4 border-b border-[#4b545c] bg-[#343a40] text-white">
                <span class="w-8 h-8 rounded-full bg-[#007bff] flex items-center justify-center text-white font-extrabold text-sm shadow-inner">
                    PM
                </span>
                <span class="font-light tracking-wide text-base">Portal <span class="font-bold">Magang</span></span>
            </div>

            <!-- User Info Panel -->
            <div class="flex items-center gap-3 p-4 border-b border-[#4b545c] bg-[#343a40]/30">
                <div class="w-8 h-8 rounded-full bg-[#6c757d] flex items-center justify-center text-white font-bold text-xs uppercase shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <span class="block text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</span>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">{{ Auth::user()->role }}</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar Navigation Menu -->
            <div class="flex-1 overflow-y-auto px-2 py-3">
                <nav class="space-y-1">
                    @if(Auth::user()->role === 'admin')
                        <!-- Admin Navigation -->
                        <div class="text-[10px] font-bold text-[#6c757d] px-3 uppercase tracking-wider mb-2">Menu Admin</div>
                        
                        <a href="{{ route('admin.lowongan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('admin.lowongan.*') ? 'bg-[#007bff] text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Master Lowongan</span>
                        </a>
                        <a href="{{ route('admin.pendaftar.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('admin.pendaftar.*') ? 'bg-[#007bff] text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Seleksi Pendaftar</span>
                        </a>
                        <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('admin.laporan.*') ? 'bg-[#007bff] text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z" />
                            </svg>
                            <span>Laporan & Analisis</span>
                        </a>
                    @else
                        <!-- Guest Navigation -->
                        <div class="text-[10px] font-bold text-[#6c757d] px-3 uppercase tracking-wider mb-2">Menu Pelamar</div>
                        
                        <a href="{{ route('pendaftaran.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('pendaftaran.index') ? 'bg-[#007bff] text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Lowongan Kerja</span>
                        </a>
                        <a href="{{ route('pendaftaran.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('pendaftaran.create*') ? 'bg-[#007bff] text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Form Pendaftaran</span>
                        </a>
                        <a href="{{ route('pendaftaran.my_status') }}" class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('pendaftaran.my_status') ? 'bg-[#007bff] text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>Status Lamaran</span>
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Sidebar Sign Out Button -->
            <div class="p-3 border-t border-[#4b545c]">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded text-sm bg-rose-600/10 hover:bg-rose-600 text-rose-400 hover:text-white transition-colors cursor-pointer">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/55 hidden no-print" onclick="toggleSidebar()"></div>
        @endauth

        <!-- Right Side Page Wrapper -->
        <div id="content-wrapper" class="flex-1 flex flex-col min-w-0">
            
            <!-- Navbar Header -->
            <header class="h-14 bg-white border-b border-slate-200 flex items-center justify-between px-4 sticky top-0 z-35 no-print">
                <div class="flex items-center gap-3">
                    @auth
                    <!-- Sidebar Toggle Buttons -->
                    <button onclick="toggleSidebar()" class="p-2 text-slate-500 hover:text-slate-900 rounded-lg hover:bg-slate-100 md:hidden focus:outline-none cursor-pointer">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <button onclick="toggleSidebar()" class="p-2 text-slate-500 hover:text-slate-900 rounded-lg hover:bg-slate-100 hidden md:block focus:outline-none cursor-pointer">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    @else
                    <span class="font-bold text-base tracking-tight text-slate-900">
                        Portal<span class="text-[#007bff]">Magang</span>
                    </span>
                    @endauth
                </div>

                <!-- Navbar Right Info -->
                <div class="flex items-center gap-3">
                    @auth
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-slate-200 flex items-center justify-center text-slate-700 font-bold text-xs uppercase">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <span class="text-xs font-semibold text-slate-700 hidden sm:inline-block">{{ Auth::user()->name }}</span>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-3.5 py-1.5 bg-[#007bff] hover:bg-[#0069d9] text-white text-xs font-semibold rounded transition-colors shadow-sm">
                            Sign In
                        </a>
                    @endauth
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-4 md:p-6 bg-[#f4f6f9]">
                @auth
                <!-- Breadcrumbs Header -->
                <div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1.5 no-print">
                    <h1 class="text-lg md:text-xl font-bold text-slate-900">@yield('title', 'Dashboard')</h1>
                    <div class="text-[11px] text-slate-500 flex items-center gap-1 font-medium">
                        <span class="text-slate-400">Home</span>
                        <span class="text-slate-400">&raquo;</span>
                        <span class="text-slate-700 font-semibold">@yield('title', 'Dashboard')</span>
                    </div>
                </div>
                @endauth

                <!-- Alerts and Flash messages -->
                @if(session('success'))
                    <div class="mb-5 flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-850 rounded-lg shadow-sm" id="global-alert">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-xs font-semibold">{{ session('success') }}</span>
                        </div>
                        <button onclick="document.getElementById('global-alert').remove()" class="text-emerald-600 hover:text-emerald-800 transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 flex items-center justify-between p-4 bg-rose-50 border border-rose-200 text-rose-850 rounded-lg shadow-sm" id="global-error-flash">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span class="text-xs font-semibold">{{ session('error') }}</span>
                        </div>
                        <button onclick="document.getElementById('global-error-flash').remove()" class="text-rose-600 hover:text-rose-800 transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-5 p-4 bg-rose-50 border border-rose-200 text-rose-850 rounded-lg shadow-sm" id="global-error">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-xs font-bold">Terdapat beberapa kesalahan input:</span>
                            </div>
                            <button onclick="document.getElementById('global-error').remove()" class="text-rose-600 hover:text-rose-800 transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 text-rose-700 ml-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Yield Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toggle Sidebar Script -->
    <script>
        function toggleSidebar() {
            if (window.innerWidth < 768) {
                document.body.classList.toggle('sidebar-open');
            } else {
                document.body.classList.toggle('sidebar-collapse');
            }
        }
    </script>
</body>
</html>
