<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        $faker = \Faker\Factory::create('en_EN');
        DB::table('users')->insert([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('123'),
        ]);

        foreach(range(1,10) as $_) {
            DB::table('mechanics')->insert([
                'name' => $faker->firstname,
                'surname' => $faker->lastname,
                'photo' => rand(0,4) ? $faker-> imageUrl(200, 300) : null
            ]);
        }

        $maker = ['Volvo', 'Scania', 'Mercedes-Benz', 'MAN', 'Iveco', 'DAF', 'MAC'];
        foreach(range(1,300) as $_) {
            DB::table('trucks')->insert([
                'maker' => $maker[rand(0, count($maker)-1)],
                'plate' => range('A', 'Z')[rand(0, 25)].range('A', 'Z')[rand(0, 25)].range('A', 'Z')[rand(0, 25)].'-'.rand(100, 999),
                'make_year' => rand(1980, 2021),
                'mechanic_notices' => $faker->realText(300, 3),
                'mechanic_id' => rand(1, 10),
            ]);
        }
    }
}
