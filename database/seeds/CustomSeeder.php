<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Custom;
class CustomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker=Factory::create();
        Custom::truncate();
        foreach(range(1,100) as $i){
            Custom::create([
                'name'=>$faker->name,
                'email'=>$faker->email,
                'phone'=>$faker->phoneNumber
            ]);
        }
    }
}
