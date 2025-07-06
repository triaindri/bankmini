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
                <a href="{{ route('siswa.index') }}" class="block text-white dark:text-gray-200">Data Siswa</a>
                <a href="{{ route('setoran.index') }}" class="block text-white dark:text-gray-200">Setoran Tabungan</a>
                <a href="{{ route('penarikan.index') }}" class="block text-white dark:text-gray-200">Penarikan Tabungan</a>
                <a href="{{ route('produk.index') }}" class="block text-white dark:text-gray-200">Produk</a>
            </nav>

            <!-- Profil dan Logout -->
            <div class="mt-10 border-t pt-4 text-sm text-white dark:text-gray-300">
                <div>{{ Auth::user()->name }}</div>
                <div>{{ Auth::user()->email }}</div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="text-red-400 hover:underline">Logout</button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header with Hamburger -->
            <header class="bg-white dark:bg-gray-800 p-4 shadow md:hidden flex items-center justify-between">
                <button @click="open = !open" class="text-gray-800 dark:text-white focus:outline-none">
                    <!-- Hamburger Icon -->
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </header>

            <!-- Page Header -->
            @isset($header)
                <div class="bg-blue-800 dark:bg-gray-700 shadow px-4 py-3 text-white">
                    {{ $header }}
                </div>
            @endisset

            <!-- Page Content -->
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
