@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">FollowUp - Information ({{ now()->format('d.m.Y') }})</h1>

        @if($data->isEmpty())
            <p class="text-center">There is no data to display.</p>
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
                @foreach($data as $row)
                    <tr>
                        <td>{{ $row->CHECKLIST_NAME }}</td>
                        <td>{{ $row->BANK_DATE }}</td>
                        <td>{{ $row->SAY }}</td>
                        <td>{{ $row->COMMENT1 }}</td>
                        <td>{{ $row->TRIBE }}</td>
                        <td>{{ $row->SQUAD }}</td>
                        <td>{{ $row->SECOND_LINE }}</td>
                        <td>{{ $row->SECOND_LINE_EMEKDASH }}</td>
                        <td>{{ $row->RISK_NUMBER }}</td>
                        <td>{{ $row->RISKSTATUS }}</td>
                        <td>{{ $row->DESCRIPTION }}</td>
                        <td>{{ $row->CEDVEL }}</td>
                        <td>{{ $row->PROCEDURE_NAME }}</td>
                        <td>{{ $row->SKRIPTI_YAZAN_EMEKDASH }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
