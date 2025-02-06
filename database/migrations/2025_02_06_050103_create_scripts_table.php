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
        Schema::create('scripts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('procedure_id')->constrained()->onDelete('cascade');
            $table->text('script');
            $table->integer('author_id')->nullable();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scripts');
    }
};
