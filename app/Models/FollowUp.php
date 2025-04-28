<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    protected $table = 'followup_table';

    protected $fillable = [
        'CHECKLIST_NAME',
        'BANK_DATE',
        'SAY',
        'COMMENT1',
        'TRIBE',
        'SQUAD',
        'SECOND_LINE',
        'SECOND_LINE_EMEKDASH',
        'RISK_NUMBER',
        'RISKSTATUS',
        'DESCRIPTION',
        'CEDVEL',
        'PROCEDURE_NAME',
        'SKRIPTI_YAZAN_EMEKDASH',
    ];
}
