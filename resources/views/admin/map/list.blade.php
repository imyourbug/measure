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
    <script>
        $('.btn-upload').on('click', function() {
            $('#attachment').click();
        });
        $("#attachment").change(function() {
            const form = new FormData();
            form.append("file", $(this)[0].files[0]);
            console.log(form);
            $.ajax({
                processData: false,
                contentType: false,
                type: "POST",
                data: form,
                url: '{{ route('settings.uploadmap') }}',
                success: function(response) {
                    var html = '';
                    if (response.status == 0) {
                        html +=
                            `<a href="${response.url}" download class="download">Tải xuống</a>`;
                    }
                    $('.download').remove();
                    $('.form-upload').append(html);
                },
            });
        });
    </script>
@endpush
@section('content')
    <a href="{{ route('admin.maps.create') }}" class="btn btn-success mb-3">Thêm mới</a>
    <div class="form-upload">
        <button class="btn btn-warning btn-upload">Tải lên sơ đồ</button>
        <input type="file" style="display: none" id="attachment">
        @if ($setting?->value)
            <a href="{{ $setting->value }}" download class="download">Tải xuống</a>
        @endif
    </div>
    <br />
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
        </thead>
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
    </table>
@endsection
