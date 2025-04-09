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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nld_id'); // заменили task_id на nld_id
            $table->text('comment');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('nld_id')->references('id')->on('nlds')->onDelete('cascade'); // связь с таблицей nlds
            $table->foreign('user_id')->references('id')->on('users'); // связь с таблицей users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
