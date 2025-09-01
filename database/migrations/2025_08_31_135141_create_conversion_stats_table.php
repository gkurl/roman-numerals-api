<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // I'm going for an aggregate stats table here given that this scenario
    // is mainly pre-calc'd data, idea is to easily query a running total of conversions and last converted at
    // Using bigInts/bigIncrements for lifetime scaling and extendability in case of change
    public function up(): void
    {
        Schema::create('conversion_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('integer_value')->unique(); //unique to enable upserts via integer, this would hard stop at 3999 I believe so int is fine here
            $table->string('roman', 16); //not sure if this should have a strict length limit of 9 for MMMCMXCIX? Doing 16 for edge case purposes
            $table->bigInteger('conversions_count')->unsigned()->default(0); //can only store positive numbers (unsigned)
            $table->timestamp('last_converted_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversion_stats');
    }
};
