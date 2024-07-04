<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function index()
    {
        $pageTitle = 'Credit Card Loan Calculator';
        return view('credit.index', compact('pageTitle'));
    }
}
