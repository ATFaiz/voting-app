<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Candidate;
use App\Models\Region;
use App\Models\Constituency;
use App\Models\ConstituencyVote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;


class CandidateController extends Controller
{
    
    public function filterConstituencies(Request $request)
    {
        $constituencies = Constituency::
        where('region_id', $request->region_id)->get();
        return response()->json($constituencies);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $search = $request->input('search');
        $candidates = Candidate::query()->with('party');
        if ($search) {
            $candidates->where(function ($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                ->orWhere('regional', 'like', "%{$search}%")
                ->orWhere('constituency', 'like', "%{$search}%")
                ->orWhereHas('party', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        $candidates = $candidates->paginate(35);
        Paginator::useBootstrap();
        $page = $request->input('page', 1);

        return view('admin.candidate.home', compact('candidates','page', 'search'));
    }
    
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parties = Party::all();
        $regions = Region::all();
        $constituencies = Constituency::all();
        return view('admin.candidate.registre', 
        compact('parties','regions','constituencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required', 
            'image'=>'required|mimes:jpeg,bmp,png,jpg',
            
            'party_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value == 'Select Party') {
                        $fail('Please select a valid party.');
                    }
                }
            ],
            'constituency_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value == 'Select a constituency') {
                        $fail('Please select a valid constituency.');
                    }
                }
            ],
            'region_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value == 'Select a region') {
                        $fail('Please select a valid region.');
                    }
                }
            ]

        ]);

        $candidate = new Candidate;
        $candidate->fullname = $request->input('fullname');  
        $fileName = time().$request->file('image')->hashName();
        $path = $request->file('image')->storeAs('media', $fileName, 'public');
        $candidate['image'] = '/storage/'.$path;
        $candidate->admin_id = Auth::user()->id;

        $constituencyId= $request->input('constituency_id');
        if (!empty($constituencyId)) {
            $constituency= Constituency::find($constituencyId);
            $candidate->constituency = $constituency->constituency;
        } else {
            $candidate->constituency = 'None';
        }
        
        $regionId = $request->input('region_id');
        if (!empty($regionId)) {
            $region = Region::find($regionId);
            $candidate->regional = $region->region;
        } else {
            $candidate->regional = 'None';
        }
                
        $candidate->party_id = $request->party_id;   
        $candidate->save();
        return back()->with('success', 'Contact created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $parties = Party::all();
        $regions = Region::all();
        $constituencies = Constituency::all();
        $candidate = Candidate::where('id', $id)->firstOrFail();
        $selected_party_id = $candidate->party_id;
        return view('admin.candidate.edit', compact('candidate','parties',
                     'regions', 'constituencies','selected_party_id'));
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
        $this->validate($request, [
            'fullname' => 'required'
        ]);

        $candidate = Candidate::findOrFail($id);
        $candidate->fullname = $request->input('fullname');
        
        if($request->hasfile('image')){   
            $path=public_path($candidate->image);
            if(File::exists($path)){
                File::delete($path);
            }
            $fileName = time().$request->file('image')->hashName();
            $path = $request->file('image')->storeAs('media', $fileName, 'public');
            $candidate ['image'] = '/storage/'.$path;
        }

        $constituencyId= $request->input('constituency_id');
        if (!empty($constituencyId)) {
            $constituency= Constituency::find($constituencyId);
            $candidate->constituency = $constituency->constituency;
        } else {
            $candidate->constituency = 'None';
        }
        
        $regionId = $request->input('region_id');
        if (!empty($regionId)) {
            $region = Region::find($regionId);
            $candidate->regional = $region->region;
        } else {
            $candidate->regional = 'None';
        }
      
        $candidate->party_id = $request->party_id;
        $candidate->admin_id = Auth::user()->id;
        $candidate->save();
        return back()->with('success', 'Contact created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidate = Candidate::find($id);    
        if (!$candidate) {
            return redirect()->back()->with('error', 'Candidate not found.');
        }
        if (DB::table('constituency_votes')
            ->where('candidate_id', $candidate->id)->exists()) {
            return redirect()->back()
            ->with('error', 'Cannot delete Candidate with votes.');
        }
        unlink(public_path($candidate->image));
        $candidate->delete();
        return redirect()->back()->with('status', 'Candidate deleted successfully.');
    }   
               
}
