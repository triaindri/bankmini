<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('siswa.create') }}"
                class="bg-green-500 text-white px-3 py-2 rounded text-sm hover:bg-green-600">
                + Tambah Siswa
            </a>
            
            <div class="mt-4 sm:mt-0 flex items-center space-x-2">
                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('siswa.index') }}" class="relative" id="search-form">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 
                                1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 
                                6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </div>
                    <input type="text" name="q" id="search-input" value="{{ request('q') }}" placeholder="Cari nama / NIS"
                        class="px-12 py-2 border rounded text-sm focus:outline-none focus:ring">
                    <button type="submit"
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <main class="max-w-7xl mx-auto mt-6 px-4">
        <table class="table-auto w-full bg-white border dark:bg-gray-400 border-gray-200 rounded-lg shadow-md">
            <thead class="bg-blue-400 dark:bg-gray-700 text-white">
                <tr>
                    <th class="border border-gray-300 px-4 py-3 text-center">No</th>
                    <th class="border border-gray-300 px-4 py-3 text-center">NIS</th>
                    <th class="border border-gray-300 px-4 py-3 text-center">Nama</th>
                    <th class="border border-gray-300 px-4 py-3 text-center">Saldo</th>
                    <th class="border border-gray-300 px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $index => $siswa)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border text-center">{{ $siswa->nis }}</td>
                    <td class="px-4 py-2 border">{{ $siswa->nama }}</td>
                    <td class="px-4 py-2 border">
                        Rp {{ number_format(optional($siswa->tabungan)->saldo ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2 border text-center">
                        <a href="{{ route('koreksi.create', $siswa->id) }}"
                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                        Koreksi Saldo
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
    @push('scripts')
    <script>
        const input = document.getElementById('search-input');
        const form = document.getElementById('search-form');

        input.addEventListener('input', function () {
            if (this.value.trim() === '') {
                form.submit(); 
            }
        });
    </script>
    @endpush

</x-app-layout>
