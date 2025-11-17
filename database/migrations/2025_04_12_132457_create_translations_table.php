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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entry_id')->nullable();
            $table->string('filipino_word');
            $table->string('ybanag_translation');
            $table->string('pronunciation_audio')->nullable(); // File path or URL for audio;
            $table->text('filipino_example_sentence')->nullable();
            $table->text('ybanag_example_sentence')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
