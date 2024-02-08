@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">


@endpush
@push('scripts')
    <script src="/js/admin/account/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    <a href="{{ route('admin.accounts.create') }}" class="btn btn-success mb-3">Thêm mới</a>
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Quyền</th>
                <th>Cập nhật lần cuối</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($users as $key => $user)
                <tr class="row{{ $user->id }}">
                    <th>{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role == 1 ? 'Quản lý' : ($user->role == 0 ? 'Nhân viên' : 'Khách hàng') }}</td>
                    <td>{{ $user->updated_at === null ? '' : $user->updated_at->format('H:m:s d-m-Y') }}</td>
                    <td><a class="btn btn-primary btn-sm" href='{{ route('admin.accounts.show', ['id' => $user->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        @if ($user->id != Auth::id())
                            <button data-id="{{ $user->id }}" class="btn btn-danger btn-sm btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
