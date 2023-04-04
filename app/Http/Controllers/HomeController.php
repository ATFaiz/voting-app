<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\ConstituencyVote;
use App\Models\RegionalVote;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);   
    }

    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      

    $user = auth()->user();

    if ($user->voter) {
        $voterId = $user->voter->id;
    
        // Check if the voter has already voted in the current constituency
        $hasVoted = ConstituencyVote::where('voter_id', $voterId)
                                    ->where('constituency', $user->voter->constituency)
                                    ->exists();
        // Check if the voter has already voted in the current regional
        $hasVoted1 = RegionalVote::where('voter_id', $voterId)
                                    ->where('regional', $user->voter->regional)
                                    ->exists();
    
        // If the voter has already voted, display message
        if ($hasVoted && $hasVoted1) {
            return view('vote.message');
        } else {
            return view('voter.message');
        }
    } else {
        return view('voter.register');
    }
    
    }

    
}
