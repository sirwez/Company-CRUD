<?php

namespace Database\Seeders;

use App\Models\Company;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        //create 10 empresas
        for ($i = 0; $i < 10; $i++) {
            Company::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'address' => $faker->domainName,
            ]);
        }
    }
}
