@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <h1>Contents of the Excel file</h1>
        @if(!empty($data))
            <table class="table table-bordered">
                <thead>
                <tr>
                    @foreach ($data[0] as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach (array_slice($data, 1) as $row)
                    <tr>
                        @foreach ($row as $cell)
                            <td>{{ $cell }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>The Excel file is empty or cannot be read.</p>
        @endif
        <a href="{{ route('excel.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
@endsection
