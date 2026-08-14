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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('module_type')->default('general')->index(); // 'general', 'service', 'project'
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->string('question')->nullable(); // Default/fallback question
            $table->text('answer')->nullable(); // Default/fallback answer
            $table->integer('order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('faq_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_id')->constrained('faqs')->cascadeOnDelete();
            $table->string('locale', 10)->index();
            $table->string('question');
            $table->text('answer');
            $table->timestamps();

            $table->unique(['faq_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('faqs');
    }
};
