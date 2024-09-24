<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunitiesTableSeeder extends Seeder
{
    /**
     * Seed the `communities` table.
     *
     * @return void
     */
    public function run()
    {
        DB::table('communities')->insert([
            ['name' => 'Technology'],
            ['name' => 'Science'],
            ['name' => 'Arts'],
            ['name' => 'Politics'],
            ['name' => 'Sports'],
            // Add more communities as needed
        ]);
    }
}
