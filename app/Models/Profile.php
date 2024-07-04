<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = 'profileID'; // Specify the primary key

    protected $fillable = [
        'userID',
        'Income',
        'DSR'
        // Add other fillable fields here
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
