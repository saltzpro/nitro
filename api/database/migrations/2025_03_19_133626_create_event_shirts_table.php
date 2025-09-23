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
        Schema::create('event_shirts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id')->nullable();
            $table->string('shirt_title')->nullable();
            $table->string('shirt_description')->nullable();
            $table->text('shirt_sizes')->nullable();
            $table->text('shirt_images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_shirts');
    }
};
