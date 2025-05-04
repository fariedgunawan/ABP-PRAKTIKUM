<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'category_id' => 1,
            'name' => 'Smartphone',
            'price' => 699.99
        ]);

        Product::create([
            'category_id' => 1,
            'name' => 'Laptop',
            'price' => 999.99
        ]);

        Product::create([
            'category_id' => 2,
            'name' => 'T-shirt',
            'price' => 19.99
        ]);
    }
}
