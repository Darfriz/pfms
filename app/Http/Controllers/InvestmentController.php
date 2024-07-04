<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Asset;

class InvestmentController extends Controller
{
    public function index()
    {
        $pageTitle = 'Investment Loan Calculator';
        return view('investment.index', compact('pageTitle'));
    }

    public function saveInvestment(Request $request)
    {
        // Validate the request data
        $request->validate([
            'investment_type' => 'required|string',
            'TotalReturnResult' => 'required|numeric',
            'investment_tenure' => 'required|integer',
            'annual_return' => 'required|numeric',
            'monthly_contribution' => 'required|numeric',
        ]);

        // Get the current user's ID
        $userId = Auth::id();

        // Create a new asset entry
        Asset::create([
            'userID' => $userId,
            'assets_type' => $request->input('investment_type'),
            'assets_amount' => $request->input('TotalReturnResult'),
            'assets_loan_tenure' => $request->input('investment_tenure'),
            'assets_interest_rate' => $request->input('annual_return'),
            'assets_monthly_payment' => $request->input('monthly_contribution'),
        ]);

        return redirect()->back()->with('success', 'Investment data saved successfully.');
    }
}
