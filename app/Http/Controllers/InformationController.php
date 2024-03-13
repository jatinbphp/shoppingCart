<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function about_us()
    {
        $data['title'] = 'About Us';
        return view('info-pages.about-us', $data);
    }

    public function faq()
    {
        $data['title'] = "FAQ's";
        return view('info-pages.faq', $data);
    }

    public function privacy_policy()
    {
        $data['title'] = "Privacy Policy";
        return view('info-pages.privacy-policy', $data);
    }

    public function terms_and_conditions()
    {
        $data['title'] = "Terms & Conditions";
        return view('info-pages.terms-and-conditions', $data);
    }
}
