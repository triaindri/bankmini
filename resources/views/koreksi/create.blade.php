<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Koreksi Saldo - {{ $siswa->nama }}
        </h2>
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
