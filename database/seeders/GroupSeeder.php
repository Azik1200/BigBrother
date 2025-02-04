<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            'ON',
            'XN',
            'KBNS',
            'BKMS',
            'PKMS',
            'admin'
        ];

        foreach ($groups as $group) {
            Group::create(['name' => $group, 'user_id' => 1]);
        }
    }
}
