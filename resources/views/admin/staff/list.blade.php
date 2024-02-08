@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">


@endpush
@push('scripts')
    <script src="/js/admin/staff/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    <a href="{{ route('admin.accounts.create') }}" class="btn btn-success mb-3">Thêm mới</a>
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Họ tên</th>
                <th>Chức vụ</th>
                <th>CCCD</th>
                <th>Điện thoại</th>
                <th>Yes/No</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($staffs as $key => $staff)
                <tr class="row{{ $staff->user_id }}">
                    <th>{{ $staff->id }}</th>
                    <td> <img id="image_show" style="width: 50px;height:50px" src="{{ $staff->avatar }}" alt="Avatar" />
                    </td>
                    <td>{{ $staff->name }}</td>
                    <td>{{ $staff->position }}</td>
                    <td>{{ $staff->identification }}</td>
                    <td>{{ $staff->tel }}</td>
                    <td>{{ $staff->active }}</td>
                    <td><a class="btn btn-primary btn-sm" href='{{ route('admin.staffs.show', ['id' => $staff->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $staff->user_id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
