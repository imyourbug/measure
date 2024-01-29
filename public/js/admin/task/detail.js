var dataTable = null;

function closeModal() {
    $("#modal").css("display", "none");
    $("body").removeClass("modal-open");
    $(".modal-backdrop").remove();
}


// $(document).on("click", ".btn-filter", function () {
//     $.ajax({
//         type: "GET",
//         url: "/api/taskdetails/" + $(this).data("id") + "/show",
//         success: function (response) {
//             if (response.status == 0) {
//                 let task = response.task;
//                 $("#type_id").val(task.type_id);
//                 $("#contract_id").val(task.contract_id);
//                 $("#note").text(task.note);
//                 $("#task_id").val(task.id);
//             } else {
//                 toastr.error(response.message);
//             }
//         },
//     });
// });

$(document).ready(function () {
    // solution
    dataTable = $("#table").DataTable({
        ajax: {
            url: "/api/taskdetails?id=" + $('#task_id').val(),
            dataSrc: "taskDetails",
        },
        columns: [
            { data: "id" },
            { data: "task.type.name" },
            { data: "plan_date" },
            { data: "actual_date" },
            { data: "time_in" },
            { data: "time_out" },
            { data: "created_at" },
            {
                data: function (d) {
                    return `<a class="btn btn-primary btn-sm btn-edit" data-id="${d.id}" data-target="#modal" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a class="btn btn-success btn-sm" style="padding: 4px 15px" href="/admin/tasks/update/${d.id}">
                                                    <i class="fa-solid fa-info"></i>
                                                </a>
                                                <button data-id="${d.id}"
                                                    class="btn btn-danger btn-sm btn-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>`;
                },
            },
        ],
    });
});

$(document).on("click", ".btn-edit", function () {
    $.ajax({
        type: "GET",
        url: "/api/taskdetails/" + $(this).data("id") + "/getById",
        success: function (response) {
            if (response.status == 0) {
                let task = response.task;
                $("#type_id").val(task.type_id);
                $("#contract_id").val(task.contract_id);
                $("#note").text(task.note);
                $("#task_id").val(task.id);
            } else {
                toastr.error(response.message);
            }
        },
    });
});

$(document).on("click", ".btn-update", function () {
    if (confirm("Bạn có muốn sửa")) {
        let data = {
            id: $("#task_id").val(),
            note: $("#note").val(),
            contract_id: $("#contract_id").val(),
            type_id: $("#type_id").val(),
        };
        console.log(data);
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: data,
            success: function (response) {
                if (response.status == 0) {
                    closeModal("solution");
                    toastr.success("Cập nhật thành công");
                    dataTable.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-delete", function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/tasks/${id}/destroy`,
            data: {
                _token: 1,
            },
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
