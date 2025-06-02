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
        Schema::create('book_subject', function (Blueprint $table) {
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->primary(['book_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_subject', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->dropForeign(['subject_id']);
        });
    }
};
