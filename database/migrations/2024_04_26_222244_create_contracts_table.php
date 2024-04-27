<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');

            $table->date('sign_date');

            // The start date, also known as the effective date or commencement date, is the date from which the contractual obligations or provisions outlined in the contract begin to take effect.
            $table->date('start_date');

            $table->date('end_date');
            
            $table->decimal('interest_rate', 5, 2);
            $table->integer('loan_term_months');
            $table->decimal('principal', 10, 2);
            // terminated: premature ending of a contract before its natural expiration date
            // expired: loan term has ended, and the borrower has fulfilled their obligations by repaying the loan in full
            $table->enum('status', ['active', 'expired', 'terminated'])->default('active');
            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('loan_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
