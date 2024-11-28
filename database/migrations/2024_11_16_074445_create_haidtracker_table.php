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
        // Create Profiles table
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->date('birth_date');
            $table->decimal('weight', 5, 2);
            $table->decimal('height', 5, 2);
            $table->string('photo')->nullable();
            $table->integer('cycle_length');
            $table->date('last_period_date');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

        // Create Cycle Records table
        Schema::create('cycle_records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('predicted_date');
            $table->enum('blood_volume', ['light', 'medium', 'heavy']);
            $table->json('symptoms');
            $table->string('mood', 50);
            $table->boolean('medication');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

        // Create Articles table
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('hero_photo')->nullable();
            $table->longText('content');
            $table->string('author', 100)->default('Haid Tracker - Team');
            $table->timestamps();
        });

        // Create Feedback table
        Schema::create('feedback', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cycle_record_id');
            $table->enum('status', ['normal', 'abnormal']);
            $table->text('feedback');
            $table->timestamps();

            $table->foreign('cycle_record_id')
                  ->references('id')
                  ->on('cycle_records')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order to avoid foreign key constraints
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('cycle_records');
        Schema::dropIfExists('profiles');
    }
};
