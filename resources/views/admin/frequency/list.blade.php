@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">

    <style>
        .dataTables_paginate {
            float: right;

        }

        .form-inline {
            display: inline;
        }

        .pagination li {
            margin-left: 10px;
        }
    </style>
@endpush
@push('scripts')
    <script src="/js/admin/frequency/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    <a href="{{ route('admin.frequencies.create') }}" class="btn btn-success mb-3">Thêm mới</a>
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ngày</th>
                <th>Tuần</th>
                <th>Tháng</th>
                <th>Năm</th>
                <th>Số lần</th>
                <th>Hiệu lực</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($frequencies as $key => $frequency)
                <tr class="row{{ $frequency->id }}">
                    <th>{{ $frequency->id }}</th>
                    <td>{{ $frequency->day }}</td>
                    <td>{{ $frequency->week }}</td>
                    <td>{{ $frequency->month }}</td>
                    <td>{{ $frequency->year }}</td>
                    <td>{{ $frequency->time }}</td>
                    <td>{{ $frequency->active }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href='{{ route('admin.frequencies.show', ['id' => $frequency->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $frequency->id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
