<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Liability;

class LiabilitiesController extends Controller
{
    public function index()
    {
        // Get the current authenticated user's ID
        $userID = Auth::id();

        // Fetch the liabilities data for the current user
        $liabilities = Liability::where('userID', $userID)->get();

        $pageTitle = 'Liabilities';

        // Pass the liabilities data to the view
        return view('liabilities.index', compact('pageTitle', 'liabilities'));
    }

    public function destroy($id)
{
    $liability = Liability::findOrFail($id);
    $liability->delete();

    return redirect('/liabilities')->with('success', 'Liability deleted successfully');
}
}
