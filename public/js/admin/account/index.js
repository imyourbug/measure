var dataTable = null;
$(document).ready(function () {
    dataTable = $("#table").DataTable({
        ajax: {
            url: "/admin/accounts",
            dataSrc: "accounts",
        },
        columns: [{
            data: "id"
        },
        {
            data: "name"
        },
        {
            data: "email"
        },
        {
            data: function (d) {
                return `${d.role == 1 ? 'Quản lý' : (d.role == 0 ? 'Nhân viên' : 'Khách hàng')}`;
            },
        },
        {
            data: function (d) {
                let btnDelete = `<button data-id="${d.id}" class="btn btn-danger btn-sm btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>`;
                return `<a class="btn btn-primary btn-sm" href='admin/accounts/update/${d.id}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-success btn-sm" style="padding: 4px 15px"
                            href='admin/accounts/detail/${d.id}'>
                                <i class="fa-solid fa-info"></i>
                        </a>
                        ${($('#logging_user_id').val() == 1 && d.role != $('#logging_user_id').val()) ?
                        btnDelete : ''}`;
            },
        },
        ],
    });
})

$(document).on("click", ".btn-delete", function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/accounts/${id}/destroy`,

            success: function (response) {
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
