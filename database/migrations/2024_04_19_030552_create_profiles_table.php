<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id('profileID'); // Primary Key
            $table->unsignedBigInteger('userID'); // Foreign Key
            $table->decimal('Income', 8, 2)->default(0.00);
            $table->decimal('DSR', 8, 2)->default(0.00);
            $table->decimal('NetWorth', 8, 2)->default(0.00);
            $table->decimal('TotalAssets', 8, 2)->default(0.00);
            $table->decimal('TotalLiabilities', 8, 2)->default(0.00);
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
