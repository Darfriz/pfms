<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    protected $primaryKey = 'assetsID'; // Specify the primary key

    protected $fillable = [
        'userID',
        'assets_type',
        'assets_amount',
        'assets_loan_tenure',
        'assets_interest_rate',
        'assets_monthly_payment'
        // Add other fillable fields here
    ];

    // Define relationships here if needed
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
