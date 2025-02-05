@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">FolloUp - Информация</h1>

        <!-- Проверка, есть ли данные -->
        @if($data->isEmpty())
            <p class="text-center">Нет данных для отображения.</p>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>CHECKLIST_NAME</th>
                    <th>BANK_DATE</th>
                    <th>SAY</th>
                    <th>COMMENT1</th>
                    <th>TRIBE</th>
                    <th>SQUAD</th>
                    <th>SECOND_LINE</th>
                    <th>SECOND_LINE_EMEKDASH</th>
                    <th>RISK_NUMBER</th>
                    <th>RISKSTATUS</th>
                    <th>DESCRIPTION</th>
                    <th>CEDVEL</th>
                    <th>PROCEDURE_NAME</th>
                    <th>SKRIPTI_YAZAN_EMEKDASH</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        @endif
    </div>
@endsection
