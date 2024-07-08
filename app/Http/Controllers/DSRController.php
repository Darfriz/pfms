<?php

namespace App\Http\Controllers;

use App\Models\Dsr;
use Illuminate\Http\Request;
use App\Models\Profile;

class DSRController extends Controller
{
    public function index()
    {
        $pageTitle = 'Debt Service Ratio';
        return view('dsr.index', compact('pageTitle'));
    }

    public function saveDsr(Request $request)
    {
        // Retrieve DSR value, net income, and monthly commitment from the request
        $dsr = $request->input('dsr');
        $netIncome = $request->input('netIncome', $request->input('net_income'));
        $monthlyCommitment = $request->input('monthly_commitment');
        $userId = $request->input('userID');

        // Store or update the DSR value, net income, and monthly commitment in the database
        Dsr::updateOrCreate(
            ['userID' => $userId],
            [
                'dsr' => $dsr,
                'netIncome' => $netIncome,
                'commitments' => $monthlyCommitment
            ]
        );

        // Store or update the profile data, overwriting existing data if it exists
        Profile::updateOrCreate(
            ['userID' => $userId],
            [
                'Income' => $netIncome,
                'DSR' => $dsr
            ]
        );

        // Redirect back or return a response as needed
        return redirect()->back()->with('success', 'DSR value and profile updated successfully.');
    }
}
