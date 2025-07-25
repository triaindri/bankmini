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
            'email' => 'nullable|email',
            'telepon' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $siswa = Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'jeniskelamin' => $request->jeniskelamin,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
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
            'email' => 'nullable|email',
            'telepon' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $siswa->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'jeniskelamin' => $request->jeniskelamin,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);
        return redirect()->route('siswa.show', $siswa->id)->with('success', 'Data berhasil diperbarui');

    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function show($id)
    {
        $siswa = Siswa::with('tabungan')->findOrFail($id); // pastikan include relasi jika perlu
        return view('siswa.show', compact('siswa'));
    }

}
