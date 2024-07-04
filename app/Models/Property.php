<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'property_price',
        'interest_rate',
        'loan_tenure',
        'monthly_payment',
        // Add more attributes as needed
    ];

    // Optionally, define relationships or additional methods here
}
