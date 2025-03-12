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
            'nik' => '896332211553399',
            'name' => 'Muhammad Rivaldhi',
            'position' => 'IT Laravel Developer',
            'phone' => '089637856545',
            'password' => Hash::make('password123'), // Password di-hash
        ]);
    }
}
