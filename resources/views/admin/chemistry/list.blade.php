@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">


@endpush
@push('scripts')
    <script src="/js/admin/chemistry/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    <a href="{{ route('admin.chemistries.create') }}" class="btn btn-success mb-3">Thêm mới</a>
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã hóa chất</th>
                <th>Tên thương mại</th>
                <th>Số ĐK</th>
                <th>Ảnh</th>
                <th>Mô tả</th>
                <th>Nhà cung cấp</th>
                <th>Hiệu lực</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($chemistries as $key => $chemistry)
                <tr class="row{{ $chemistry->id }}">
                    <th>{{ $chemistry->id }}</th>
                    <td>{{ $chemistry->code }}</td>
                    <td>{{ $chemistry->name }}</td>
                    <td>{{ $chemistry->number_regist }}</td>
                    <td><img width="50px" height="50px" src="{{ $chemistry->image }}" alt="image"></td>
                    <td>{{ $chemistry->description }}</td>
                    <td>{{ $chemistry->supplier }}</td>
                    <td>{{ $chemistry->active }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href='{{ route('admin.chemistries.show', ['id' => $chemistry->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $chemistry->id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
