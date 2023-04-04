<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Boundary;
use App\Models\User;
use App\Models\Voter;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;


class VotersTableSeeder extends Seeder
{
    public function run()
    {
            // Array of Scotland postcodes
            $scotlandPostcodes = ['AB', 'DD', 'DG', 'EH', 'FK', 'G', 'HS', 'IV', 'KA', 'KW', 'KY', 'ML', 'PA', 'PH', 'TD', 'ZE'];
    
            // Get all users
            $users = User::all();
    
            // Create one voter for each user
            foreach ($users as $user) {
                $faker = Faker::create();
                $dateOfBirth = Carbon::now()->subYears(16)->subDays(rand(1, 365*16)); 
    
                $voter = new Voter;
                $voter->fullname = $user->name;
                $voter->dob = $dateOfBirth->format('Y-m-d');
                $voter->address = $faker->address; // Generate a random address using the Faker library
                $voter->postcode = $this->generateRandomScotlandPostcode(); // Generate random postcode for Scotland only
                $voter->user_id = $user->id;
    
                // Check for matching postcode in the boundaries table
                $boundary = Boundary::where('postcode', $voter->postcode)->first();
                if ($boundary) {
                    $voter->boundary_id = $boundary->id;
                    $voter->constituency = $boundary->constituency;
                    $voter->regional = $boundary->region;
                    $voter->save();
                } else {
                    Log::debug("No boundary found for postcode {$voter->postcode}");
                }
            }
    }
    
        private function generateRandomScotlandPostcode()
        {
            $scotlandPostcodes = ['AB', 'DD', 'DG', 'EH', 'FK', 'G', 'HS', 'IV', 'KA', 'KW', 'KY', 'ML', 'PA', 'PH', 'TD', 'ZE'];
            return $scotlandPostcodes[array_rand($scotlandPostcodes)] . rand(1, 99) . ' ' 
            . rand(1, 9) . $scotlandPostcodes[array_rand($scotlandPostcodes)];
        }
}

 


// class VotersTableSeeder extends Seeder
// {
//     public function run()
//     {
//         // Array of Scotland postcodes
//         $scotlandPostcodes = ['AB', 'DD', 'DG', 'EH', 'FK', 'G', 'HS', 'IV', 'KA', 'KW', 'KY', 'ML', 'PA', 'PH', 'TD', 'ZE'];

//         // Get all users
//         $users = User::all();

//         // Create one voter for each user
//         $users->each(function($user) use ($scotlandPostcodes) {
//             $faker = Faker::create();
//             $dateOfBirth = Carbon::now()->subYears(16)->subDays(rand(1, 365*16)); // Generate random birthdate between 16 and 17 years ago

//             $voter = new Voter;
//             $voter->fullname = $user->name;
//             $voter->dob = $dateOfBirth->format('Y-m-d');
//             $voter->address = $faker->address; // Generate a random address using the Faker library
//             $voter->postcode = $this->generateRandomScotlandPostcode(); // Generate random postcode for Scotland only
//             $voter->user_id = $user->id;

//             // Check for matching postcode in the boundaries table
//             $boundary = Boundary::where('postcode', $voter->postcode)->first();
//             if ($boundary) {
//                 $voter->boundary_id = $boundary->id;
//                 $voter->constituency = $boundary->constituency;
//                 $voter->regional = $boundary->region;
//                 // $voter->expires_at = Carbon::now()->addDays(7); // Set the voter's expiration date to 7 days from now
//                 // $voter->has_voted = false;
//                 $voter->save();
//             } else {
//                 Log::debug("No boundary found for postcode {$voter->postcode}");
//             }
//         });
//     }

//     private function generateRandomScotlandPostcode()
//     {
//         $scotlandPostcodes = ['AB', 'DD', 'DG', 'EH', 'FK', 'G', 'HS', 'IV', 'KA', 'KW', 'KY', 'ML', 'PA', 'PH', 'TD', 'ZE'];
//         return $scotlandPostcodes[array_rand($scotlandPostcodes)] . rand(1, 99) . ' ' . rand(1, 9) . $scotlandPostcodes[array_rand($scotlandPostcodes)];
//     }
// }
