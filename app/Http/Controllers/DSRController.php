<?php

namespace App\Http\Controllers;

use App\Models\Dsr;
use App\Models\Profile;
use Illuminate\Http\Request;

class DSRController extends Controller
{
    public function index()
    {
        $pageTitle = 'Debt Service Ratio';
        return view('dsr.index', compact('pageTitle'));
    }

    public function saveDsr(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'dsr' => 'required|numeric',
            'netIncome' => 'required|numeric',
            'monthly_commitment' => 'required|numeric',
            'userID' => 'required|integer',
        ]);

        // Retrieve validated inputs
        $dsr = $validatedData['dsr'];
        $netIncome = $validatedData['netIncome'];
        $monthlyCommitment = $validatedData['monthly_commitment'];
        $userId = $validatedData['userID'];

        try {
            // Update or create DSR value
            Dsr::updateOrCreate(
                ['userId' => $userId],
                [
                    'netIncome' => $netIncome,
                    'commitments' => $monthlyCommitment,
                    'dsr' => $dsr,
                ]
            );

            // Update or create profile data
            Profile::updateOrCreate(
                ['userID' => $userId],
                [
                    'Income' => $netIncome,
                    'DSR' => $dsr,
                    // Add other fields as needed
                ]
            );

            // Redirect back with success message
            return redirect()->back()->with('success', 'DSR value and profile updated successfully.');
        } catch (\Exception $e) {
            // Handle any unexpected errors
            return redirect()->back()->with('error', 'Failed to update DSR and profile. Please try again.');
        }
    }
}
