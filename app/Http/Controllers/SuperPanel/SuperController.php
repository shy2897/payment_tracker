<?php

namespace App\Http\Controllers\SuperPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperController extends Controller
{
    public function index()
    {
        return view('super.dashboard');
    }
}
