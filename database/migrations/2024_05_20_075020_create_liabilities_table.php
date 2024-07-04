<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liabilities', function (Blueprint $table) {
            $table->id('liabilitiesID');
            $table->unsignedBigInteger('userID');
            $table->string('liabilities_type');
            $table->decimal('liabilities_amount', 15, 2);
            $table->integer('liabilities_loan_tenure');
            $table->decimal('liabilities_interest_rate', 5, 2);
            $table->decimal('liabilities_monthly_payment', 15, 2);
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
        Schema::dropIfExists('liabilities');
    }
}
