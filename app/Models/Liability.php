<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Liability extends Model
{
    protected $primaryKey = 'liabilitiesID'; // Specify the primary key

    protected $fillable = [
        'userID',
        'liabilities_type',
        'liabilities_amount',
        'liabilities_loan_tenure',
        'liabilities_interest_rate',
        'liabilities_monthly_payment'
        // Add other fillable fields here
    ];

    // Define relationships here if needed
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
