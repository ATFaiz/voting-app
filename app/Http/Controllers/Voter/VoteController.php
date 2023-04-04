<?php

namespace App\Http\Controllers\Voter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Voter;
use App\Models\User;
use App\Models\Candidate;
use App\Models\Party;
use App\Models\ConstituencyVote;
use App\Models\RegionalVote;
use App\Notifications\ConstituencyVoteNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;


class VoteController extends Controller
{
    
    public function sendConstituencyVoteNotification()
    {
       
        // $voters = Voter::all();
        $voters = Voter::orderBy('id', 'desc')->take(3)->get();
        $notification = new ConstituencyVoteNotification;
        Notification::send($voters, $notification);
    }  
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
        
    public function createConstituency()
    {
        $user = auth()->user();
            // Check if the user is a registered voter
            if (!$user->voter) {
                return redirect()->route('home')->with('message', 'You need to be a registered voter to vote.');
            }
     $voterId = Auth::user()->voter->id;
    // Check if the voter has already voted in the current constituency
    $hasVoted = ConstituencyVote::where('voter_id', $voterId)
                                ->where('constituency', Auth::user()->voter->constituency) ->exists();                          
        if ($hasVoted) {
        return redirect()->route('vote.createRegional')->with('success', 'You have already voted in this constituency.');
    }
        $user_id = Auth::user()->id;
        $voter = Voter::where('user_id', $user_id)->first();
        if ($voter) {
            $candidates = Candidate::where('constituency', $voter->constituency)->get();
            return view('vote.create-constituency', compact('voter', 'candidates',));
        } else {
            return redirect()->route('error')->with('message', 'No voter object found for this user.');
        }
    }

      public function storeConstituency(Request $request)
        {
            //   Validate the form data
            $request->validate([
                'candidate_id' => 'required|exists:candidates,id',
            ]);

            // Create a new vote
            $constituencyVote = new ConstituencyVote();
            $constituencyVote->voter_id = Auth::user()->voter->id;
            $constituencyVote->constituency = Auth::user()->voter->constituency;
            $constituencyVote->candidate_id = $request->input('candidate_id');
            $constituencyVote->vote = 1;
            $constituencyVote->save();

            // Redirect back to the create page with a success message
            return redirect()->route('vote.createRegional')
            ->with('success', 'Constituency vote has been submitted, now cast your regional vote');
            
        }

    public function createRegional()
    {
        $user = auth()->user();
        // Check if the user is a registered voter
        if (!$user->voter) {
            return redirect()->route('home')->with('message', 'You need to be a registered voter to vote.');
        }
        // Get the voter's ID
      $voterId = Auth::user()->voter->id;
      // Check if the voter has already voted in the current constituency
      $hasVoted = RegionalVote::where('voter_id', $voterId)
                                  ->where('regional', Auth::user()->voter->regional)
                                  ->exists();                            
       if ($hasVoted) {
          return redirect()->route('home')->with('success', 'You have already voted in this constituency.');
      }
        $user_id = Auth::user()->id;
        $voter = Voter::where('user_id', $user_id)->first();
        $parties = Party::all();
        return view('vote.create-regional', compact('voter','parties'));

    }

    public function storeRegional(Request $request)
    {
        // Validate the form data
        $request->validate([
            'party_id' => 'required|exists:parties,id',
        ]);

        // Create a new vote
        $regionalVote = new RegionalVote();
        $regionalVote->voter_id = Auth::user()->voter->id;
        $regionalVote->regional = Auth::user()->voter->regional;
        $regionalVote->party_id = $request->input('party_id');
        $regionalVote->vote = 1;
        $regionalVote->save();

        // Redirect the page with a success message
        return redirect()->route('vote.show')->with('success', 'Vote submitted successfully.');
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     
        public function show()
        {
            $user = auth()->user();
        // Check if the user is a registered voter
        if (!$user->voter) {
            return redirect()->route('home')
            ->with('error', 'You need to be a registered voter to vote.');
        }
        if ($user->voter) {
            return redirect()->route('home')
            ->with('error', 'You need cast your votes.');
        }
        return view('vote.message');     
        }

   
    public function searchConstituencyVote(Request $request)
    {
        $constituencies = DB::table('constituency_votes')
            ->join('candidates', 'constituency_votes.candidate_id', '=', 'candidates.id')
            ->select('constituency_votes.constituency')
            ->distinct('constituency_votes.constituency')
            ->orderBy('candidates.regional')
            ->orderBy('constituency_votes.constituency')
            ->pluck('constituency_votes.constituency');

        $constituency = $request->input('constituency');

        $candidates = DB::table('constituency_votes')
            ->join('candidates', 'constituency_votes.candidate_id', '=', 'candidates.id')
            ->select('candidate_id', 'candidates.image', 'candidates.fullname', 
            DB::raw('SUM(vote) as total_votes'))
            ->where('constituency_votes.constituency', $constituency)
            ->groupBy('candidate_id', 'candidates.fullname', 'candidates.image')
            ->orderByDesc('total_votes')
            ->get();

        $winners = $candidates->filter(function ($candidate) use ($candidates) {
            return $candidate->total_votes == $candidates->first()->total_votes;
        });

        return view('vote.constituencyVote-result', [
            'constituencies' => $constituencies,
            'candidates' => $candidates,
            'constituency' => $constituency,
            'winners' => $winners,
        ]);
    }

    public function calculateRegionalSeats($votes, $num_seats) {
        $seats = array_fill_keys(array_keys($votes), 0);
        for ($i = 0; $i < $num_seats; $i++) {
            $max_quotient = 0;
            $max_party = null;   
            foreach ($votes as $party => $vote_count) {
                $quotient = $vote_count / ($seats[$party] + 1);   
                if ($quotient > $max_quotient) {
                    $max_quotient = $quotient;
                    $max_party = $party;
                }
            } 
            // $seats[$max_party]++;
            if (array_key_exists($max_party, $seats)) {
                $seats[$max_party]++;
            } else {
                
            }            
        }
        return $seats;
    }

    public function searchRegionalVote(Request $request)
    {
        // Retrieve the list of regions and the selected region

        $regions = DB::table('regional_votes')
            ->select('regional')
            ->distinct()
            ->orderBy('regional')
            ->pluck('regional');
        $regional = $request->input('regional');

        // Retrieve the list of parties and their total votes in the selected region

        $parties = DB::table('regional_votes')
            ->join('parties', 'regional_votes.party_id', '=', 'parties.id')
            ->select('party_id', 'parties.name', DB::raw('SUM(vote) as total_votes'))
            ->where('regional_votes.regional', $regional)
            ->groupBy('party_id', 'parties.name')
            ->orderByDesc('total_votes')
            ->get();

        // Calculate the number of regional seats for each party using the D'Hondt method

        $votes = $parties->pluck('total_votes', 'name')->all();
        $num_seats = 7;
        $seats = $this->calculateRegionalSeats($votes, $num_seats);

        // Create a new array to store the parties with their allocated seats
        $parties_with_seats = [];

        foreach ($parties as $party) {
            $party->seats = $seats[$party->name];
            $parties_with_seats[] = $party;
        }

        return view('vote.regionalVote-result', [
            'regions' => $regions,
            'parties' => $parties_with_seats,
            'regional' => $regional,
        ]);
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
