<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - Portal ISO 9001')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-slate-900 text-white shadow-lg">
            <!-- Logo -->
            <div class="p-6 border-b border-slate-700">
                <h1 class="text-2xl font-bold">ISO 9001</h1>
                <p class="text-slate-400 text-sm mt-1">Portal Manajemen</p>
            </div>

            <!-- Navigation -->
            <nav class="mt-8 px-4 space-y-2">
                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-white bg-blue-600 transition-colors"
                >
                    <span class="mr-3">📊</span>
                    <span>Dashboard</span>
                </a>

                <a
                    href="#"
                    class="flex items-center px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 transition-colors"
                >
                    <span class="mr-3">📋</span>
                    <span>Dokumen</span>
                </a>

                <a
                    href="#"
                    class="flex items-center px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 transition-colors"
                >
                    <span class="mr-3">⚙️</span>
                    <span>Pengaturan</span>
                </a>

                <a
                    href="#"
                    class="flex items-center px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 transition-colors"
                >
                    <span class="mr-3">👥</span>
                    <span>Tim</span>
                </a>
            </nav>

            <!-- User Section -->
            <div class="absolute bottom-0 left-0 w-64 border-t border-slate-700 p-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold">{{ Auth::user()->email }}</p>
                        <p class="text-xs text-slate-400">Pengguna</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-lg transition-colors text-sm"
                    >
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white border-b border-slate-200 px-8 py-4 shadow-sm">
                <h2 class="text-2xl font-bold text-slate-900">@yield('header', 'Dashboard')</h2>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
