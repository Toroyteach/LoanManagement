<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //

    public function index()
    {
        return view('frontend.pages.home');
    }

    public function about()
    {
        return view('frontend.pages.about');
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
