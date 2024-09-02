<?php

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
        //
        DB::table('categories')->insert([
            'name' => 'PMA',
            'duration' => '10',
        ]);

        DB::table('categories')->insert([
            'name' => 'Car Maintenance',
            'duration' => '10',
        ]);

        DB::table('categories')->insert([
            'name' => 'Exam Failed',
            'duration' => '10',
        ]);

        DB::table('categories')->insert([
            'name' => 'Loan',
            'duration' => '6',
        ]);

        DB::table('categories')->insert([
            'name' => 'Medical',
            'duration' => '1',
        ]);

        DB::table('categories')->insert([
            'name' => 'leave',
            'duration' => '1',
        ]);
    }
}
