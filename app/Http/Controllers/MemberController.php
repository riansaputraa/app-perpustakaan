<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private array $members = [
        ['id' => 1, 'nama' => 'Budi Santoso', 'nim' => '2341720001', 'email' => 'budi@student.ac.id', 'nomor_telepon' => '081234567890', 'alamat' => 'Jl. Raya No. 1, Surabaya', 'status' => 'aktif'],
        ['id' => 2, 'nama' => 'Siti Rahayu', 'nim' => '2341720002', 'email' => 'siti@student.ac.id', 'nomor_telepon' => '082345678901', 'alamat' => 'Jl. Merdeka No. 5, Malang', 'status' => 'aktif'],
        ['id' => 3, 'nama' => 'Andi Firmansyah', 'nim' => '2341720003', 'email' => 'andi@student.ac.id', 'nomor_telepon' => null, 'alamat' => 'Jl. Sudirman No. 10, Jakarta', 'status' => 'nonaktif'],
    ];

    public function index()
    {
        $members = $this->members;

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$validated['nama']}\" berhasil ditambahkan (data dummy, belum tersimpan ke database).");
    }

    public function show(string $id)
    {
        return "MemberController@show, id: {$id}";
    }

    public function edit(string $id)
    {
        return "MemberController@edit, id: {$id}";
    }

    public function update(Request $request, string $id)
    {
        return "MemberController@update, id: {$id}";
    }

    public function destroy(string $id)
    {
        return "MemberController@destroy, id: {$id}";
    }
}
