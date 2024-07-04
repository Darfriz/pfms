<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Asset; // Assuming you have an Asset model for the assets table

class PropertyController extends Controller
{
    public function index()
    {
        $pageTitle = 'Property Loan Calculator';
        return view('property.index', compact('pageTitle'));
    }

    public function saveProperty(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'property_price' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'loan_tenure' => 'required|integer',
            // Add more validation rules as needed
        ]);

        // Calculate any necessary data
        // For example, calculate monthly payment if required
        $monthlyPayment = $this->calculateMonthlyPayment(
            $validatedData['property_price'],
            $validatedData['interest_rate'],
            $validatedData['loan_tenure']
        );

        // Get the current authenticated user's ID
        $userID = Auth::id();

        // Create a new Asset instance for each save operation
        $newAsset = new Asset();
        $newAsset->userID = $userID;
        $newAsset->assets_type = 'Property'; // Assuming you have a field for asset type
        $newAsset->assets_amount = $validatedData['property_price'];
        $newAsset->assets_interest_rate = $validatedData['interest_rate'];
        $newAsset->assets_loan_tenure = $validatedData['loan_tenure'];
        $newAsset->assets_monthly_payment = $monthlyPayment;
        $newAsset->save();

        // Optionally, you can return a response or redirect as needed
        return redirect()->back()->with('success', 'Property value saved successfully.');
    }

    // Example function to calculate monthly payment
    private function calculateMonthlyPayment($propertyPrice, $interestRate, $loanTenure)
    {
        // Perform your calculation here based on the provided inputs
        // Return the calculated monthly payment
        // Example calculation:
        $monthlyInterestRate = $interestRate / 12 / 100; // Convert annual interest rate to monthly
        $months = $loanTenure * 12;
        $monthlyPayment = ($propertyPrice * $monthlyInterestRate * pow(1 + $monthlyInterestRate, $months)) /
            (pow(1 + $monthlyInterestRate, $months) - 1);
        
        return $monthlyPayment;
    }
}
