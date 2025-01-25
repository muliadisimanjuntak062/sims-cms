<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                "image" => "Image-placeholder.png",
                "name" => "Sepatu Olahraga",
                "product_category_id" => 1,
                "purchase_price" => 10000,
                "sell_price" => 13000,
                "stock" => 100
            ],
            [
                "image" => "Image-placeholder.png",
                "name" => "Gitar Spanyol",
                "product_category_id" => 2,
                "purchase_price" => 10000,
                "sell_price" => 13000,
                "stock" => 100
            ],
        ];

        $faker = Faker::create();

        foreach ($products as $product) {
            Product::create($product);
        }

        for ($i = 0; $i < 10; $i++) {
            Product::create([
                "image" => "Image-placeholder.png",
                "name" => $faker->words(2, true),
                "product_category_id" => $faker->numberBetween(1, 2),
                "purchase_price" => $faker->numberBetween(5000, 20000),
                "sell_price" => $faker->numberBetween(20000, 30000), 
                "stock" => $faker->numberBetween(10, 500), // Random stock
            ]);
        }
    }
}
