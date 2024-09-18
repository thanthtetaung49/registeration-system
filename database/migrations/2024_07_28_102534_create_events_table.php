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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->longText('description');
            $table->string('location');
            $table->string('credits');
            $table->unsignedBigInteger('lead_instructors_id');
            $table->foreign('lead_instructors_id')->references('id')->on('instructors')->onDelete('cascade');
            $table->unsignedBigInteger('assist_instructors_id');
            $table->foreign('assist_instructors_id')->references('id')->on('instructors')->onDelete('cascade');
            $table->foreignId('categories_id')->constrained()->cascadeOnDelete();
            $table->integer('event_type')->default(1); // 1 = type I and 2 = type II
            $table->string('event_code');
            $table->integer('max_seats');
            $table->string('event_reference_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('early_attendance_min');
            $table->integer('late_attendance_min');
            $table->foreignId('room_numbers_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
