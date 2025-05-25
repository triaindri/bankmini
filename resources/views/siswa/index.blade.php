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

    <main class="py-6 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow overflow-x-auto">
            @if(session('success'))
                <div class="bg-green-100 text-blue-700 border border-blue-300 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table-auto w-full bg-white border dark:bg-gray-400 border-gray-200 rounded-lg shadow-md text-sm">
                <thead class="bg-blue-700 dark:bg-gray-700 text-white">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-center">No</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">NIS</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Nama</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Kelas</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Alamat</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Jenis Kelamin</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Saldo</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $index => $s)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border text-center">{{ $s->nis }}</td>
                        <td class="px-4 py-2 border">{{ $s->nama }}</td>
                        <td class="px-4 py-2 border text-center">{{ $s->kelas }}</td>
                        <td class="px-4 py-2 border">{{ $s->alamat }}</td>
                        <td class="px-4 py-2 border text-center capitalize">{{ $s->jeniskelamin }}</td>
                        <td class="px-4 py-2 border text-center">
                            Rp {{ number_format(optional($s->tabungan)->saldo ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-2 border text-center">
    <a href="{{ route('koreksi.create', $s->id) }}"
       class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm inline-flex items-center space-x-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
        </svg>
        <span>Koreksi Saldo</span>
    </a>
</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
