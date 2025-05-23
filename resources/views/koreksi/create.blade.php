<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('siswa.index') }}" class="text-white hover:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Koreksi Saldo - {{ $siswa->nama }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white p-6 shadow rounded">
            <form action="{{ route('koreksi.store', $siswa->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700">Saldo Awal</label>
                    <input type="text" readonly value="Rp{{ number_format($tabungan->saldo ?? 0, 0, ',', '.') }}"
                           class="w-full px-3 py-2 border rounded bg-gray-100">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Koreksi Saldo</label>
                    <input type="number" name="koreksi_saldo" required
                           class="w-full px-3 py-2 border rounded">
                    <small class="text-gray-500">Gunakan angka negatif untuk pengurangan.</small>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Alasan Koreksi</label>
                    <textarea name="alasan" required
                              class="w-full px-3 py-2 border rounded"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Petugas</label>
                    <input type="text" readonly value="{{ Auth::user()->name }}"
                           class="w-full px-3 py-2 border rounded bg-gray-100">
                </div>

                <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Simpan Koreksi
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
