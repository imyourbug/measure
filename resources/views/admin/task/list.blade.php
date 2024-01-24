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
    <script src="/js/admin/task/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
     <form class="form-group mb-3">
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-success">Thêm mới</a>
        <input class="" style="" type="date" name="from"
            value="{{ Request::get('from') ?? now()->format('Y-m-01') }}" />
        <input class="" style="" type="date" name="to"
            value="{{ Request::get('to') ?? now()->format('Y-m-t') }}" />
        <button class="btn btn-warning" type="submit">Lọc</button>
    </form>
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tần suất</th>
                <th>Nhân sự</th>
                <th>Sơ đồ</th>
                <th>Hóa chất</th>
                <th>Phương pháp</th>
                <th>Vật tư</th>
                <th>Phạm vi</th>
                <th>Lưu ý</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($tasks as $task)
                <tr class="row{{ $task->id }}">
                    <th>{{ $task->id }}</th>
                    <th>{{ $task->frequency->day }}</th>
                    <td>{{ $task->user->staff->name ?? 'Chưa có'}}</td>
                    <th>{{ $task->map->code }}</th>
                    <th>{{ $task->chemistry->name }}</th>
                    <th>{{ $task->solution->name }}</th>
                    <th>{{ $task->item->name }}</th>
                    <td>{{ $task->contract->name }}</td>
                    <td><a class="btn btn-primary btn-sm" href='{{ route('admin.tasks.show', ['id' => $task->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $task->id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
