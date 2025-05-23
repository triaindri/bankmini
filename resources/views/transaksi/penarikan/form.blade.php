<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('penarikan.index') }}" class="text-white hover:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-xl font-bold text-white">Form Penarikan - {{ $siswa->nama }}</h2>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto py-6">
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('penarikan.store') }}" method="POST" class="bg-white shadow p-6 rounded space-y-4">
            @csrf
            <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

            <div>
                <label class="block font-medium">Saldo Saat Ini </label>
                <div class="text-gray-700">
                    Rp{{ number_format(optional($siswa->tabungan)-> saldo ?? 0, 0, ',', '.') }}
                </div>
            </div>

            <div>
                <label class="block font-medium">Nominal Penarikan</label>
                <input type="number" name="jumlah" min="1000" step="1000" required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                       placeholder="Masukkan jumlah penarikan">
            </div>

            <div>
                <label class="block font-medium">Jenis Penarikan</label>
                <select name="jenis" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Jenis --</option>
                    @foreach($jenisPenarikan as $jenis)
                        <option value="{{ $jenis }}">{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Tarik
            </button>
        </form>
    </div>
</x-app-layout>
