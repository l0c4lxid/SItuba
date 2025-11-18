<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ExampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $pemda = $this->createUser(
            [
                'name' => 'Dinas Kesehatan Kota Surakarta',
                'phone' => '0271-642911',
                'role' => UserRole::Pemda,
                'password' => 'password123',
            ],
            [
                'organization' => 'Dinas Kesehatan Kota Surakarta',
                'address' => 'Jl. Menteri Supeno No.7, Manahan, Surakarta',
                'notes' => 'Akun utama Pemda/Diskes Surakarta',
            ],
        );

        $kelurahanPayloads = [
            [
                'key' => 'manahan',
                'name' => 'Kelurahan Manahan',
                'phone' => '0271-741001',
                'address' => 'Jl. MT Haryono No.10, Manahan, Banjarsari',
            ],
            [
                'key' => 'gajahan',
                'name' => 'Kelurahan Gajahan',
                'phone' => '0271-715516',
                'address' => 'Jl. Slamet Riyadi No.375, Pasar Kliwon',
            ],
            [
                'key' => 'purwosari',
                'name' => 'Kelurahan Purwosari',
                'phone' => '0271-714299',
                'address' => 'Jl. Slamet Riyadi No.260, Laweyan',
            ],
        ];

        $kelurahanMap = [];
        foreach ($kelurahanPayloads as $payload) {
            $kelurahanMap[$payload['key']] = $this->createUser(
                [
                    'name' => $payload['name'],
                    'phone' => $payload['phone'],
                    'role' => UserRole::Kelurahan,
                    'password' => 'password123',
                ],
                [
                    'organization' => $payload['name'],
                    'address' => $payload['address'],
                ],
            );
        }

        $puskesmasPayloads = [
            [
                'key' => 'gajahan',
                'name' => 'Puskesmas Gajahan',
                'phone' => '0271-714174',
                'address' => 'Jl. Kapten Mulyadi No.459, Pasar Kliwon',
                'kelurahan_key' => 'gajahan',
            ],
            [
                'key' => 'nguter',
                'name' => 'Puskesmas Ngoresan',
                'phone' => '0271-739821',
                'address' => 'Jl. Ir. Sutami No.58, Jebres',
                'kelurahan_key' => 'manahan',
            ],
            [
                'key' => 'purwosari',
                'name' => 'Puskesmas Purwosari',
                'phone' => '0271-714529',
                'address' => 'Jl. Slamet Riyadi No.260, Laweyan',
                'kelurahan_key' => 'purwosari',
            ],
        ];

        $puskesmasMap = [];
        foreach ($puskesmasPayloads as $payload) {
            $kelurahan = $kelurahanMap[$payload['kelurahan_key']];
            $puskesmasMap[$payload['key']] = $this->createUser(
                [
                    'name' => $payload['name'],
                    'phone' => $payload['phone'],
                    'role' => UserRole::Puskesmas,
                    'password' => 'password123',
                ],
                [
                    'organization' => $payload['name'],
                    'address' => $payload['address'],
                    'supervisor_id' => $kelurahan->id,
                ],
            );
        }

        $kaderPayloads = [
            [
                'key' => 'kader-larasati',
                'name' => 'Larasati Wulandari',
                'phone' => '0813-2876-1111',
                'notes' => 'RW 01 Gajahan',
                'puskesmas_key' => 'gajahan',
            ],
            [
                'key' => 'kader-surya',
                'name' => 'Surya Pranata',
                'phone' => '0812-4655-2222',
                'notes' => 'RW 02 Gajahan',
                'puskesmas_key' => 'gajahan',
            ],
            [
                'key' => 'kader-anindita',
                'name' => 'Anindita Dewi',
                'phone' => '0813-9911-3333',
                'notes' => 'RW 03 Manahan',
                'puskesmas_key' => 'nguter',
            ],
            [
                'key' => 'kader-yusuf',
                'name' => 'Yusuf Santoso',
                'phone' => '0812-7755-4444',
                'notes' => 'RW 04 Manahan',
                'puskesmas_key' => 'nguter',
            ],
            [
                'key' => 'kader-ratri',
                'name' => 'Ratri Kusuma',
                'phone' => '0813-5511-5555',
                'notes' => 'RW 05 Purwosari',
                'puskesmas_key' => 'purwosari',
            ],
            [
                'key' => 'kader-dimas',
                'name' => 'Dimas Nugroho',
                'phone' => '0812-9988-6666',
                'notes' => 'RW 06 Purwosari',
                'puskesmas_key' => 'purwosari',
            ],
        ];

        $kaderMap = [];
        foreach ($kaderPayloads as $payload) {
            $puskesmas = $puskesmasMap[$payload['puskesmas_key']];
            $kaderMap[$payload['key']] = $this->createUser(
                [
                    'name' => $payload['name'],
                    'phone' => $payload['phone'],
                    'role' => UserRole::Kader,
                    'password' => 'password123',
                ],
                [
                    'supervisor_id' => $puskesmas->id,
                    'notes' => $payload['notes'],
                ],
            );
        }

        $patientPayloads = [
            [
                'name' => 'Budi Hartono',
                'phone' => '0812-1100-7001',
                'nik' => '3372010101010001',
                'address' => 'RT 01 RW 01, Kampung Kauman',
                'kader_key' => 'kader-larasati',
            ],
            [
                'name' => 'Siti Maesaroh',
                'phone' => '0812-1100-7002',
                'nik' => '3372010101010002',
                'address' => 'RT 02 RW 02, Kampung Kauman',
                'kader_key' => 'kader-larasati',
            ],
            [
                'name' => 'Fajar Nugraha',
                'phone' => '0812-1100-7003',
                'nik' => '3372010101010003',
                'address' => 'RT 03 RW 02, Gajahan',
                'kader_key' => 'kader-surya',
            ],
            [
                'name' => 'Mega Lestari',
                'phone' => '0812-1100-7004',
                'nik' => '3372010101010004',
                'address' => 'RT 04 RW 02, Gajahan',
                'kader_key' => 'kader-surya',
            ],
            [
                'name' => 'Rio Prasetyo',
                'phone' => '0812-1100-7005',
                'nik' => '3372010101010005',
                'address' => 'RT 05 RW 03, Manahan',
                'kader_key' => 'kader-anindita',
            ],
            [
                'name' => 'Anita Pertiwi',
                'phone' => '0812-1100-7006',
                'nik' => '3372010101010006',
                'address' => 'RT 06 RW 03, Manahan',
                'kader_key' => 'kader-anindita',
            ],
            [
                'name' => 'Galih Wibowo',
                'phone' => '0812-1100-7007',
                'nik' => '3372010101010007',
                'address' => 'RT 07 RW 04, Manahan',
                'kader_key' => 'kader-yusuf',
            ],
            [
                'name' => 'Ratna Sari',
                'phone' => '0812-1100-7008',
                'nik' => '3372010101010008',
                'address' => 'RT 08 RW 04, Manahan',
                'kader_key' => 'kader-yusuf',
            ],
            [
                'name' => 'Yoga Mahendra',
                'phone' => '0812-1100-7009',
                'nik' => '3372010101010009',
                'address' => 'RT 09 RW 05, Purwosari',
                'kader_key' => 'kader-ratri',
            ],
            [
                'name' => 'Nur Aini',
                'phone' => '0812-1100-7010',
                'nik' => '3372010101010010',
                'address' => 'RT 10 RW 06, Purwosari',
                'kader_key' => 'kader-dimas',
            ],
        ];

        foreach ($patientPayloads as $payload) {
            $kader = $kaderMap[$payload['kader_key']];
            $this->createUser(
                [
                    'name' => $payload['name'],
                    'phone' => $payload['phone'],
                    'role' => UserRole::Pasien,
                    'password' => 'password123',
                ],
                [
                    'nik' => $payload['nik'],
                    'address' => $payload['address'],
                    'supervisor_id' => $kader->id,
                    'initial_password' => 'password123',
                ],
            );
        }
    }

    protected function createUser(array $userData, array $detail = []): User
    {
        $attributes = [
            'name' => $userData['name'],
            'phone' => $userData['phone'],
            'role' => $userData['role'],
            'password' => Hash::make($userData['password'] ?? 'password123'),
            'is_active' => $userData['is_active'] ?? true,
        ];

        $user = User::create($attributes);

        UserDetail::create(array_merge(['user_id' => $user->id], $detail));

        return $user;
    }
}
