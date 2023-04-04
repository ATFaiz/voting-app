<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Candidate;
use App\Models\Party;
use App\Models\Admin;
use Faker\Factory as Faker;

class CandidatesTableSeeder extends Seeder
{
    public function run()
    {
        // Get all parties and admins
        $parties = Party::all();
        $admins = Admin::all();

        // Create candidates for each party
        for ($i = 0; $i < 524; $i++) {
            $party = $parties->random();
            $admin = $admins->random();
            Candidate::factory()->create([
                'party_id' => $party->id,
                'admin_id' => $admin->id,
            ]);
        }
        
    }
}