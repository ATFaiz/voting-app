<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(3)->create();

         // Seed the voters table
        //  $this->call(VotersTableSeeder::class);

        //  $this->call(ConstituencyVotesTableSeeder::class);

         $this->call(RegionalVotesTableSeeder::class);

        //  $this->call(CandidatesTableSeeder::class);

        

        
    }
}
