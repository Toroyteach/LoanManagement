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
        $file = SaccoFile::where('title', 'bylaws')->get();
        return view('onepage.index', compact('file'));
    }

    public function download($uuid)
    {
        
        $book = SaccoFIle::where('uuid', $uuid)->firstOrFail();
        $pathToFile = storage_path('app/files/' . $book->cover);
        return response()->download($pathToFile);
    }

    public function team()
    {
        return view('frontend.pages.team');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function portfolio()
    {
        return view('frontend.pages.portfolio');
    }

    public function services()
    {
        return view('frontend.pages.services');
    }

    public function pricing()
    {
        return view('frontend.pages.pricing');
    }
}
