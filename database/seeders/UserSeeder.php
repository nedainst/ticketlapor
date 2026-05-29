<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@ticketlapor.id',
            'phone' => '081200000001',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('super_admin');

        // Admin
        $admin = User::create([
            'name' => 'Admin TicketLapor',
            'email' => 'admin@ticketlapor.id',
            'phone' => '081200000002',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Admin 2
        $admin2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.admin@ticketlapor.id',
            'phone' => '081200000003',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin2->assignRole('admin');

        // Masyarakat Users with Indonesian names
        $users = [
            ['name' => 'Ahmad Rizki', 'email' => 'ahmad.rizki@email.com', 'phone' => '081311111001', 'address' => 'Jl. Sudirman No. 45, Jakarta Selatan'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti.nur@email.com', 'phone' => '081311111002', 'address' => 'Jl. Diponegoro No. 12, Surabaya'],
            ['name' => 'Muhammad Fajar', 'email' => 'fajar.muh@email.com', 'phone' => '081311111003', 'address' => 'Jl. Asia Afrika No. 88, Bandung'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi.les@email.com', 'phone' => '081311111004', 'address' => 'Jl. Malioboro No. 22, Yogyakarta'],
            ['name' => 'Andi Pratama', 'email' => 'andi.pra@email.com', 'phone' => '081311111005', 'address' => 'Jl. Pemuda No. 56, Semarang'],
            ['name' => 'Rina Wulandari', 'email' => 'rina.wul@email.com', 'phone' => '081311111006', 'address' => 'Jl. Gatot Subroto No. 33, Medan'],
            ['name' => 'Bagus Firmansyah', 'email' => 'bagus.fir@email.com', 'phone' => '081311111007', 'address' => 'Jl. Veteran No. 78, Makassar'],
            ['name' => 'Putri Amelia', 'email' => 'putri.ame@email.com', 'phone' => '081311111008', 'address' => 'Jl. Imam Bonjol No. 15, Denpasar'],
            ['name' => 'Hendra Wijaya', 'email' => 'hendra.wij@email.com', 'phone' => '081311111009', 'address' => 'Jl. Sudirman No. 99, Palembang'],
            ['name' => 'Nisa Fitriani', 'email' => 'nisa.fit@email.com', 'phone' => '081311111010', 'address' => 'Jl. Ahmad Yani No. 44, Malang'],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
                'address' => $userData['address'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $user->assignRole('masyarakat');
        }
    }
}
