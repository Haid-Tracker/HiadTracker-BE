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
            // $table->integer('cycle_length');
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
            $table->string('predicted_date', 100);
            $table->string('blood_volume', 25);
            // $table->json('symptoms');
            $table->string('mood', 50);
            $table->boolean('cycle_regularity');
            $table->boolean('medication');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

        Schema::create('symptoms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 50)->unique();
            $table->timestamps();
        });

        // Create pivot table
        Schema::create('record_has_symptoms', function (Blueprint $table) {
            $table->uuid('cycle_record_id');
            $table->uuid('symptom_id');

            $table->foreign('cycle_record_id')
                  ->references('id')
                  ->on('cycle_records')
                  ->onDelete('cascade');
            $table->foreign('symptom_id')
                  ->references('id')
                  ->on('symptoms')
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

        Schema::create('category_article', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('article_has_categories', function (Blueprint $table) {
            $table->uuid('article_id');
            $table->uuid('category_id');

            $table->foreign('article_id')
                  ->references('id')
                  ->on('articles')
                  ->onDelete('cascade');
            $table->foreign('category_id')
                  ->references('id')
                  ->on('category_article')
                  ->onDelete('cascade');

            $table->primary(['article_id', 'category_id']);
        });

        // record article
        Schema::create('record_has_articles', function (Blueprint $table) {
            $table->uuid('cycle_record_id');
            $table->uuid('article_id');

            $table->foreign('cycle_record_id')
                  ->references('id')
                  ->on('cycle_records')
                  ->onDelete('cascade');
            $table->foreign('article_id')
                  ->references('id')
                  ->on('articles')
                  ->onDelete('cascade');

            $table->primary(['cycle_record_id', 'article_id']);
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
        Schema::dropIfExists('symptoms');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('article_has_categories');
        Schema::dropIfExists('category_article');
    }
};
