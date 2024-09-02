<?php

use Illuminate\Database\Seeder;

class MeritTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('merit_types')->insert([
            'name' => 'Exam'
        ]);

        DB::table('merit_types')->insert([
            'name' => 'Implementation Effectiveness Bonus'
        ]);
        DB::table('merit_types')->insert([
            'name' => 'Effective Order and Delivery Bonus'
        ]);

        DB::table('merit_types')->insert([
            'name' => 'Closed Deals Bonus'
        ]);

        DB::table('merit_types')->insert([
            'name' => 'Management Performance Evaluation Quarterly Bonus'
        ]);

        DB::table('merit_types')->insert([
            'name' => 'Staff Performance Evaluation Quarterly Bonus'
        ]);

        DB::table('merit_types')->insert([
            'name' => 'Timely VAT Collection Quarterly Bonus'
        ]);

        DB::table('merit_types')->insert([
            'name' => 'Timely Payment Collection Quarterly Bonus'
        ]);

        DB::table('merit_types')->insert([
            'name' => 'Best Employees Productivity and Engagement Quarterly Bonus'
        ]);

        DB::table('merit_types')->insert([
            'name' => 'Facilities High Availability Quarterly Bonus'
        ]);

        DB::table('merit_types')->insert([
            'name' => 'Allowance'
        ]);
    }
}
