<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserEmailVerificationController extends Controller
{
    public function notice()
    {
        return view('auth.email-notify');
    }

    public function verify()
    {

    }

    public function resend()
    {
        
    }
}
