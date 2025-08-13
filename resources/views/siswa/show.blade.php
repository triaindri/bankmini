<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('siswa.index') }}" class="text-white hover:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl text-white font-semibold">Detail Siswa</h1>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm font-mono">
                <div><strong>NISN :</strong> {{ $siswa->nis }}</div>
                <div><strong>Nama :</strong> {{ $siswa->nama }}</div>
                <div><strong>Kelas :</strong> {{ $siswa->kelas }}</div>
                <div><strong>Jenis Kelamin :</strong> {{ ucfirst($siswa->jeniskelamin) }}</div>
                <div><strong>Email :</strong> {{ $siswa->email }}</div>
                <div><strong>No. Telepon :</strong> {{ $siswa->telepon }}</div>
                <div><strong>Tempat Lahir :</strong> {{ $siswa->tempat_lahir }}</div>
                <div><strong>Tanggal Lahir :</strong> {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') }}</div>
                <div class="col-span-2"><strong>Alamat :</strong> {{ $siswa->alamat }}</div>
                <div><strong>Saldo Tabungan :</strong> Rp {{ number_format(optional($siswa->tabungan)->saldo ?? 0, 0, ',', '.') }}</div>
            </div>

            <!-- Tombol Edit di Bawah Card -->
            <div class="text-right mt-6">
                <a href="{{ route('siswa.edit', $siswa->id) }}">
                    <x-primary-button id="editBtn" class="text-white px-4 py-2 rounded flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 
                                    .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 
                                    2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 
                                    1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 
                                    0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                        Ubah / Lengkapi Data
                    </x-primary-button>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
