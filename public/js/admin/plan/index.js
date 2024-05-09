var dataTable = null;
$(document).ready(function () {
    dataTable = $("#table").DataTable({
        ajax: {
            url: "/api/contracts/getAll",
            dataSrc: "contracts",
        },
        columns: [{
            data: function (d) {
                return `${$('#select-month').val() == 0 ? 'Tất cả' : $('#select-month').val()}`;
            },
        }, {
            data: function (d) {
                return `${d.customer.name}`;
            },
        },
        {
            data: function (d) {
                return `${d.branch ? d.branch.name : ""}`;
            },
        },
        {
            data: function (d) {
                return `${d.branch ? (d.branch.address || "") : ""}`;
            },
        },

        {
            data: function (d) {
                // return `<a class="btn btn-primary btn-sm" href='/admin/contracts/update/${d.id}'>
                //             <i class="fas fa-edit"></i>
                //         </a>
                //         <a class="btn btn-success btn-sm" style="padding: 4px 15px"
                //             href='/admin/contracts/detail/${d.id}'>
                //             <i class="fa-solid fa-info"></i>
                //         </a>
                //         <button data-id="${d.id }" class="btn btn-danger btn-sm btn-delete">
                //             <i class="fas fa-trash"></i>
                //         </button>`;
                return `<a class="btn btn-success btn-sm" style="padding: 4px 15px"
                                        href='/admin/contracts/detail/${d.id}'>
                                        <i class="fa-solid fa-info"></i>
                                    </a>`;
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
            url: `/api/contracts/${id}/destroy`,
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
$(document).on("change", "#select-month", function () {
    let requestUrl = "/api/contracts/getAll?month=" + $(this).val();
    dataTable.ajax.url(requestUrl).load();
});