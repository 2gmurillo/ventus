<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Cache::flush();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PaymentGatewaySeeder::class,
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
