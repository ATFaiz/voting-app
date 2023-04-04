<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\BoundaryImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Middleware\EnsureAdminIsVerified;

class ElectoralBoundaryController extends Controller
{  
    /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
    $this-> middleware(['auth:admin', EnsureAdminIsVerified::class]);
   }

   public function uploadfile(){
       return view('admin.boundary');
   }
   
   public function boundary(Request $request)
   {
       $request->validate([
           'file' => 'required|mimes:xlsx,xls|max:2048',
       ]);
   
       $allowedFields = ['postcode', 'region', 'constituency'];
   
       $headers = Excel::toArray(new BoundaryImport, $request->file('file'))[0][0];
   
       $missingFields = array_diff($allowedFields, $headers);
   
       if (!empty($missingFields)) {
           $errorMessage = 'The following fields are missing in the uploaded file: ' . implode(', ', $missingFields);
           return redirect('admin/boundary')->with('error', $errorMessage);
       }
   
        Excel::import(new BoundaryImport, $request->file('file'));
       return redirect('admin/boundary')->with('success', 'Data has been imported!');
   }
   
}
