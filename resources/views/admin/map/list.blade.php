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
    <script src="/js/admin/map/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    <a href="{{ route('admin.maps.create') }}" class="btn btn-success mb-3">Thêm mới</a>
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã sơ đồ</th>
                <th>Vị trí</th>
                <th>Ảnh</th>
                <th>Mô tả</th>
                <th>Hiệu lực</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($maps as $key => $map)
                <tr class="row{{ $map->id }}">
                    <th>{{ $map->id }}</th>
                    <td>{{ $map->code }}</td>
                    <td>{{ $map->position }}</td>
                    <td><img width="50px" height="50px" src="{{ $map->image }}" alt="image"></td>
                    <td>{{ $map->description }}</td>
                    <td>{{ $map->active }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href='{{ route('admin.maps.show', ['id' => $map->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $map->id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
