<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
    <div x-data="{ open: false }" class="min-h-screen flex bg-blue-100 dark:bg-gray-900">

        <!-- Sidebar -->
        <div :class="open ? 'block' : 'hidden'" class="md:block w-64 bg-blue-900 dark:bg-gray-800 p-4 space-y-4">

        <!-- Logo -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="h-8 w-auto text-gray-800 dark:text-gray-200" />
                </a>
            </div>

            <!-- Menu -->
            <nav class="space-y-2">
                @hasrole('koordinator|petugas')
                    <a href="{{ route('siswa.index') }}" class="block text-white">Data Siswa</a>
                @endhasrole

                @hasrole('petugas')
                    <a href="{{ route('setoran.index') }}" class="block text-white">Setoran Tabungan</a>
                    <a href="{{ route('penarikan.index') }}" class="block text-white">Penarikan Tabungan</a>
                @endhasrole

                @hasrole('koordinator|petugas')
                    <a href="{{ route('produk.index') }}" class="block text-white">Pembelian Produk</a>
                @endhasrole

                @hasrole('petugas')
                    <a href="{{ route('penjualan.create') }}" class="block text-white">Transaksi Penjualan</a>
                    <a href="{{ route('pembelian.create') }}" class="block text-white">Daftar Produk</a>
                @endhasrole

                {{-- Sidebar siswa --}}
                @role('siswa')
                    <a href="{{ route('dashboard') }}" class="block text-white">Dashboard</a>
                    <a href="{{ route('siswa.riwayat') }}" class="block text-white">Riwayat Transaksi</a>
                    <a href="{{ route('pembelian.create') }}" class="block text-white">Daftar Produk</a>
                    <a href="{{ route('siswa.notifikasi') }}" class="block text-white">Notifikasi</a>
                @endrole
            </nav>

            <!-- Profil + Logout hanya untuk koordinator/petugas -->
            @hasrole('koordinator|petugas')
            <div class="mt-10 border-t pt-4 text-sm text-white">
                <div>{{ Auth::user()->name }}</div>
                <div>{{ Auth::user()->email }}</div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="text-red-400 hover:underline">Logout</button>
                </form>
            </div>
            @endhasrole
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">

            <!-- Header -->
            <header class="bg-blue-800 text-white px-6 py-4 shadow flex items-center justify-between">
    <div class="md:hidden">
        <button @click="open = !open" class="focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Judul dan Form Pencarian --}}

    @isset($header)
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between w-full">
            {{ $header }}
        </div>
    @endisset

                {{-- Profil siswa di pojok kanan atas --}}
                @role('siswa')
                <div class="relative" x-data="{ openProfile: false }">
                    <button @click="openProfile = !openProfile" class="flex items-center gap-3 focus:outline-none">
                        <!-- Foto Profil -->
                        <img src="https://0.soompi.io/wp-content/uploads/2023/01/23135155/Beomgyu-1-1.jpeg"
                            alt="Foto Profil"
                            class="w-10 h-10 rounded-full object-cover border border-gray-300">

                        <!-- Nama & Email -->
                        <div class="hidden sm:block text-left">
                            <div class="text-sm font-bold">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-300">{{ Auth::user()->email }}</div>
                        </div>

                        <!-- Icon Arrow -->
                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="openProfile"
                        @click.away="openProfile = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg overflow-hidden z-50">
                        <!-- Kalau belum ada halaman pengaturan profil -->
                        <div class="block px-4 py-2 text-gray-400">Pengaturan Profil</div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                @endrole
            </header>

            <!-- Page Content -->
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

@stack('scripts')
</body>
</html>
