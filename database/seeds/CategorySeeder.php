<?php

use App\ProductCategory;
use App\RawMaterialCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::create([
            'name' => 'Makanan',
            'description' => 'Menu makanan utama bagi pelanggan yang lapar'
        ]);
        ProductCategory::create([
            'name' => 'Minuman Dingin',
            'description' => 'Menu minuman dingin untuk cuaca yang panas'
        ]);
        ProductCategory::create([
            'name' => 'Minuman Hangat',
            'description' => 'Menu minuman hangat agar suasana lebih santai'
        ]);
        ProductCategory::create([
            'name' => 'Snack',
            'description' => 'Menu makanan ringan untuk pengisi suasana'
        ]);

        RawMaterialCategory::create([
            'name' => 'Sembako',
            'description' => 'Sembilan Bahan Pokok untuk menu makanan utama'
        ]);
        RawMaterialCategory::create([
            'name' => 'Soda',
            'description' => 'Minuman berkarbonasi untuk bahan minuman dingin'
        ]);
        RawMaterialCategory::create([
            'name' => 'Bumbu Dapur',
            'description' => 'Berbagai macam bumbu dapur untuk memperkuat rasa masakan'
        ]);
        RawMaterialCategory::create([
            'name' => 'Frozen Food',
            'description' => 'Makanan siap saji yang tinggal digoreng dan disajikan'
        ]);
    }
}
