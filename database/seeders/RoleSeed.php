<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeed extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $teams = array(
            array('id' => '1', 'name' => 'Admin', 'created_at' => '2021-10-03 07:36:17', 'updated_at' => '2021-10-03 07:36:17', 'deleted_at' => NULL),
            array('id' => '2', 'name' => 'Manager',  'created_at' => '2021-10-03 07:37:50', 'updated_at' => '2021-10-03 07:37:50', 'deleted_at' => NULL),
        );
        DB::table('roles')->insert($teams);
    }
}
