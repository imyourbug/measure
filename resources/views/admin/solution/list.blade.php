@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">


@endpush
@push('scripts')
    <script src="/js/admin/solution/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    <a href="{{ route('admin.solutions.create') }}" class="btn btn-success mb-3">Thêm mới</a>
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Phương pháp</th>
                <th>Đối tượng áp dụng</th>
                <th>Ảnh</th>
                <th>Mô tả</th>
                <th>Hiệu lực</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($solutions as $key => $solution)
                <tr class="row{{ $solution->id }}">
                    <th>{{ $solution->id }}</th>
                    <td>{{ $solution->code }}</td>
                    <td>{{ $solution->position }}</td>
                    <td><img width="50px" height="50px" src="{{ $solution->image }}" alt="image"></td>
                    <td>{{ $solution->description }}</td>
                    <td>{{ $solution->active }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href='{{ route('admin.solutions.show', ['id' => $solution->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $solution->id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
