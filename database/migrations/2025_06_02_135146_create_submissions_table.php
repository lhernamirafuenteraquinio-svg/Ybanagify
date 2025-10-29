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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();

            // Word details
            $table->string('filipino_word');
            $table->string('ybanag_translation');
            $table->string('pronunciation')->nullable();
            $table->string('pronunciation_audio')->nullable(); // you can store filename or URL

            // Example sentences
            $table->text('english_example_sentence')->nullable();
            $table->text('filipino_example_sentence')->nullable();
            $table->text('ybanag_example_sentence')->nullable();

            // Monitoring fields
            $table->string('submitted_by')->nullable();
            $table->string('submitted_email')->nullable();
            $table->string('submitted_ip')->nullable();
            $table->text('user_agent')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
