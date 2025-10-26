<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl px-1 py-2 text-white leading-tight">Dashboard</h2>
    </x-slot>
    
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @hasrole('koordinator|petugas')
        {{-- Card Summary --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 mb-6">
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <h3 class="text-lg font-semibold">Jumlah Siswa Menabung</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $jumlahSiswa }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <h3 class="text-lg font-semibold">Total Tabungan Hari Ini</h3>
                <p class="text-3xl font-bold text-green-600">
                    Rp {{ number_format($totalNominalTabunganHariIni, 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <h3 class="text-lg font-semibold">Penjualan Hari Ini</h3>
                <p class="text-3xl font-bold text-red-600">{{ $penjualanHariIni }}</p>
            </div>
        </div>

        {{-- Grafik --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Grafik Jumlah Siswa Menabung Tahunan -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Jumlah Siswa Menabung Per Bulan (Tahun Ini)</h3>
                <canvas id="chartTahunan"></canvas>
            </div>

            <!-- Grafik Transaksi Tabungan Mingguan -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Transaksi Tabungan Mingguan</h3>
                <canvas id="chartTransaksi"></canvas>
            </div>

            <!-- Grafik Penjualan Mingguan -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Penjualan Mingguan</h3>
                <canvas id="chartPenjualan"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Include Chart.js dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Grafik Tahunan Siswa Menabung
        const labelsTahunan = @json($labelsGrafikTahunan);
        const dataTahunan = @json($dataGrafikTahunan);

        const ctxTahunan = document.getElementById('chartTahunan').getContext('2d');
        new Chart(ctxTahunan, {
            type: 'line',
            data: {
                labels: labelsTahunan,
                datasets: [{
                    label: 'Jumlah Siswa Menabung',
                    data: dataTahunan,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: { y: { beginAtZero: true, precision: 0 } }
            }
        });

        // Grafik Transaksi Tabungan Mingguan
        const transaksiLabels = @json($transaksiMingguan->pluck('tanggal'));
        const transaksiData = @json($transaksiMingguan->pluck('total'));

        const ctxTransaksi = document.getElementById('chartTransaksi').getContext('2d');
        new Chart(ctxTransaksi, {
            type: 'line',
            data: {
                labels: transaksiLabels,
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: transaksiData,
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });

        // Grafik Penjualan Mingguan
        const penjualanLabels = @json($penjualanMingguan->pluck('tanggal'));
        const penjualanData = @json($penjualanMingguan->pluck('total'));

        const ctxPenjualan = document.getElementById('chartPenjualan').getContext('2d');
        new Chart(ctxPenjualan, {
            type: 'line',
            data: {
                labels: penjualanLabels,
                datasets: [{
                    label: 'Jumlah Penjualan',
                    data: penjualanData,
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });
    </script>
    @endpush
    @endhasrole
    @hasrole('siswa')
    <div class="flex min-h-screen bg-blue-900 text-white">
        <main class="flex-1 bg-blue-100 px-8 pt-1 p-8 text-gray-900">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h1 class="text-xl font-bold text-gray-800">
                    Halo, {{ Auth::user()->name }}!
                </h1>
                <p class="mb-4 mt-3 text-gray-700">
                    💰 Saldo tabungan Anda :
                    <span class="font-semibold text-green-600">
                        Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}
                    </span>
                </p>
                <p class="text-sm text-gray-500 text-right">
                    Hari ini : {{ now()->translatedFormat('d F Y') }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded p-4 shadow">
                    <p class="font-semibold">Setoran Bulan Ini</p>
                    <p class="text-2xl font-bold text-blue-800">
                        Rp {{ number_format($setoranBulanIni, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white rounded p-4 shadow">
                    <p class="font-semibold">Penarikan Bulan Ini</p>
                    <p class="text-2xl font-bold text-green-600">
                        Rp {{ number_format($penarikanBulanIni, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="bg-blue-200 rounded p-4 shadow">
                <p class="font-semibold text-red-600">📌 Transaksi Terakhir :</p>
                @foreach ($transaksiTerakhir as $transaksi)
                    <p>
                        {{ ucfirst($transaksi->jenis) }} :
                        Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                        ( {{ $transaksi->created_at->translatedFormat('d F Y') }} )
                        @if($transaksi->keterangan)
                            - {{ $transaksi->keterangan }}
                        @endif
                    </p>
                @endforeach
            </div>
        </main>
    </div>
    @endhasrole
</x-app-layout>
