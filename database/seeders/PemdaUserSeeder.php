<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PemdaUserSeeder extends Seeder
{
    public function run(): void
    {
        $pemda = User::create([
            'name' => 'Dinas Kesehatan Kota Surakarta',
            'phone' => '0271642911',
            'role' => UserRole::Pemda,
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);

        UserDetail::create([
            'user_id' => $pemda->id,
            'organization' => 'Dinas Kesehatan Kota Surakarta',
            'address' => 'Jl. Menteri Supeno No.7, Manahan, Surakarta',
            'notes' => 'Akun utama Pemda/Diskes Surakarta',
        ]);
    }
}
