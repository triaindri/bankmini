<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'jeniskelamin' => 'required|in:perempuan,laki-laki',
        ]);

        $siswa = Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'jeniskelamin' => $request->jeniskelamin,
        ]);

        // Tambahkan tabungan awal dengan saldo 0
        $siswa->tabungan()->create(['saldo' => 0]);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function index(Request $request)
    {
        $query = Siswa::with('tabungan');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama', 'like', "%{$q}%")
                ->orWhere('nis', 'like', "%{$q}%");
        }

        $siswa = $query->get();

        return view('siswa.index', compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'jeniskelamin' => 'required|in:perempuan,laki-laki',
        ]);

        $siswa->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'jeniskelamin' => $request->jeniskelamin,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
