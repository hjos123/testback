<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::table('users')->insert([
            'name' => $faker->name,
            'email' => 'test@asd.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
    }
}
