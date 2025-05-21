<div class="p-6 bg-[#E7ECF5] min-h-screen">
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="w-full table-auto text-left border-collapse">
            <thead class="bg-[#2E3A59] text-white">
                <tr>
                    <th class="p-3 border">No</th>
                    <th class="p-3 border">NISN</th>
                    <th class="p-3 border">Nama Siswa</th>
                    <th class="p-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach ($petugas as $index => $user)
                    <tr class="bg-white hover:bg-gray-100">
                        <td class="p-3 border text-center">{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="p-3 border">{{ $user->nisn }}</td>
                        <td class="p-3 border">{{ $user->name }}</td>
                        <td class="p-3 border">{{ $user->username }}</td>
                        <td class="p-3 border text-center space-x-2">
                            <a href="{{ route('petugas.edit', $user->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">Ubah</a>
                            <form action="{{ route('petugas.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
