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
        $this->call(AppPermissionSeeder::class);
        $this->call(DepotSeeder::class);
        $this->call(PosteSeeder::class);
        $this->call(MarchandisesSeeder::class);
        $this->call(StockdepotSeeder::class);
        // $this->call(MouvementstockSeeder::class);
        // $this->call(FournisseurSeeder::class);
        // $this->call(ClientSeeder::class);
        
    }
}
