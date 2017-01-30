<?php

use Illuminate\Database\Seeder;
use App\Priority;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Priority::create(['name' => 'high']);
        Priority::create(['name' => 'medium']);
        Priority::create(['name' => 'low']);
    }
}
