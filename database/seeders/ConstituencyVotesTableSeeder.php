<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConstituencyVote;
use App\Models\Candidate;
use App\Models\User;

class ConstituencyVotesTableSeeder extends Seeder
{
    public function run()
    {
        $candidates = Candidate::all();
        $users = User::all();
        // Create constituency votes for each user
        foreach ($users as $user) {
            if ($user->voter) {
                $voter = $user->voter;
                $candidatesInConstituency = $candidates->where('constituency', $voter->constituency);
                if ($candidatesInConstituency->isEmpty()) {
                    continue; // Skip this voter since there are no candidates running in their constituency
                }
                $candidate = $candidatesInConstituency->random();
                $constituencyVote = new ConstituencyVote;
                $constituencyVote->vote = 1;
                $constituencyVote->constituency = $voter->constituency;
                $constituencyVote->voter_id = $voter->id;
                $constituencyVote->candidate_id = $candidate->id;
                $constituencyVote->save();
            }
        }
    }
}

