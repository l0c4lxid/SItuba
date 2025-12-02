<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PuskesmasKelurahanSeeder extends Seeder
{
    public function run(): void
    {
        $puskesmasCounter = 1;
        $kelurahanCounter = 1;

        $kecamatanData = [
            'Laweyan' => [
                [
                    'name' => 'Puskesmas Pajang',
                    'kelurahans' => ['Pajang', 'Sondakan', 'Laweyan', 'Karangasem'],
                ],
                [
                    'name' => 'Puskesmas Penumping',
                    'kelurahans' => ['Penumping', 'Panularan', 'Sriwedari', 'Bumi'],
                ],
                [
                    'name' => 'Puskesmas Purwosari',
                    'kelurahans' => ['Purwosari', 'Kerten', 'Jajar'],
                ],
            ],
            'Serengan' => [
                [
                    'name' => 'Puskesmas Jayengan',
                    'kelurahans' => ['Kemlayan', 'Jayengan', 'Tipes', 'Serengan'],
                ],
                [
                    'name' => 'Puskesmas Kratonan',
                    'kelurahans' => ['Danukusuman', 'Kratonan', 'Joyotakan'],
                ],
            ],
            'Pasar Kliwon' => [
                [
                    'name' => 'Puskesmas Gajahan',
                    'kelurahans' => ['Joyosuran', 'Pasar Kliwon', 'Gajahan', 'Baluwarti', 'Kauman', 'Kampung Baru'],
                ],
                [
                    'name' => 'Puskesmas Sangkrah',
                    'kelurahans' => ['Sangkrah', 'Semanggi', 'Kedung Lumbu', 'Mojo'],
                ],
            ],
            'Jebres' => [
                [
                    'name' => 'Puskesmas Sibela',
                    'kelurahans' => ['Mojosongo'],
                ],
                [
                    'name' => 'Puskesmas Ngoresan',
                    'kelurahans' => ['Jebres'],
                ],
                [
                    'name' => 'Puskesmas Purwodiningratan',
                    'kelurahans' => ['Sudiroprajan', 'Gandekan', 'Tegalharjo', 'Purwodiningratan', 'Kepatihan Wetan', 'Kepatihan Kulon'],
                ],
                [
                    'name' => 'Puskesmas Pucangsawit',
                    'kelurahans' => ['Jagalan', 'Pucangsawit', 'Sewu'],
                ],
            ],
            'Banjarsari' => [
                [
                    'name' => 'Puskesmas Gilingan',
                    'kelurahans' => ['Gilingan', 'Ketelan', 'Punggawan'],
                ],
                [
                    'name' => 'Puskesmas Gambirsari',
                    'kelurahans' => ['Kadipiro', 'Banjarsari', 'Joglo'],
                ],
                [
                    'name' => 'Puskesmas Setabelan',
                    'kelurahans' => ['Setabelan', 'Keprabon', 'Ketalan', 'Timuran'],
                ],
                [
                    'name' => 'Puskesmas Banyuanyar',
                    'kelurahans' => ['Banyuanyar', 'Sumber'],
                ],
                [
                    'name' => 'Puskesmas Manahan',
                    'kelurahans' => ['Manahan', 'Mangkubumen'],
                ],
                [
                    'name' => 'Puskesmas Nusukan',
                    'kelurahans' => ['Nusukan'],
                ],
            ],
        ];

        foreach ($kecamatanData as $kecamatan => $puskesmasList) {
            foreach ($puskesmasList as $puskesmasData) {
                $puskesmasUser = $this->createUser(
                    [
                        'name' => $puskesmasData['name'],
                        'phone' => sprintf('03%02d', $puskesmasCounter),
                        'role' => UserRole::Puskesmas,
                    ],
                    [
                        'organization' => $puskesmasData['name'],
                        'notes' => "Kecamatan {$kecamatan}",
                        'initial_password' => 'password123',
                    ]
                );

                $puskesmasCounter++;

                foreach ($puskesmasData['kelurahans'] as $kelurahan) {
                    $this->createUser(
                        [
                            'name' => "Kelurahan {$kelurahan}",
                            'phone' => sprintf('04%02d', $kelurahanCounter),
                            'role' => UserRole::Kelurahan,
                        ],
                        [
                            'organization' => "Kelurahan {$kelurahan}",
                            'notes' => "Pembina {$puskesmasData['name']}",
                            'supervisor_id' => $puskesmasUser->id,
                            'initial_password' => 'password123',
                        ]
                    );

                    $kelurahanCounter++;
                }
            }
        }
    }

    private function createUser(array $userData, array $detail = []): User
    {
        $attributes = [
            'name' => $userData['name'],
            'phone' => $userData['phone'],
            'role' => $userData['role'],
            'password' => Hash::make('password123'),
            'is_active' => true,
        ];

        $user = User::create($attributes);

        UserDetail::create(array_merge(['user_id' => $user->id], $detail));

        return $user;
    }
}
