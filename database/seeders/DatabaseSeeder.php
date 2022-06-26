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
        $this->call([
            RoleSeed::class,
            UserSeed::class,
            TeamSeed::class,
            CategorySeed::class,
            BrandSeed::class,
            ProductModelSeed::class,
            ProductSeed::class,
            ReviewSeed::class,
            ServiceSeed::class,
        ]);
    }
}
