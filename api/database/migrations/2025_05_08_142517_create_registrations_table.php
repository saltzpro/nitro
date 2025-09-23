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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id')->nullable();
            $table->bigInteger('event_category_id')->nullable();
            $table->decimal('event_category_total', total: 8, places: 2)->nullable();
            $table->bigInteger('event_pickup_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->string('organization')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('emergency_contact_person')->nullable();
            $table->string('emergency_relationship')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
