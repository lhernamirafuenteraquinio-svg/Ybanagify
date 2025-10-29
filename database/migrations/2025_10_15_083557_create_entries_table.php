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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->string('filipino_word');
            $table->string('ybanag_translation');
            $table->string('pronunciation')->nullable();
            $table->string('pronunciation_audio')->nullable();
            $table->text('english_example_sentence')->nullable();
            $table->text('filipino_example_sentence')->nullable();
            $table->text('ybanag_example_sentence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
