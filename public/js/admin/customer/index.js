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
            // {
            //     data: "id",
            // },
            {
                data: "name",
            },
            {
                data: "representative",
            },
            {
                data: "tax_code",
            },
            {
                data: "address",
            },
            {
                data: "website",
            },
            {
                data: "email",
            },
            {
                data: function (d) {
                    return getActive(d.status);
                },
            },
            {
                data: function (d) {
                    return `<img style="width: 50px;height:50px" src="${d.avatar}" alt="avatar" />`;
                },
            },
            {
                data: "manager",
            },
            {
                data: "tel",
            },
            {
                data: "position",
            },
            {
                data: function (d) {
                    return `<a class="btn btn-primary btn-sm" href="/admin/customers/detail/${d.id}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="${d.id}" data-target="#modalDelete" 
                            data-toggle="modal" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>`;
                },
            },
        ],
    });
});

$(document).on('click', '.btn-delete', function () {
    let id = $(this).data('id');
    $('.btn-confirm-delete').data('id', id);
});

$(document).on("click", ".btn-confirm-delete", function () {
    let id = $(this).data("id");
    if (id) {
        $.ajax({
            type: "DELETE",
            url: `/api/customers/${id}/destroy`,
            success: function (response) {
                if (response.status == 0) {
                    toastr.success("Xóa thành công");
                    dataTable.ajax.reload();
                    $('.btn-close-modal-confirm-delete').click();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});
