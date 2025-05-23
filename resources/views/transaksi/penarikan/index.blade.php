<x-app-layout>
    <x-slot name="header">
         <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-bold text-white">Penarikan Tabungan</h2>
            <div class="mt-4 sm:mt-0 flex items-center space-x-2">
                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('penarikan.index') }}" class="relative" id="search-form">
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

    <div class="py-6 max-w-6xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            @if(session('success'))
                <div class="bg-green-100 text-blue-700 border border-blue-300 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table-auto w-full bg-white border dark:bg-gray-400 border-gray-200 rounded-lg shadow-md">
                <thead class="bg-blue-700 dark:bg-gray-700 text-white">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-center">No</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">NIS</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Nama</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Saldo</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Penarikan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa as $index => $item)
                        <tr>
                            <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2 text-center">{{ $item->nis }}</td>
                            <td class="border px-4 py-2">{{ $item->nama }}</td>
                            <td class="border px-4 py-2">
                                Rp{{ number_format(optional($item->tabungan)->saldo ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <a href="{{ route('penarikan.create', $item->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded">
                                    Tarik
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
