<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class CreateLoanRequestController extends Controller
{
    //

    public function autocomplete(Request $request)
    {
        $item = $request->get('term');

        // $data = User::where('name', 'LIKE', '%'. $item. '%')->where(function(query){
        //     $query->where('status', 1)->
        // })->get();
        
        $data = User::where('name', 'LIKE', '%'. $item. '%')->where('status', 1)->get();

        return response()->json($data);
    }
}
