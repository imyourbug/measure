@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush
@push('scripts')
    <script src="/js/admin/branch/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    <a href="{{ route('admin.branches.create') }}" class="btn btn-success mb-3">Thêm mới</a>
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên chi nhánh</th>
                <th class="hide-max-600">Email</th>
                <th class="hide-max-600">Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Quản lý</th>
                <th>Khách hàng</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($branches as $key => $branch)
                <tr class="row{{ $branch->id }}">
                    <th>{{ $branch->id }}</th>
                    <td>{{ $branch->name }}</td>
                    <td class="hide-max-600">{{ $branch->email }}</td>
                    <td class="hide-max-600">{{ $branch->tel }}</td>
                    <td>{{ $branch->address }}</td>
                    <td>{{ $branch->manager }}</td>
                    <td>{{ $branch->user->customer->name ?? ''}}</td>
                    <td><a class="btn btn-primary btn-sm" href='{{ route('admin.branches.show', ['id' => $branch->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $branch->id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
