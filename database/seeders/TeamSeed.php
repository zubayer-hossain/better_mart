<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeamSeed extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $teams = array(
            array('id' => '1', 'name' => 'Md. Rejaul Islam', 'designation' => 'Manager', 'department' => 'Technical Development', 'mobile' => '+8801612550390', 'email' => 'rejaul26@yahoo.com', 'image' => NULL, 'created_at' => '2021-10-03 07:36:17', 'updated_at' => '2021-10-03 07:36:17', 'deleted_at' => NULL),
            array('id' => '2', 'name' => 'Md. Younus Ali', 'designation' => 'Manager', 'department' => 'Sales & Service', 'mobile' => '+8801612550391', 'email' => 'younusali1094@gmail.com', 'image' => NULL, 'created_at' => '2021-10-03 07:37:50', 'updated_at' => '2021-10-03 07:37:50', 'deleted_at' => NULL),
            array('id' => '3', 'name' => 'Md. Shahadat Hossain', 'designation' => 'Support', 'department' => 'Marketing & Technical', 'mobile' => '+8801612550392', 'email' => 'ptsc93@gmail.com', 'image' => NULL, 'created_at' => '2021-10-03 07:38:29', 'updated_at' => '2021-10-03 07:38:29', 'deleted_at' => NULL)
        );
        DB::table('teams')->insert($teams);
    }
}
