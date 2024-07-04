<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Asset;

class AssetsController extends Controller
{
    public function index()
{
    // Get the current authenticated user's ID
    $userID = Auth::id();

    // Fetch the assets data for the current user
    $assets = Asset::where('userID', $userID)->get();

    $pageTitle = 'Assets';

    // Pass the assets data to the view
    return view('assets.index', compact('pageTitle', 'assets'));
}


public function destroy(Request $request, $id)
{
    $asset = Asset::findOrFail($id);
    $asset->delete();

    return redirect()->route('assets.index')->with('success', 'Asset deleted successfully');
}
}
