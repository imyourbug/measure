var dataTable = null;
$(document).ready(function () {
    dataTable = $("#table").DataTable({
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: "excel",
                        text: "Xuất Excel",
                        exportOptions: {
                            columns: ":not(:last-child)",
                        },
                    },
                    "colvis",
                ],
            },
        },
        ajax: {
            url: "/admin/customers",
            dataSrc: "customers",
        },
        columns: [
            {
                data: "id",
            },
            {
                data: "name",
            },
            {
                data: "address",
            },
            {
                data: "province",
            },
            {
                data: "tel",
            },
            {
                data: "website",
            },
            {
                data: "representative",
            },
            {
                data: "manager",
            },
            {
                data: "email",
            },
            {
                data: "field",
            },
            {
                data: function (d) {
                    return `<a class="btn btn-primary btn-sm" href="/admin/customers/detail/${d.id}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="${d.user_id}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>`;
                },
            },
        ],
    });
});

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
