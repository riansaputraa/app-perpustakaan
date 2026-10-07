@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
    <h1>Profil Pengguna</h1>

    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <h3 style="margin-top: 0;">Informasi Akun</h3>
        <table style="border: none; margin-top: 0; width: auto;">
            <tr>
                <td style="border: none; font-weight: bold; padding: 6px 16px 6px 0; width: 120px;">Nama</td>
                <td style="border: none; padding: 6px 0;">: {{ $user->name }}</td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; padding: 6px 16px 6px 0;">Email</td>
                <td style="border: none; padding: 6px 0;">: {{ $user->email }}</td>
            </tr>
            <tr>
                <td style="border: none; font-weight: bold; padding: 6px 16px 6px 0;">Role</td>
                <td style="border: none; padding: 6px 0;">: <span class="badge {{ $user->role === 'admin' ? 'badge-dipinjam' : 'badge-dikembalikan' }}">{{ ucfirst($user->role) }}</span></td>
            </tr>
        </table>
    </div>

    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; max-width: 500px;">
        <h3 style="margin-top: 0;">Ganti Password</h3>

        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <label for="password_lama">Password Lama</label>
            <input type="password" name="password_lama" id="password_lama" required>
            @error('password_lama')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">Password Baru</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            <button type="submit" class="btn" style="margin-top: 20px;">Perbarui Password</button>
        </form>
    </div>
@endsection
