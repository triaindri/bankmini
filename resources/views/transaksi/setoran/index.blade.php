<x-app-layout>
    <x-slot name="header">
         <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-bold text-gray-800">Setoran Tabungan</h2>
            <div class="mt-4 sm:mt-0 flex items-center space-x-2">
                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('setoran.index') }}" class="relative" id="search-form">
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
                <div class="bg-green-100 text-green-700 border border-green-300 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table-auto w-full text-sm border">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="border px-4 py-2">No</th>
                        <th class="border px-4 py-2">NIS</th>
                        <th class="border px-4 py-2">Nama</th>
                        <th class="border px-4 py-2">Saldo</th>
                        <th class="border px-4 py-2">Setor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa as $index => $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2">{{ $item->nis }}</td>
                            <td class="border px-4 py-2">{{ $item->nama }}</td>
                            <td class="border px-4 py-2">
                                Rp{{ number_format(optional($item->tabungan)->saldo ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="border px-4 py-2">
                                <form action="{{ route('setoran.store') }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menyetor saldo?')"
                                      class="flex items-center space-x-2">
                                    @csrf
                                    <input type="hidden" name="siswa_id" value="{{ $item->id }}">
                                    <input type="number" name="jumlah" placeholder="Jumlah"
                                           class="border rounded px-2 py-1 w-24 text-sm" required min="1000">
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded">
                                        Setor
                                    </button>
                                </form>
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
