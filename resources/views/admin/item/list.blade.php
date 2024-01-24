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
    <script src="/js/admin/item/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    <a href="{{ route('admin.items.create') }}" class="btn btn-success mb-3">Thêm mới</a>
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vật tư</th>
                <th>Đối tượng áp dụng</th>
                <th>Ảnh</th>
                <th>Nhà cung cấp</th>
                <th>Hiệu lực</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($items as $key => $item)
                <tr class="row{{ $item->id }}">
                    <th>{{ $item->id }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->target }}</td>
                    <td><img width="50px" height="50px" src="{{ $item->image }}" alt="image"></td>
                    <td>{{ $item->supplier }}</td>
                    <td>{{ $item->active }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href='{{ route('admin.items.show', ['id' => $item->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $item->id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
