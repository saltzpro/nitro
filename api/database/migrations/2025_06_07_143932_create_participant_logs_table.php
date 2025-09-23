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
        Schema::create('participant_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id')->nullable();
            $table->bigInteger('registration_id')->nullable();
            $table->string('transaction_number')->nullable();
            $table->string('logs')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_logs');
    }
};
