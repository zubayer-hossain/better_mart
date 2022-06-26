<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeed extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $reviews = array(
            array('id' => '1', 'name' => 'Martina Brady', 'rating' => '5', 'comment' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'image' => NULL, 'created_at' => '2021-10-08 16:16:48', 'updated_at' => '2021-10-08 16:17:25', 'deleted_at' => NULL),
            array('id' => '2', 'name' => 'Brennan Bailey', 'rating' => '4', 'comment' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'image' => NULL, 'created_at' => '2021-10-08 16:23:34', 'updated_at' => '2021-10-08 16:23:34', 'deleted_at' => NULL),
            array('id' => '3', 'name' => 'Todd Gill', 'rating' => '5', 'comment' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'image' => NULL, 'created_at' => '2021-10-08 16:23:57', 'updated_at' => '2021-10-08 16:23:57', 'deleted_at' => NULL)
        );

        DB::table('reviews')->insert($reviews);
    }
}
