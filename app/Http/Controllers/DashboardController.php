<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Dsr;
use App\Models\Liability;
use App\Models\Asset;

class DashboardController extends Controller
{
    public function index()
    {
        // Initialize variables
        $totalLiabilitiesAmount = 0;
        $totalAssetsAmount = 0;
        $netWorth = 0;
        $dsr = null;

        // Check if the user is logged in
        if (auth()->check()) {
            // Get the current user's ID
            $userId = auth()->id();

            // Fetch the DSR value for the current user
            $dsr = Dsr::where('userId', $userId)->select('dsr')->first();

            // Fetch the total liabilities amount for the current user
            $totalLiabilitiesAmount = Liability::where('userId', $userId)->sum('liabilities_amount');

            // Fetch the total assets amount for the current user
            $totalAssetsAmount = Asset::where('userId', $userId)->sum('assets_amount');

            // Calculate net worth
            $netWorth = $totalAssetsAmount - $totalLiabilitiesAmount;
        }

        // Define the page title
        $pageTitle = 'Dashboard';

        // Pass DSR value, total liabilities amount, total assets amount, net worth, and page title to the view
        return view('dashboard.index', [
            'pageTitle' => $pageTitle,
            'dsr' => $dsr ? (string) $dsr->dsr : null,
            'totalLiabilitiesAmount' => $totalLiabilitiesAmount,
            'totalAssetsAmount' => $totalAssetsAmount,
            'netWorth' => $netWorth,
        ]);
    }
}
