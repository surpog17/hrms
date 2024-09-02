<?php

use Illuminate\Database\Seeder;

class WorkingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('workings')->insert([
            'name' => "monday",
            'weekday' => 0,
        ]);

        DB::table('workings')->insert([
            'name' => "Tuesday",
            'weekday' => 1,
        ]);

        DB::table('workings')->insert([
            'name' => "Wednesday",
            'weekday' => 2,
        ]);

        DB::table('workings')->insert([
            'name' => "Thursday",
            'weekday' => 3,
        ]);
        DB::table('workings')->insert([
            'name' => "Friday",
            'weekday' => 4,
        ]);
        DB::table('workings')->insert([
            'name' => "saturday",
            'weekday' => 5,
        ]);
        DB::table('workings')->insert([
            'name' => "sunday",
            'weekday' => 6,
        ]);
    }

}
