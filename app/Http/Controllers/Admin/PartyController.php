<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Party;
use App\Models\Admin;
use App\Models\Candidate;
use Illuminate\Support\Facades\File;


class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        {
            $parties = Party::all();
            return view('admin.party.home', compact('parties'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.party.create');
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
            'name' => 'required', //Regular Expression only allows letters, hyphens and spaces explicitly
            'image' => 'required|mimes:jpeg,bmp,png,jpg',    
        ]);

        $parties = new Party;
        $parties->name = $request->input('name');

        $fileName = time().$request->file('image')->hashName();
        $path = $request->file('image')->storeAs('media', $fileName, 'public');
        $parties['image'] = '/storage/'.$path;
        
        $parties->admin_id = Auth::user()->id;

        $parties->save();

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
        $parties = Party::where('id', $id)->firstOrFail();
        return view('admin.party.edit', compact('parties'));
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
            'name' => 'required'
        ]);
       
        $parties = Party::findOrFail($id);
        $parties->name = $request->input('name');

        if($request->hasfile('image')){
            
            $path=public_path($parties->image);
            if(File::exists($path)){
                File::delete($path);
            }
            
            $fileName = time().$request->file('image')->hashName();
            $path = $request->file('image')->storeAs('media', $fileName, 'public');
            $parties ['image'] = '/storage/'.$path;

        }
        
        $parties->save();
        return back()->with('success', 'Contact updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $party = Party::find($id);
        
    
        if (!$party) {
            return redirect()->back()->with('error', 'Party not found.');
        }
    
        if ($party->candidate()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete party with candidates.');
        }

        
        unlink(public_path($party->image));
        $party->delete();
    
        return redirect()->back()->with('status', 'Party deleted successfully.');
    }
    
}
