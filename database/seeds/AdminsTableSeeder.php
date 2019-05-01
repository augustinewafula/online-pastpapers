<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'John Doe',
            'email'      => 'johndoe@gmail.com',
            'password'   => bcrypt('password'),
            'type' => 2
        ]);
    }
}
