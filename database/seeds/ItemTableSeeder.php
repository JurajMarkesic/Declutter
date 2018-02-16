<?php

use Illuminate\Database\Seeder;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = ['Juicer','Pearls','CDs'];

        foreach($items as $item) {
            DB::table('items')->insert([
                'name' => $item,
                'category_id' => rand(1,3)
            ]);
        }
    }
}
