<?php

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert(
            array(
                'email' => 'bhatrameez2009@gmail.com',
                'name' => "Shafi",
                'password' => bcrypt('Rameez@12'),
                'type' => 'superAdmin',
            )
        );
    }
}
