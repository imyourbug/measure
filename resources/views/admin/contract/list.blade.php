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
    <script>
        $(document).ready(function() {
            var dataTable = $('#table').DataTable({
                responsive: true
            });
            $(".btn-delete").on("click", function() {
                if (confirm("Bạn có muốn xóa")) {
                    let id = $(this).data("id");
                    $.ajax({
                        type: "DELETE",
                        url: `/api/contracts/${id}/destroy`,
                        data: {
                            _token: 1,
                        },
                        success: function(response) {
                            if (response.status == 0) {
                                toastr.success("Xóa thành công");
                                $(".row" + id).remove();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                    });
                }
            });
        })
    </script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    <div class="form-group mb-3">
        <a href="{{ route('admin.contracts.create') }}" class="btn btn-success">Thêm mới</a>
    </div>
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên hợp đồng</th>
                <th>Chi nhánh</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Nội dung</th>
                <th>Khách hàng</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($contracts as $key => $contract)
                <tr class="row{{ $contract->id }}">
                    <th>{{ $contract->id }}</th>
                    <th>{{ $contract->name }}</th>
                    <th>{{ $contract->branch->name }}</th>
                    <td>{{ date('d-m-Y', strtotime($contract->start)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($contract->finish)) }}</td>
                    <td>{{ $contract->content }}</td>
                    <td>{{ $contract->customer->name }}</td>
                    <td>{!! \App\Helper\Helper::getStatusContract($contract->finish) !!}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href='{{ route('admin.contracts.show', ['id' => $contract->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-success btn-sm" style="padding: 4px 15px"
                            href='{{ route('admin.contracts.detail', ['id' => $contract->id]) }}'>
                            <i class="fa-solid fa-info"></i>
                        </a>
                        <button data-id="{{ $contract->id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
