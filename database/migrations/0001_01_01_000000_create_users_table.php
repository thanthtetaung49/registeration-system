<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('profile_path')->nullable();
            $table->unsignedBigInteger('attendees_types_id')->nullable();
            $table->foreign('attendees_types_id')->references('id')->on('attendees_types')->cascadeOnDelete();
            $table->string('name');
            $table->integer('age')->nullable();
            $table->integer('sex')->nullable(); // 0 is male, 1 is female
            $table->string('phone_number')->nullable();
            $table->string('nrc_number')->nullable();
            $table->string('edu_background')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->unique();
            $table->integer('is_admin')->default(0); // 0 is attendees , 1 is admin, 2 security, 3 seftcheck-in user, 4 super  admin
            $table->foreignId('attendees_groups_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default(Hash::make('attendees@123'));
            $table->boolean('disable_status')->default(0); // 0 is not disabled , 1 is diabled
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
