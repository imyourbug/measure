@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush
@push('scripts')
    <script>
        var dataTable = null;
        $(document).ready(function() {
            dataTable = $("#table").DataTable({
                ajax: {
                    url: "/api/contracts/getAll",
                    dataSrc: "contracts",
                },
                columns: [{
                        data: "id"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: function(d) {
                            return `${d.branch.name}`;
                        },
                    },
                    {
                        data: "start"
                    },
                    {
                        data: "finish"
                    },
                    {
                        data: "content"
                    },
                    {
                        data: function(d) {
                            return `${d.customer.name}`;
                        },
                    },
                    {
                        data: function(d) {
                            return `${getStatusContract(d.finish)}`;
                        },
                    },
                    {
                        data: function(d) {
                            return `<a class="btn btn-primary btn-sm" href='/admin/contracts/detail/${d.id}'>
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button data-id="${d.id }" class="btn btn-danger btn-sm btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>`;
                        },
                    },
                ],
            });
        })

        $(document).on("click", ".btn-delete", function() {
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
                            dataTable.ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                });
            }
        });
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
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection
