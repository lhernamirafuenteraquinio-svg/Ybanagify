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
        Schema::create('dictionaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entry_id')->nullable();
            $table->string('filipino_word');
            $table->string('ybanag_translation');
            $table->string('pronunciation')->nullable();
            $table->string('pronunciation_audio')->nullable();
            $table->string('part_of_speech')->nullable();
            $table->text('tagalog_meaning')->nullable();
            $table->text('english_example_sentence')->nullable();
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
        Schema::dropIfExists('dictionaries');
    }
};
