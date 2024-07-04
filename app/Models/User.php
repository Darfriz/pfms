<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->createProfile();
        });
    }

    public function createProfile()
    {
        if (!Schema::hasTable('profiles')) {
            // Create the profiles table if it doesn't exist
            Schema::create('profiles', function ($table) {
                $table->id();
                $table->foreignId('userID')->constrained()->onDelete('cascade');
                $table->decimal('Income', 8, 2)->default(0.00);
                $table->decimal('DSR', 8, 2)->default(0.00);
                $table->decimal('NetWorth', 10, 2)->default(0.00);
                $table->decimal('TotalAssets', 10, 2)->default(0.00);
                $table->decimal('TotalLiabilities', 10, 2)->default(0.00);
                $table->timestamps();
            });
        }

        // Insert a new row into the profiles table
        DB::table('profiles')->insert([
            'userID' => $this->id,
            'DSR' => 0.00, // Set default values for other columns if needed
            'NetWorth' => 0.00,
            'TotalAssets' => 0.00,
            'TotalLiabilities' => 0.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}