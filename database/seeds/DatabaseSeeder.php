<?php

use App\Product;
use App\RawMaterial;
use App\Staff;
use App\User;
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
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
//        factory(Product::class, 40)->create();
//        factory(RawMaterial::class, 100)->create();
//        $this->call(CustomerSeeder::class);
//        factory(User::class, 5)->create()->each(function ($user) {
//            $staff = factory(Staff::class)->make();
//            $user->staff()->save($staff);
//        });
    }
}
