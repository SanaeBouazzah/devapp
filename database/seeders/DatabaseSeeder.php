<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call(
          ProfileSeeder::class,
        );
        User::factory(10)->create();
    }
}
