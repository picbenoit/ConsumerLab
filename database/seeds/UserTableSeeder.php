<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if (null === User::where('email', 'admin@consumerlab.com')->first()) {
    		User::create([
    				'name' => 'Administrateur',
    				'email' => 'admin@consumerlab.com',
    				'password' => bcrypt('admin'),
    		]);
    	}
    }
}
