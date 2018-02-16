<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 20; $i++) {
            DB::table('stories')->insert([
                'user_id' => 1,
                'item_id' => rand(1,3),
                'body' => str_random(100),
                'cost' => rand(1,540),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
