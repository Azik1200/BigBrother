<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('followup_table', function (Blueprint $table) {
            $table->id();
            $table->string('CHECKLIST_NAME')->nullable();
            $table->date('BANK_DATE')->nullable();
            $table->string('SAY')->nullable();
            $table->text('COMMENT1')->nullable();
            $table->string('TRIBE')->nullable();
            $table->string('SQUAD')->nullable();
            $table->string('SECOND_LINE')->nullable();
            $table->string('SECOND_LINE_EMEKDASH')->nullable();
            $table->string('RISK_NUMBER')->nullable();
            $table->string('RISKSTATUS')->nullable();
            $table->text('DESCRIPTION')->nullable();
            $table->string('CEDVEL')->nullable();
            $table->string('PROCEDURE_NAME')->nullable();
            $table->string('SKRIPTI_YAZAN_EMEKDASH')->nullable();
            $table->timestamps();
        });
    }

    //todo нужно сильно дорабоать эту часть.


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followup');
    }
};
