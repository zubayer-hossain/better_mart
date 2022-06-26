<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductSeed extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $products = array(
            array('id' => '1', 'name' => 'Yuri Ryan', 'product_code' => 'dolor-consectetur-ip', 'description' => '<p>Amet, optio, recusan.</p>', 'selling_price' => '913.00', 'images' => NULL, 'category_id' => '5', 'brand_id' => '5', 'product_model_id' => '5', 'created_at' => '2021-10-03 06:02:48', 'updated_at' => '2021-10-05 19:04:53', 'deleted_at' => NULL),
            array('id' => '2', 'name' => 'Bernard Banks', 'product_code' => 'dolor-assumenda-anim', 'description' => '<p>Sit, eiusmod sunt co.</p>', 'selling_price' => '760.00', 'images' => NULL, 'category_id' => '4', 'brand_id' => '4', 'product_model_id' => '4', 'created_at' => '2021-10-03 06:06:29', 'updated_at' => '2021-10-05 19:04:37', 'deleted_at' => NULL),
            array('id' => '3', 'name' => 'Caldwell Kirk', 'product_code' => 'nulla-in-veritatis', 'description' => '<p>Voluptatem tenetur o.</p>', 'selling_price' => '308.00', 'images' => NULL, 'category_id' => '3', 'brand_id' => '3', 'product_model_id' => '3', 'created_at' => '2021-10-03 06:06:37', 'updated_at' => '2021-10-05 19:04:24', 'deleted_at' => NULL),
            array('id' => '4', 'name' => 'Elaine Murphy', 'product_code' => 'autem-obcaecati-est', 'description' => '<p>Cumque consectetur i.</p>', 'selling_price' => '226.00', 'images' => NULL, 'category_id' => '2', 'brand_id' => '2', 'product_model_id' => '2', 'created_at' => '2021-10-03 06:06:54', 'updated_at' => '2021-10-05 19:04:13', 'deleted_at' => NULL),
            array('id' => '5', 'name' => 'Rhiannon Blake', 'product_code' => 'illum-corrupti-ull', 'description' => '<p>Incidunt, rerum blan.</p>', 'selling_price' => '250.00', 'images' => NULL, 'category_id' => '1', 'brand_id' => '1', 'product_model_id' => '1', 'created_at' => '2021-10-03 06:07:02', 'updated_at' => '2021-10-05 19:03:55', 'deleted_at' => NULL),
        );

        DB::table('products')->insert($products);
    }
}
