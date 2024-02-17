var dataTable = null;
$(document).ready(function () {
    dataTable = $("#table").DataTable({
        ajax: {
            url: "/admin/customers",
            dataSrc: "customers",
        },
        columns: [{
            data: "id"
        },
        {
            data: "name"
        },
        {
            data: "address"
        },
        {
            data: "tel"
        },
        {
            data: "email"
        },
        {
            data: function (d) {
                return `<a class="btn btn-primary btn-sm" href='/admin/customers/update/${d.id}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-success btn-sm" style="padding: 4px 15px" href="/admin/customers/detail/${d.id}">
                            <i class="fa-solid fa-info"></i>
                        </a>
                        <button data-id="${d.user_id}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>`;
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
            url: `/api/customers/${id}/destroy`,
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
