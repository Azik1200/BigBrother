<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Aziz',
            'surname' => 'Salimli',
            'username' => 'salimlias',
            'email' => 'aziz.salimli@kapitalbank.az',
            'phone' => '+994552886510',
            'password' => Hash::make('S@alo886510'), // Пароль должен быть зашифрован!
        ]);

    }
}
