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
        Schema::create('nlds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->default('-');
            $table->integer('group_id')->nullable();
            $table->text('reporter_name');
            $table->text('issue_type');
            $table->date('updated');
            $table->date('created');
            $table->text('parent_issue_key');
            $table->text('parent_issue_status');
            $table->text('parent_issue_number');
            $table->text('control_status')->nullable();
            $table->date('add_date');
            $table->date('send_date');
            $table->date('done_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nlds');
    }
};
