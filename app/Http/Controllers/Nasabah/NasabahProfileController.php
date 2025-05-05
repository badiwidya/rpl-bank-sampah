<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NasabahProfileController extends Controller
{
    public function create()
    {
        return view('nasabah.profile');
    }
}
