<?php

use App\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            Customer::create([
                'name' => 'Meja ' . $i,
                'description' => 'Meja nomor ' . $i
            ]);
        }
    }
}
