<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl px-1 py-2 text-white leading-tight">Daftar Produk</h2>
    </x-slot>
    <main class="py-3 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow overflow-x-auto">
            @if(session('success'))
                <div class="bg-green-100 text-blue-700 border border-blue-300 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            {{-- Form Tambah Produk --}}
            <form id="formProduk" action="{{ route('produk.store') }}" method="POST" style="margin-bottom: 15px;" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="produk_id" name="produk_id">
                <div class="form-grid">
                    <div class="form-col">
                        <div class="form-group">
                            <label>Nama :</label>
                            <input type="text" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Beli :</label>
                            <input type="number" name="harga_beli" step="500" min="500" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label>Harga Jual :</label>
                            <input type="number" name="harga_jual" step="500" min="500" required>
                        </div>
                        <div class="form-group">
                            <label>Gambar :</label>
                            <input type="file" name="gambar" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="flex gap-2 mb-4">
                    <x-primary-button type="submit" class="ms-1 bg-green-500 hover:bg-green-600 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                        Tambah
                    </x-primary-button>
                    <x-primary-button id="editBtn" class="text-white px-4 py-2 rounded flex items-center gap-2" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                        Ubah
                    </x-primary-button>
                    <x-danger-button type="button" id="deleteBtn" class="bg-red-600 text-white px-4 py-2 rounded flex items-center gap-2" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                        </svg>
                        Hapus
                    </x-danger-button>
                    <x-secondary-button id="resetBtn" class="bg-gray-400 text-white hover:bg-gray-700 px-4 py-2 rounded flex items-center gap-2">
                        Batal
                    </x-secondary-button>
                </div>
            </form>
            <table class="table-auto w-full bg-white border dark:bg-gray-400 border-gray-200 rounded-lg shadow-md text-sm">
                <thead class="bg-blue-800 dark:bg-gray-700 text-white">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-center">No</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Nama Produk</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Harga Beli</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Harga Jual</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produk as $index => $item)
                        <tr class="cursor-pointer hover:bg-gray-200" data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" data-harga_beli="{{ $item->harga_beli }}" data-harga_jual="{{ $item->harga_jual }}" data-stok="{{ $item->stok }}">
                            <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border nama">{{ $item->nama }}</td>
                            <td class="px-4 py-2 border harga-beli">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border harga-jual">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="gambar produk" class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400 text-xs">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rows = document.querySelectorAll('tbody tr');
            const form = document.querySelector('form');
            const editBtn = document.getElementById('editBtn');
            const deleteBtn = document.getElementById('deleteBtn');
            const resetBtn = document.getElementById('resetBtn');
            const formTitle = document.getElementById('formTitle');
            const previewImage = document.getElementById('previewImage');
            const inputGambar = document.getElementById('gambar');
            let selectedRow = null;
            let selectedId = null;

            // Fungsi saat klik baris tabel
            rows.forEach(row => {
                row.addEventListener('click', function () {
                    rows.forEach(r => r.classList.remove('bg-yellow-100'));

                    this.classList.add('bg-yellow-100');
                    selectedRow = this;
                    selectedId = this.dataset.id;

                    const nama = this.querySelector('.nama').textContent.trim();
                    const hargaBeli = this.querySelector('.harga-beli').textContent.trim();
                    const hargaJual = this.querySelector('.harga-jual').textContent.trim();

                    form.nama.value = nama;
                    form.harga_beli.value = hargaBeli;
                    form.harga_jual.value = hargaJual;
                    form.nama.setAttribute('readonly', true);

                    editBtn.disabled = false;
                    deleteBtn.disabled = false;
                });

                // Tooltip saat hover
                row.setAttribute('title', 'Klik 2x untuk lihat detail');
            });

            // Tombol Edit
            editBtn.addEventListener('click', function () {
                if (!selectedId) return;

                formTitle.textContent = 'Edit Produk';
                form.action = `/produk/${selectedId}`;
                form.method = 'POST'; // tetap POST karena ada _method PUT

                // Tambahkan input _method=PUT
                let methodInput = document.createElement('input');
                methodInput.setAttribute('type', 'hidden');
                methodInput.setAttribute('name', '_method');
                methodInput.setAttribute('value', 'PUT');
                form.appendChild(methodInput);
            });

            // Tombol Reset/Batal (kembali ke mode tambah)
            resetBtn.addEventListener('click', function () {
                form.reset();
                formTitle.textContent = 'Tambah Produk';
                form.action = "{{ route('produk.store') }}";
                form.method = 'POST';
                form.nama.removeAttribute('readonly');

                // Hapus _method PUT jika ada
                const methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();

                // Reset gambar preview
                if (previewImage) previewImage.src = '';

                // Reset seleksi baris
                if (selectedRow) selectedRow.classList.remove('bg-yellow-100');
                selectedRow = null;
                selectedId = null;

                editBtn.disabled = true;
                deleteBtn.disabled = true;
            });

            // Preview gambar saat file dipilih
            if (inputGambar) {
                inputGambar.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            if (previewImage) {
                                previewImage.src = e.target.result;
                            }
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>