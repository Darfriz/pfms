<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function index()
    {
        $pageTitle = 'Privacy Policy';
        return view('policy.index', compact('pageTitle'));
    }
}
