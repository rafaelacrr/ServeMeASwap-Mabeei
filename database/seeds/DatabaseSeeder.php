<?php

use Illuminate\Database\Seeder;
require_once 'vendor/autoload.php';

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
    	foreach (range(1,5) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name,
	            'email' => $faker->email,
                'password' => bcrypt('secret'),
                'phone' => $faker->regexify('9[0-9]{8}'),
                'phone_indicative' => +351,
                'nif' => $faker->regexify('[0-9]{9}'),
                'remember_token' => Str::random(12),
            ]);
        }
        foreach (range(1,10) as $index) {
            $subdomain=$faker->city;
            DB::table('swaps')->insert([
                'subdomain' => $subdomain,
                'institutional_mail' => $faker->domainName,
                'email_format' => "a*****",
                'email_admin' => $faker->email,
                'password' => bcrypt('secret'),
                'user_id' => $faker->numberBetween(1,7),
            ]);
            foreach (range(1,5) as $index) {
                DB::table('courses')->insert([
                    'name' => $faker->city,
                    'code' => $faker->domainName,
                    'year' =>  $faker->numberBetween(1,6),
                    'semester' => $faker->numberBetween(1,2),
                    'swap_subdomain' => $subdomain, 
                ]);
            }
        }  
        
        
    }
}
