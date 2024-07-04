<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dsr extends Model
{
    protected $table = 'dsr';

    protected $primaryKey = 'dsrID';

    protected $fillable = [
        'userID', 'netIncome', 'commitments', 'dsr'
    ];
}
