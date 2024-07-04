<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Liability;
use Validator;
class CarController extends Controller
{
    public function index()
    {
        $pageTitle = 'Car Loan Calculator';
        return view('car.index', compact('pageTitle'));
    }
    
    public function saveCarLiabilities(Request $request)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'car_price' => 'required|numeric',
        'down_payment' => 'required|numeric',
        'loan_tenure' => 'required|numeric',
        'interest_rate' => 'required|numeric',
        // Add validation rules for other fields here
    ]);

    // If validation fails, return the error messages
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Retrieve data from the request
    $userID = auth()->id(); // Assuming you're using authentication
    $loanAmount = $request->input('car_price') - $request->input('down_payment');
    $loanTenure = $request->input('loan_tenure');
    $interestRate = $request->input('interest_rate');

    // Calculate monthly payment
    $monthlyInterestRate = $interestRate / 12 / 100;
    $months = $loanTenure * 12;
    $monthlyPayment = ($loanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$months));

    // Save data into liabilities table
    Liability::firstOrCreate([
            'userID' => $userID,
            'liabilities_type' => 'Car Loan', // You can adjust this if necessary
            'liabilities_amount' => $loanAmount,
            'liabilities_loan_tenure' => $loanTenure,
            'liabilities_interest_rate' => $interestRate,
            'liabilities_monthly_payment' => $monthlyPayment
        
    ]);

    // Redirect back or return a response as needed
    return redirect()->back()->with('success', 'DSR value and profile updated successfully.');
}
}