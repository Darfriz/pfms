<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDsrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dsr', function (Blueprint $table) {
            $table->id('dsrID'); // Primary Key
            $table->unsignedBigInteger('userID'); // Foreign Key
            $table->decimal('netIncome', 15, 2)->nullable();
            $table->decimal('commitments', 15, 2); // Commitments
            $table->decimal('dsr', 15, 2); // Commitments
            $table->timestamps(); // created_at and updated_at

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
        Schema::dropIfExists('dsr');
    }
}
