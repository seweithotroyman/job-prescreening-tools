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
        Schema::create('screening_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_post_id')->constrained()->onDelete('cascade');
            $table->foreignId('resume_id')->constrained()->onDelete('cascade');

            $table->unsignedTinyInteger('fit_score'); // 1 - 10
            $table->json('matched_keywords');         // list kecocokan
            $table->json('missing_keywords')->nullable(); // list gap
            $table->text('ai_summary')->nullable();   // narasi dari GPT
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_results');
    }
};
