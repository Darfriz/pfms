<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('assets', function (Blueprint $table) {
        $table->id('assetsID'); // Primary key
        $table->unsignedBigInteger('userID'); // Foreign key referencing userID in users table
        $table->string('assets_type');
        $table->decimal('assets_amount', 15, 2);
        $table->integer('assets_loan_tenure');
        $table->decimal('assets_interest_rate', 5, 2);
        $table->decimal('assets_monthly_payment', 15, 2);
        $table->timestamps();

        // Define foreign key constraint
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
        Schema::dropIfExists('assets');
    }
}
