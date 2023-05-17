@extends('admin/print/template')
@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Jenis</th>
                <th>Model</th>
                <th>Ukuran</th>
                <th>Harga</th>
                <th>INCH/PCS</th>
                <th>Disc (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vbelts as $row)
            <tr data-id="{{ $row->id }}">
                <td>{{ $row->type_code }}</td>
                <td>{{ $row->model }}</td>
                <td>{{ $row->size_min }} s/d {{ $row->size_max }}</td>
                <td>{{ number_format($row->price, 0) }}</td>
                <td>{{ $row->price_unit }}</td>
                <td>{{ number_format($row->discount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection