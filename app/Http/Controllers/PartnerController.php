<?php

namespace App\Http\Controllers;

use App\Models\Partner; 
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        return view('partner.dashboard');
    }

    public function about()
    {
        return view('partner.about.show');
    }

    public function locations()
    {
        return view('partner.locations.show');
    }

    public function program()
    {
        return view('partner.program.show');
    }

    public function report()
    {
        return view('partner.report.show');
    }

    public function notifications()
    {
        return view('partner.notifications.show');
    }

    public function profile()
    {
        return view('partner.profile.show');
    }

}
