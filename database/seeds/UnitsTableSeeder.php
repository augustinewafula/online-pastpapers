<?php

use Illuminate\Database\Seeder;
use App\Unit;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::create([
            'department_id' => 1,
            'name' => 'Network Essentials',
            'code' => 'DIT 0472'
        ]);
    }
}
