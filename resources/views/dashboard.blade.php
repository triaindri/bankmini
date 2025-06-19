<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl px-1 py-2 text-white leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
        </div>

    </div>

    @push('scripts')
    <!-- Include Chart.js dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        // Chart Transaksi Tabungan
        const ctxTransaksi = document.getElementById('chartTransaksi').getContext('2d');
        new Chart(ctxTransaksi, {
            type: 'line',
            data: {
                labels: transaksiLabels,
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: transaksiData,
                    borderColor: 'rgb(34, 197, 94)', // hijau
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } }
            }
        });

        // Chart Penjualan
        const ctxPenjualan = document.getElementById('chartPenjualan').getContext('2d');
        new Chart(ctxPenjualan, {
            type: 'line',
            data: {
                labels: penjualanLabels,
                datasets: [{
                    label: 'Jumlah Penjualan',
                    data: penjualanData,
                    borderColor: 'rgb(239, 68, 68)', // merah
                    backgroundColor: 'rgba(239, 68, 68, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
    @endpush
</x-app-layout>
