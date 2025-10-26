<x-app-layout>
   <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="text-xl font-extrabold text-white">Pembelian Produk</h2>
            <div class="mt-4 sm:mt-0 flex items-center space-x-2">
                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('produk.index') }}" class="relative" id="search-form">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 
                                1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 
                                6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </div>
                    <input type="text" name="q" id="search-input" value="{{ request('q') }}"
                        placeholder="Cari nama produk"
                        class="px-12 py-2 border rounded text-sm focus:outline-none focus:ring text-black">
                    <button type="submit"
                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <main class="py-3 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow overflow-x-auto">
            @if(session('success'))
                <div class="bg-green-100 text-blue-700 border border-blue-300 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form id="formProduk" action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="produk_id" name="produk_id">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label>Nama Produk :</label>
                        <input type="text" name="nama" id="nama" required class="w-full border rounded px-2 py-1">

                        <label>Harga Beli :</label>
                        <input type="number" name="harga_beli" id="harga_beli" step="500" min="500" required class="w-full border rounded px-2 py-1">

                        <label>Stok :</label>
                        <input type="number" name="stok" id="stok" min="0" required class="w-full border rounded px-2 py-1">
                    </div>
                    <div>
                        <label>Harga Jual :</label>
                        <input type="number" name="harga_jual" id="harga_jual" step="500" min="500" required class="w-full border rounded px-2 py-1">

                        <label>Gambar :</label>
                        <input type="file" name="gambar" id="gambar" accept="image/*" class="w-full">
                        <img id="previewImage" src="" class="w-16 h-16 object-cover mt-2 hidden">
                    </div>
                </div>

                <div class="flex gap-2 mt-4">
                    <x-primary-button type="submit" class="bg-green-500 hover:bg-green-600 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                        Tambah
                    </x-primary-button>

                    <x-primary-button type="button" id="editBtn" class="bg-yellow-500 hover:bg-yellow-600 text-white flex items-center gap-2" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                        Ubah
                    </x-primary-button>

                    <x-danger-button type="button" id="deleteBtn" class="bg-red-600 text-white flex items-center gap-2" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                        </svg>
                        Hapus
                    </x-danger-button>

                    <x-secondary-button type="button" id="resetBtn" class="bg-gray-600 text-white hover:bg-gray-200 hover:text-gray-700 px-4 py-2 rounded flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                        </svg>
                        Batal
                    </x-secondary-button>
                </div>
            </form>

            {{-- Tabel Produk --}}
            <table class="table-auto w-full mt-6 border rounded shadow text-sm">
                <thead class="bg-blue-800 text-white">
                    <tr>
                        <th class="border px-4 py-2 text-center">No</th>
                        <th class="border px-4 py-2 text-center">Nama</th>
                        <th class="border px-4 py-2 text-center">Harga Beli</th>
                        <th class="border px-4 py-2 text-center">Harga Jual</th>
                        <th class="border px-4 py-2 text-center">Stok</th>
                        <th class="border px-4 py-2 text-center">Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produk as $index => $item)
                        <tr class="cursor-pointer hover:bg-gray-200" 
                            data-id="{{ $item->id }}"
                            data-nama="{{ $item->nama }}"
                            data-harga_beli="{{ $item->harga_beli }}"
                            data-harga_jual="{{ $item->harga_jual }}"
                            data-stok="{{ $item->stok }}"
                        >
                            <td class="border text-center px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2">{{ $item->nama }}</td>
                            <td class="border px-4 py-2">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            <td class="border px-4 py-2">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td class="border text-center px-4 py-2">{{ $item->stok }}</td>
                            <td class="border px-4 py-2 text-center">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="w-12 h-12 object-cover rounded mx-auto">
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
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('formProduk');
            const nama = document.getElementById('nama');
            const hargaBeli = document.getElementById('harga_beli');
            const hargaJual = document.getElementById('harga_jual');
            const inputGambar = document.getElementById('gambar');
            const previewImage = document.getElementById('previewImage');
            const produkIdInput = document.getElementById('produk_id');

            const editBtn = document.getElementById('editBtn');
            const deleteBtn = document.getElementById('deleteBtn');
            const resetBtn = document.getElementById('resetBtn');

            let selectedId = null;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.querySelectorAll('tbody tr').forEach(row => {
                row.addEventListener('click', () => {
                document.querySelectorAll('tbody tr').forEach(r => r.classList.remove('bg-blue-100'));
                row.classList.add('bg-blue-100');

                selectedId = row.dataset.id;
                produkIdInput.value = selectedId;

                nama.value = row.dataset.nama;
                hargaBeli.value = row.dataset.harga_beli;
                hargaJual.value = row.dataset.harga_jual;

                const stok = document.getElementById('stok');
                stok.value = row.dataset.stok; // <<< BARIS INI YANG PENTING

                editBtn.disabled = false;
                deleteBtn.disabled = false;

                form.action = `/produk/${selectedId}`;
                let methodInput = form.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    form.appendChild(methodInput);
                }
                methodInput.value = 'PUT';
            });
            });

            editBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (!selectedId) return;

                form.submit();
            });

            deleteBtn.addEventListener('click', function () {
                if (!selectedId || !confirm("Yakin ingin menghapus produk ini?")) return;

                const deleteForm = document.createElement('form');
                deleteForm.action = `/produk/${selectedId}`;
                deleteForm.method = 'POST';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = csrfToken;

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                deleteForm.appendChild(csrf);
                deleteForm.appendChild(method);
                document.body.appendChild(deleteForm);
                deleteForm.submit();
            });

            resetBtn.addEventListener('click', function () {
                form.reset();
                selectedId = null;
                produkIdInput.value = '';

                // nama.removeAttribute('readonly'); // kalau kamu sebelumnya set readonly
                form.action = "{{ route('produk.store') }}";

                const method = form.querySelector('input[name="_method"]');
                if (method) method.remove();

                previewImage.src = '';
                previewImage.classList.add('hidden');

                document.querySelectorAll('tbody tr').forEach(r => r.classList.remove('bg-blue-100'));
                editBtn.disabled = true;
                deleteBtn.disabled = true;
            });

            inputGambar.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden');
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
