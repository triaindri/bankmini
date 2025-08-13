<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-white">
            🔔 Notifikasi untuk {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded-lg shadow">
        <!-- Filter -->
        <div class="flex justify-between items-center mb-4">
            <div>
                Berdasarkan Jenis :
                <select id="filter" class="border rounded px-2 py-1">
                    <option value="">-- Pilih Jenis Notifikasi --</option>
                    <option value="Semua">Semua</option>
                    <option value="Pengumuman">Pengumuman</option>
                    <option value="Transaksi">Transaksi</option>
                </select>
            </div>
            <div class="text-gray-500 text-sm">
                Semua / Pengumuman / Transaksi
            </div>
        </div>

        <!-- List Notifikasi -->
        <div id="list-notifikasi" class="space-y-2">
            @forelse($notifikasi as $n)
                <div class="flex items-center justify-between bg-{{ $n['warna'] }}-100 p-3 rounded shadow-sm"
                     data-jenis="{{ $n['jenis'] }}">
                    <div class="flex items-center gap-3">
                        <span class="text-{{ $n['warna'] }}-600 text-xl">{{ $n['icon'] }}</span>
                        <div>
                            <div class="font-bold text-{{ $n['warna'] }}-600">
                                {{ \Carbon\Carbon::parse($n['tanggal'])->translatedFormat('d F Y') }}
                            </div>
                            <div class="text-{{ $n['warna'] }}-600">
                                {{ $n['pesan'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-6">
                    Belum ada notifikasi
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.getElementById('filter').addEventListener('change', function() {
            let jenis = this.value;
            document.querySelectorAll('#list-notifikasi > div').forEach(el => {
                if (jenis === '' || jenis === 'Semua' || el.dataset.jenis === jenis) {
                    el.style.display = 'flex';
                } else {
                    el.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>
