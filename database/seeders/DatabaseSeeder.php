<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'backoffice',
            'nip' => '20210120099',
            'password' => bcrypt('password'),
            'role' => 'backoffice'
        ]);
    }
}
