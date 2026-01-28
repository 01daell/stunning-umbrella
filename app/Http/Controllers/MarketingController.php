<?php

namespace App\Http\Controllers;

class MarketingController extends Controller
{
    public function landing()
    {
        return view('marketing.landing');
    }

    public function pricing()
    {
        return view('marketing.pricing');
    }

    public function faq()
    {
        return view('marketing.faq');
    }
}
