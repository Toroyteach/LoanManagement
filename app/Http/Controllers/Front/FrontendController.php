<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\SaccoFile;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //

    public function index()
    {
        // $file = SaccoFile::get();
        // return view('onepage.index', compact('file'));
        return view('frontend.pages.home');
    }

    public function download($uuid)
    {
        
        // $book = SaccoFIle::where('uuid', $uuid)->firstOrFail();
        // $pathToFile = storage_path('app/files/' . $book->cover);
        // return response()->download($pathToFile);
    }

    public function about()
    {
        return view('frontend.pages.about');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function resources()
    {
        return view('frontend.pages.resources');
    }

    public function products()
    {
        return view('frontend.pages.products');
    }

    public function team()
    {
        return view('frontend.pages.team');
    }

}
