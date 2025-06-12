<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\sampleEmail;

class mailcontroller extends Controller
{
    public function index(Request $request)
    {
        Mail::to("arpitbarvaliya1708@gmail.com")->queue(new sampleEmail());
    }
}
