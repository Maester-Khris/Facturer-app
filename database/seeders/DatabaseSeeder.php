<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        $this->call(DepotSeeder::class);
        $this->call(MarchandisesSeeder::class);
        $this->call(StockdepotSeeder::class);
        $this->call(MouvementstockSeeder::class);
    }
}
