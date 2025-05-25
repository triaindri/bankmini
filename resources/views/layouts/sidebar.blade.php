<!-- resources/views/layouts/sidebar.blade.php -->

<div class="w-64 bg-blue-900 border-r border-gray-200 min-h-screen p-4 hidden sm:block">
    <div class="text-xl text-center font-bold mb-6 text-white">Menu</div>
    <ul class="space-y-2">
        <li>
            <a href="{{ route('dashboard') }}" class="text-white block px-4 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('dashboard') ? 'bg-blue-200 font-semibold' : '' }}">
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('siswa.index') }}" class="text-white block px-4 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('siswa.index') ? 'bg-blue-200 font-semibold' : '' }}">
                Data Siswa
            </a>
        </li>
        @if(Auth::user()->role === 'petugas')
        <li>
            <a href="{{ route('setoran.index') }}" class="text-white block px-4 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('setoran.index') ? 'bg-blue-200 font-semibold' : '' }}">
                Setoran Tabungan
            </a>
        </li>
        <li>
            <a href="{{ route('penarikan.index') }}" class="text-white block px-4 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('penarikan.index') ? 'bg-blue-200 font-semibold' : '' }}">
                Penarikan Tabungan
            </a>
        </li>
        @endif
    </ul>
</div>
