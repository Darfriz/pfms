<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the user ID if authenticated.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is authenticated
        if (Auth::check()) {
            // Get the authenticated user
            $user = Auth::user();
            // Get the user ID
            $userId = $user->userID; // Assuming the primary key is 'userID'
            
            // Display user ID
            return "User ID: " . $userId;
        } else {
            // User is not authenticated
            return "User is not logged in.";
        }
    }
}
