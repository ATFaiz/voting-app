<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RegionalVote;
use App\Models\Party;
use App\Models\User;

class RegionalVotesTableSeeder extends Seeder
{
    public function run()
    {
        // Get all parties and users
        $parties = Party::all();
        $users = User::all();

        // Create regional votes for each user
        foreach ($users as $user) {
            if ($user->voter) {
                $voter = $user->voter;
                $party = $parties->random();
                $regionalVote = new RegionalVote;
                $regionalVote->vote = 1;
                $regionalVote->regional = $voter->regional;
                $regionalVote->party_id = $party->id;
                $regionalVote->voter_id = $voter->id;
                $regionalVote->save();
            }
        }
    }
}




//     public function run()
// {
//     // Get all parties and users
//     $parties = Party::all();
//     $users = User::all();

//     // Create regional votes for each user
//     foreach ($users as $user) {
//         if ($user->voter) {
//             $voter = $user->voter;
//             $voteCount = 0;
//             foreach ($parties as $party) {
//                 // Check if the party is one of the first 3 in the region
//                 $isFirstThree = RegionalVote::where('regional', $voter->regional)
//                     ->where('party_id', $party->id)
//                     ->whereIn('id', function ($query) {
//                         $query->select('id')
//                             ->from('regional_votes')
//                             ->where('regional', $voter->regional)
//                             ->orderBy('vote', 'desc')
//                             ->limit(3);
//                     })
//                     ->exists();

//                 if ($isFirstThree) {
//                     // Allocate votes based on the party's position in the list
//                     if ($voteCount == 0) {
//                         $voteCount = ceil(0.5 * $voter->total_votes);
//                     } else {
//                         $voteCount = floor(0.25 * $voter->total_votes);
//                     }
//                     // Create regional vote
//                     $regionalVote = new RegionalVote;
//                     $regionalVote->vote = $voteCount;
//                     $regionalVote->regional = $voter->regional;
//                     $regionalVote->party_id = $party->id;
//                     $regionalVote->voter_id = $voter->id;
//                     $regionalVote->save();
//                 } else {
//                     // Skip party if not one of the first 3 in the region
//                     continue;
//                 }
//             }
//         }
//     }
// }

    // public function run()
    // {
    //     // Get all parties and users
    //     $parties = Party::all();
    //     $users = User::all();

    //     // Create regional votes for each user
    //     foreach ($users as $user) {
    //         if ($user->voter) {
    //             $voter = $user->voter;
    //             $party = $parties->random();
    //             $regionalVote = new RegionalVote;
    //             $regionalVote->vote = 1;
    //             $regionalVote->regional = $voter->regional;
    //             $regionalVote->party_id = $party->id;
    //             $regionalVote->voter_id = $voter->id;
    //             $regionalVote->save();
    //         }
    //     }
    // }
// }
