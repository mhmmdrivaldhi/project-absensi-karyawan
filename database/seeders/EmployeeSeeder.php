<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([

                'nik' => '12345678910',
                'name' => 'Muhammad Rivaldhi',
                'position' => 'IT Laravel Developer',
                'phone' => '089637856545',
                'password' => Hash::make('password123'), // Password di-hash
                'photo' => 'rivaldhi.png',
        ]);

        Employee::create([

                'nik' => '10987654321',
                'name' => 'Muhammad Rizky',
                'position' => 'Quality Assurance Developer',
                'phone' => '081241289460',
                'password' => Hash::make('rizky123'), // Password di-hash
                'photo' => ''
        ]);
    }
}
