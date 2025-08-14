<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h1 class="text-xl font-extrabold">Data Siswa</h1>
            <div class="mt-4 sm:mt-0 flex items-center space-x-2 ml-auto">
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
    <main class="py-3 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow overflow-x-auto">
            @if(session('success'))
                <div class="bg-green-100 text-blue-700 border border-blue-300 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('siswa.create') }}"
                    class="bg-green-500 text-white px-3 py-2 rounded text-sm hover:bg-green-600 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Tambah Siswa
                </a>
                <div class="flex items-center gap-2">
                    <form id="deleteForm" method="POST" action="" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit" id="deleteBtn" class="bg-red-600 text-white px-4 py-2 rounded flex items-center gap-2" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                            Hapus
                        </x-danger-button>
                    </form>
                </div> 
            </div>
            <table class="table-auto w-full bg-white border dark:bg-gray-400 border-gray-200 rounded-lg shadow-md text-sm">
                <thead class="bg-blue-800 dark:bg-gray-700 text-white">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-center">No</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">NISN</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Nama</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Kelas</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Alamat</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Jenis Kelamin</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $index => $s)
                    <tr class="hover:bg-gray-100 cursor-pointer row-select"
                        title="Klik 2x untuk lihat detail"
                        ondblclick="window.location.href='{{ route('siswa.show', $s->id) }}'"
                        data-id="{{ $s->id }}"
                        data-edit-url="{{ route('siswa.edit', $s->id) }}"
                        data-delete-url="{{ route('siswa.destroy', $s->id) }}">
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border text-center">{{ $s->nis }}</td>
                        <td class="px-4 py-2 border">{{ $s->nama }}</td>
                        <td class="px-4 py-2 border text-center">{{ $s->kelas }}</td>
                        <td class="px-4 py-2 border">{{ $s->alamat }}</td>
                        <td class="px-4 py-2 border text-center capitalize">{{ $s->jeniskelamin }}</td>
                        <td class="px-4 py-2 border text-center">
                            Rp {{ number_format(optional($s->tabungan)->saldo ?? 0, 0, ',', '.') }}
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
        document.addEventListener('DOMContentLoaded', function () {
            const rows = document.querySelectorAll('.row-select');
            const deleteForm = document.getElementById('deleteForm');
            const deleteBtn = document.getElementById('deleteBtn');

            rows.forEach(row => {
                row.addEventListener('click', () => {
                    const deleteUrl = row.dataset.deleteUrl;

                    deleteBtn.disabled = false;

                    deleteForm.action = deleteUrl;

                    // Optional: highlight selected row
                    rows.forEach(r => r.classList.remove('bg-blue-100'));
                    row.classList.add('bg-blue-100');
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
