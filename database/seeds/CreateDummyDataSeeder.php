<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CreateDummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for($i=0; $i<=10; $i++){
            DB::table('restful_api')
            ->insert([
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
                'key' => $faker->word . $i,
                'value' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            ]);
        }
    }
}
