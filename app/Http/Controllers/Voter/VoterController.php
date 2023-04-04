<?php

namespace App\Http\Controllers\Voter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Boundary;
use App\Models\Voter;
use App\Models\ConstituencyVote;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\ConfirmationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\Paginator;


class VoterController extends Controller
{
     

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index(Request $request)
    {
        $search = $request->input('search');

        $voters = Voter::query()->with('boundary');

        if ($search) {
            $voters->where(function ($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                ->orWhere('dob', 'like', "%{$search}%")
                ->orWhere('postcode', 'like', "%{$search}%")
                ->orWhereHas('boundary', function ($q) use ($search) {
                    $q->where('constituency', 'like', "%{$search}%")
                    ->orWhere('region', 'like', "%{$search}%");
                });
            });
        }

        $voters = $voters->with('boundary')->paginate(200);
        Paginator::useBootstrap();
        $page = $request->input('page', 1);

        return view('voter.index', compact('voters', 'search', 'page'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {       
        $user = auth()->user();
        if ($user->voter) {
            $voterId = $user->voter->id;
            $hasVoted = ConstituencyVote::where('voter_id', $voterId)
                                        ->where('constituency', $user->voter->constituency)
                                        ->exists(); 
            if ($hasVoted) {
                return redirect()->route('vote.createRegional');
            } else {
                return view('voter.message');
            }
        } else {
            return redirect()->route('voter.register');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'dob' => 'required|date_format:d/m/Y',
            'address' => 'required',
            'postcode' => 'required',
        ]);

        // Check if the user is at least 16 years old
        $dateOfBirth = Carbon::createFromFormat('d/m/Y', $request->input('dob'));
        if ($dateOfBirth->diffInYears() < 16) {
            return redirect()->back()->withInput()
            ->withErrors(['dob' => 'You must be at least 16 years old to register for voting.']);
        }
        
        $voter = new Voter;
        $voter->fullname = $request->input('fullname');
        $voter->dob = $dateOfBirth->format('Y-m-d');
        $voter->address = $request->input('address');
        $voter->postcode = strtoupper($request->input('postcode'));
        
        // Check for matching postcode in the boundaries table
        $boundary = Boundary::where('postcode', $voter->postcode)->first();
        if ($boundary) {
            $voter->boundary_id = $boundary->id;
        } else {
            Log::debug("No boundary found for postcode {$voter->postcode}");
            return redirect()->back()->withInput()
            ->withErrors(['postcode' => 'Please enter a valid postcode.']);
        }

        $voter->user_id = Auth::user()->id;
        $voter->constituency = $boundary->constituency;
        $voter->regional = $boundary->region;
        $voter->save();

        // Send confirmation email to the user
        Mail::to(Auth::user()->email)->send(new ConfirmationEmail($voter));

        return redirect()->route('voter.show')->with('success', 'Voter added successfully.');
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
        if (!$user->voter) {
            return redirect()->route('home')
            ->with('success', 'You need to be a registered voter to vote.');
        }
        $hasVoted = ConstituencyVote::where('voter_id', $user->voter->id)
                                    ->where('constituency', $user->voter->constituency)
                                    ->exists();
            if ($hasVoted) {
            return redirect()->route('home')
            ->with('success', 'You have already voted in this constituency.');
        }
        return view('voter.thankyou');
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
