<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    /**
     * Show the landing page.
     */
    public function index()
    {
        return view('pages.landing.home');
    }

    /**
     * Show the terms and conditions.
     */
    public function terms()
    {
        return view('pages.landing.terms');
    }
}
