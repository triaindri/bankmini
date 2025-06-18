<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl px-1 py-2 text-white leading-tight">Manajemen Produk</h2>
    </x-slot>
    <main class="py-3 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow overflow-x-auto">
            @if(session('success'))
                <div class="bg-green-100 text-blue-700 border border-blue-300 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            {{-- Form Tambah Produk --}}
            <form id="formProduk" action="{{ route('produk.store') }}" method="POST" style="margin-bottom: 15px;">
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
                            <label>Stok :</label>
                            <input type="number" name="stok" required>
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
                </div>
            </form>
            <table class="table-auto w-full bg-white border dark:bg-gray-400 border-gray-200 rounded-lg shadow-md text-sm">
                <thead class="bg-blue-800 dark:bg-gray-700 text-white">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-center">No</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Nama Produk</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Harga Beli</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Harga Jual</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produk as $index => $item)
                        <tr class="cursor-pointer hover:bg-gray-200" data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" data-harga_beli="{{ $item->harga_beli }}" data-harga_jual="{{ $item->harga_jual }}" data-stok="{{ $item->stok }}">
                            <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $item->nama }}</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border text-center">{{ $item->stok }}</td>
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
        const form = document.getElementById('formProduk');
        const editBtn = document.getElementById('editBtn');
        const deleteBtn = document.getElementById('deleteBtn');

        let selectedRow = null;

        rows.forEach(row => {
            row.addEventListener('click', () => {
                // Tandai baris yang dipilih
                if (selectedRow) selectedRow.classList.remove('bg-yellow-100');
                selectedRow = row;
                selectedRow.classList.add('bg-yellow-100');

                // Isi form dengan data produk
                form.produk_id.value = row.dataset.id;
                form.nama.value = row.dataset.nama;
                form.harga_beli.value = row.dataset.harga_beli;
                form.harga_jual.value = row.dataset.harga_jual;
                form.stok.value = row.dataset.stok;

                // Nama produk tidak boleh diedit saat edit
                form.nama.setAttribute('readonly', true);

                // Enable tombol edit dan hapus
                editBtn.disabled = false;
                deleteBtn.disabled = false;
            });
        });

        // Edit button klik -> submit form ke route update (kamu perlu sediakan route update)
        editBtn.addEventListener('click', () => {
            if (!form.produk_id.value) return alert('Pilih produk terlebih dahulu.');

            // Ubah action form ke route update produk (pastikan route ini ada)
            form.action = `/produk/${form.produk_id.value}`; // misal RESTful update route
            form.method = 'POST';

            // Tambahkan _method PUT untuk Laravel
            let methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';

            // Hapus dulu kalau ada input _method lama
            const existingMethodInput = form.querySelector('input[name="_method"]');
            if (existingMethodInput) existingMethodInput.remove();
            form.appendChild(methodInput);

            form.submit();
        });

        // Hapus button klik -> konfirmasi lalu submit ke route delete
        deleteBtn.addEventListener('click', () => {
            if (!form.produk_id.value) return alert('Pilih produk terlebih dahulu.');

            if (confirm('Yakin ingin menghapus produk ini?')) {
                // Buat form baru untuk delete (karena form utama method POST)
                const deleteForm = document.createElement('form');
                deleteForm.action = `/produk/${form.produk_id.value}`;
                deleteForm.method = 'POST';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                deleteForm.appendChild(csrfInput);
                deleteForm.appendChild(methodInput);

                document.body.appendChild(deleteForm);
                deleteForm.submit();
            }
        });
    });
    </script>
    @endpush
</x-app-layout>