var dataTable = null;


var dataTableMap = null;
var dataTableStaff = null;
var dataTableItem = null;
var dataTableChemistry = null;
var dataTableSolution = null;
var listIdMap = [];
var listIdStaff = [];
var listIdItem = [];
var listIdChemistry = [];
var listIdSolution = [];
var listAllIdMap = [];
var listAllIdStaff = [];
var listAllIdItem = [];
var listAllIdChemistry = [];
var listAllIdSolution = [];

var searchParams = new Map([
    ["from", ""],
    ["to", ""],
]);

function getQueryUrlWithParams() {
    let query = `id=${$("#task_id").val()}`;
    Array.from(searchParams).forEach(([key, values], index) => {
        query += `&${key}=${typeof values == "array" ? values.join(",") : values}`;
    })

    return query;
}

$(document).on("click", ".btn-filter", async function () {
    Array.from(searchParams).forEach(([key, values], index) => {
        searchParams.set(key, String($('#' + key).val()).length ? $('#' + key).val() : '');
    });

    dataTable.ajax
        .url(`/api/taskdetails?${getQueryUrlWithParams()}`)
        .load();
});

$(document).on("click", ".btn-refresh", async function () {
    dataTable.ajax
        .url(`/api/taskdetails?id=${$("#task_id").val()}`)
        .load();
});

function closeModal(type) {
    $("#modal-" + type).css("display", "none");
    $("body").removeClass("modal-open");
    $(".modal-backdrop").remove();
}

$("#upload").change(function () {
    const form = new FormData();
    form.append("file", $(this)[0].files[0]);
    $.ajax({
        processData: false,
        contentType: false,
        type: "POST",
        data: form,
        url: "/api/upload",
        success: function (response) {
            if (response.status == 0) {
                //hiển thị ảnh
                $("#image_show").attr('src', response.url);
                $("#image").val(response.url);
            } else {
                toastr.error(response.message, 'Thông báo');
            }
        },
    });
});

$(document).ready(function () {
    // map
    dataTableMap = $("#tableMap").DataTable({
        ajax: {
            url: "/api/settingtaskmaps?id=" + $("#task_id").val(),
            dataSrc: "taskMaps",
        },
        columns: [{
            data: function (d) {
                if (!listAllIdMap.includes(d.id)) {
                    listAllIdMap.push(d.id);
                }
                return `<input class="select-id-map" data-id="${d.id}" type="checkbox" /> `;
            },
        },
        // {
        //     data: "id"
        // },
        {
            data: "code"
        },
        {
            data: "position"
        },
        {
            data: "target"
        },
        {
            data: "unit"
        },
        {
            data: "kpi"
        },
        {
            data: "fake_result"
        },
        {
            data: "area"
        },
        // {
        //     data: "description"
        // },
        {
            data: "round"
        },
        {
            data: function (d) {
                return `<img style="width: 50px;height:50px" src="${d.image}" alt="image" />`;
            },
        },
        // {
        //     data: function(d) {
        //         return getActive(d.active);
        //     },
        // },
        {
            data: function (d) {
                return `<a class="btn btn-primary btn-sm btn-edit" data-id="${d.id}" data-target="#modal-map" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button data-id="${d.id}"
                                                    class="btn btn-danger btn-sm btn-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>`;
            },
        },
        ],
    });
    // staff
    dataTableStaff = $("#tableStaff").DataTable({
        ajax: {
            url: "/api/settingtaskstaff?id=" + $("#task_id").val(),
            dataSrc: "taskStaff",
        },
        columns: [
            // {
            //     data: "id"
            // },
            {
                data: function (d) {
                    return `NV${d.user.staff.id >= 10
                        ? d.user.staff.id
                        : "0" + d.user.staff.id
                        }`;
                },
            },
            {
                data: "user.staff.name"
            },
            {
                data: "user.staff.position"
            },
            {
                data: "user.staff.identification"
            },
            {
                data: "user.staff.tel"
            },
            {
                data: function (d) {
                    return `<a class="btn btn-primary btn-sm btn-edit-staff" data-id="${d.id}" data-target="#modal-staff" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button data-id="${d.id}"
                                                    class="btn btn-danger btn-sm btn-delete-staff">
                                                    <i class="fas fa-trash"></i>
                                                </button>`;
                },
            },
        ],
    });
    // chemistry
    dataTableChemistry = $("#tableChemistry").DataTable({
        ajax: {
            url: "/api/settingtaskchemistries?id=" + $("#task_id").val(),
            dataSrc: "taskChemistries",
        },
        columns: [
            // {
            //     data: "id"
            // },
            {
                data: "chemistry.name"
            },
            {
                data: "unit"
            },
            {
                data: "kpi"
            },
            {
                data: function (d) {
                    return `<a class="btn btn-primary btn-sm btn-edit-chemistry" data-id="${d.id}" data-target="#modal-chemistry" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button data-id="${d.id}"
                                                    class="btn btn-danger btn-sm btn-delete-chemistry">
                                                    <i class="fas fa-trash"></i>
                                                </button>`;
                },
            },
        ],
    });
    // item
    dataTableItem = $("#tableItem").DataTable({
        ajax: {
            url: "/api/settingtaskitems?id=" + $("#task_id").val(),
            dataSrc: "taskItems",
        },
        columns: [
            // {
            //     data: "id"
            // },
            {
                data: "item.name"
            },
            {
                data: "unit"
            },
            {
                data: "kpi"
            },
            {
                data: function (d) {
                    return `<a class="btn btn-primary btn-sm btn-edit-item" data-id="${d.id}" data-target="#modal-item" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button data-id="${d.id}"
                                                    class="btn btn-danger btn-sm btn-delete-item">
                                                    <i class="fas fa-trash"></i>
                                                </button>`;
                },
            },
        ],
    });
    // solution
    dataTableSolution = $("#tableSolution").DataTable({
        ajax: {
            url: "/api/settingtasksolutions?id=" + $("#task_id").val(),
            dataSrc: "taskSolutions",
        },
        columns: [
            // {
            //     data: "id"
            // },
            {
                data: "solution.name"
            },
            {
                data: "unit"
            },
            {
                data: "kpi"
            },
            {
                data: function (d) {
                    return `<a class="btn btn-primary btn-sm btn-edit-solution" data-id="${d.id}" data-target="#modal-solution" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button data-id="${d.id}"
                                                    class="btn btn-danger btn-sm btn-delete-solution">
                                                    <i class="fas fa-trash"></i>
                                                </button>`;
                },
            },
        ],
    });
});

// solution
$(document).on("click", ".btn-edit-solution", function () {
    $.ajax({
        type: "GET",
        url: "/api/settingtasksolutions/" + $(this).data("id") + "/show",
        success: function (response) {
            if (response.status == 0) {
                let taskSolution = response.taskSolution;
                $(".modal-title-solution").text("Cập nhật phương pháp");
                $("#solution_id").val(taskSolution.solution_id);
                $("#solution_unit").val(taskSolution.unit);
                $("#solution_kpi").val(taskSolution.kpi);
                //
                $(".btn-add-solution").css("display", "none");
                $(".btn-update-solution").css("display", "block");
                $("#settingtasksolution_id").val(taskSolution.id);
            } else {
                toastr.error(response.message);
            }
        },
    });
});

$(".btn-open-modal-solution").on("click", function () {
    $(".modal-title-solution").text("Thêm phương pháp");
    $(".btn-add-solution").css("display", "block");
    $(".btn-update-solution").css("display", "none");
});

$(document).on("click", ".btn-update-solution", function () {
    if (confirm("Bạn có muốn sửa")) {
        let data = {
            id: $("#settingtasksolution_id").val(),
            unit: $("#solution_unit").val(),
            kpi: $("#solution_kpi").val(),
            solution_id: $("#solution_id").val(),
        };
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: data,
            success: function (response) {
                if (response.status == 0) {
                    closeModal("solution");
                    toastr.success("Cập nhật thành công");
                    dataTableSolution.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-delete-solution", function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/settingtasksolutions/${id}/destroy`,
            success: function (response) {
                if (response.status == 0) {
                    toastr.success("Xóa thành công");
                    dataTableSolution.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-add-solution", function () {
    let data = {
        unit: $("#solution_unit").val(),
        kpi: $("#solution_kpi").val(),
        solution_id: $("#solution_id").val(),
        task_id: $("#task_id").val(),
    };
    $.ajax({
        type: "POST",
        data: data,
        url: $(this).data("url"),
        success: function (response) {
            if (response.status == 0) {
                closeModal("solution");
                dataTableSolution.ajax.reload();
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        },
    });
});

// item
$(document).on("click", ".btn-edit-item", function () {
    $.ajax({
        type: "GET",
        url: "/api/settingtaskitems/" + $(this).data("id") + "/show",
        success: function (response) {
            if (response.status == 0) {
                let taskItem = response.taskItem;
                $(".modal-title-item").text("Cập nhật vật tư");
                $("#item_id").val(taskItem.item_id);
                $("#item_unit").val(taskItem.unit);
                $("#item_kpi").val(taskItem.kpi);
                //
                $(".btn-add-item").css("display", "none");
                $(".btn-update-item").css("display", "block");
                $("#settingtaskitem_id").val(taskItem.id);
            } else {
                toastr.error(response.message);
            }
        },
    });
});

$(".btn-open-modal-item").on("click", function () {
    $(".modal-title-item").text("Thêm vật tư");
    $(".btn-add-item").css("display", "block");
    $(".btn-update-item").css("display", "none");
});

$(document).on("click", ".btn-update-item", function () {
    if (confirm("Bạn có muốn sửa")) {
        let data = {
            id: $("#settingtaskitem_id").val(),
            unit: $("#item_unit").val(),
            kpi: $("#item_kpi").val(),
            item_id: $("#item_id").val(),
        };
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: data,
            success: function (response) {
                if (response.status == 0) {
                    closeModal("item");
                    toastr.success("Cập nhật thành công");
                    dataTableItem.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-delete-item", function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/settingtaskitems/${id}/destroy`,
            success: function (response) {
                if (response.status == 0) {
                    toastr.success("Xóa thành công");
                    dataTableItem.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-add-item", function () {
    let data = {
        unit: $("#item_unit").val(),
        kpi: $("#item_kpi").val(),
        item_id: $("#item_id").val(),
        task_id: $("#task_id").val(),
    };
    $.ajax({
        type: "POST",
        data: data,
        url: $(this).data("url"),
        success: function (response) {
            if (response.status == 0) {
                closeModal("item");
                dataTableItem.ajax.reload();
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        },
    });
});

// map
$(document).on("click", ".select-id-map-all", function () {
    if ($(this).prop('checked')) {
        $('.select-id-map').prop('checked', true);
        listIdMap = listAllIdMap;
    } else {
        $('.select-id-map').prop('checked', false);
        listIdMap = [];
    }
    $('.btn-delete-map-all').css('display', listIdMap.length > 0 ? 'block' : 'none');
});
$(document).on("click", ".select-id-map", function () {
    let id = $(this).data('id');
    if (!listIdMap.includes(id)) {
        listIdMap.push(id);
    } else {
        listIdMap = listIdMap.filter(function (item) {
            return item !== id;
        })
    };
    $('.btn-delete-map-all').css('display', listIdMap.length > 0 ? 'block' : 'none');
});
$(document).on("click", ".btn-edit", function () {
    $.ajax({
        type: "GET",
        url: "/api/settingtaskmaps/" + $(this).data("id") + "/show",
        success: function (response) {
            if (response.status == 0) {
                let taskMap = response.taskMap;
                $(".modal-title-map").text("Cập nhật sơ đồ");
                $("#map_id").val(taskMap.map_id);
                $("#kpi").val(taskMap.kpi);
                $("#unit").val(taskMap.unit);
                $("#code").val(taskMap.code);
                $("#position").val(taskMap.position);
                $("#target").val(taskMap.target);
                $("#kpi").val(taskMap.kpi);
                $("#fake_result").val(taskMap.fake_result);
                $("#area").val(taskMap.area);
                // $("#description").val(taskMap.description);
                $("#range").val(taskMap.round);
                $("#image_show").attr("src", taskMap.image);
                $("#image").val(taskMap.image);
                //
                $(".btn-add-map").css("display", "none");
                $(".btn-update-map").css("display", "block");
                $("#settingtaskmap_id").val(taskMap.id);
            } else {
                toastr.error(response.message);
            }
        },
    });
});

$(".btn-open-modal").on("click", function () {
    $(".modal-title-map").text("Thêm sơ đồ");
    $("#kpi").val("");
    $("#unit").val("");
    $(".btn-add-map").css("display", "block");
    $(".btn-update-map").css("display", "none");
});

$(document).on("click", ".btn-update-map", function () {
    if (confirm("Bạn có muốn sửa")) {
        let data = {
            id: $("#settingtaskmap_id").val(),
            kpi: $("#kpi").val(),
            unit: $("#unit").val(),
            target: $("#target").val(),
            code: $("#code").val(),
            position: $("#position").val(),
            fake_result: $("#fake_result").val(),
            area: $("#area").val(),
            image: $("#image").val(),
            // description: $("#description").val(),
            round: $("#range").val(),
            task_id: $("#task_id").val(),
        };
        console.log(data);
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: data,
            success: function (response) {
                if (response.status == 0) {
                    closeModal("map");
                    toastr.success("Cập nhật thành công");
                    dataTableMap.ajax.reload();
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
            url: `/api/settingtaskmaps/${id}/destroy`,

            success: function (response) {
                if (response.status == 0) {
                    toastr.success("Xóa thành công");
                    dataTableMap.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-delete-map-all", function () {
    if (confirm("Bạn có muốn xóa")) {
        $.ajax({
            type: "POST",
            url: `/api/settingtaskmaps/deleteAll`,
            data: {
                ids: listIdMap
            },
            success: function (response) {
                if (response.status == 0) {
                    toastr.success("Xóa thành công");
                    dataTableMap.ajax.reload();
                    listIdMap.length = 0;
                    $('.btn-delete-map-all').css('display', 'none');
                    $('.select-id-map-all').prop('checked', false);
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-add-map", function () {
    let data = {
        code: $("#code").val(),
        position: $("#position").val(),
        number: $("#number").val(),
        area: $("#area").val(),
        target: $("#target").val(),
        image: $("#image").val(),
        // description: $("#description").val(),
        range: $("#range").val(),
        active: $("#active").val(),
        unit: $("#unit").val(),
        kpi: $("#kpi").val(),
        target: $("#target").val(),
        task_id: $("#task_id").val(),
        fake_result: $("#fake_result").val(),
        map_id: $("#map_id").val(),
    };
    $.ajax({
        type: "POST",
        data: data,
        url: $(this).data("url"),
        success: function (response) {
            if (response.status == 0) {
                closeModal("map");
                dataTableMap.ajax.reload();
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        },
    });
});

// staff
$(document).on("click", ".btn-edit-staff", function () {
    $.ajax({
        type: "GET",
        url: "/api/settingtaskstaff/" + $(this).data("id") + "/show",
        success: function (response) {
            if (response.status == 0) {
                let taskStaff = response.taskStaff;
                $(".modal-title-staff").text("Cập nhật nhân sự");
                $("#staff_id").val(taskStaff.user_id);
                //
                $(".btn-add-staff").css("display", "none");
                $(".btn-update-staff").css("display", "block");
                $("#settingtaskstaff_id").val(taskStaff.id);
            } else {
                toastr.error(response.message);
            }
        },
    });
});

$(".btn-open-modal-staff").on("click", function () {
    $(".modal-title-staff").text("Thêm nhân sự");
    $(".btn-add-staff").css("display", "block");
    $(".btn-update-staff").css("display", "none");
});

$(document).on("click", ".btn-update-staff", function () {
    if (confirm("Bạn có muốn sửa")) {
        let data = {
            id: $("#settingtaskstaff_id").val(),
            task_id: $("#task_id").val(),
            user_id: $("#staff_id").val(),
        };
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: data,
            success: function (response) {
                if (response.status == 0) {
                    closeModal("staff");
                    toastr.success("Cập nhật thành công");
                    dataTableStaff.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-delete-staff", function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/settingtaskstaff/${id}/destroy`,

            success: function (response) {
                if (response.status == 0) {
                    toastr.success("Xóa thành công");
                    dataTableStaff.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-add-staff", function () {
    let data = {
        task_id: $("#task_id").val(),
        user_id: $("#staff_id").val(),
    };
    $.ajax({
        type: "POST",
        data: data,
        url: $(this).data("url"),
        success: function (response) {
            if (response.status == 0) {
                closeModal("staff");
                dataTableStaff.ajax.reload();
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        },
    });
});

// chemistry
$(document).on("click", ".btn-edit-chemistry", function () {
    $.ajax({
        type: "GET",
        url: "/api/settingtaskchemistries/" + $(this).data("id") + "/show",
        success: function (response) {
            if (response.status == 0) {
                let taskChemistry = response.taskChemistry;
                $(".modal-title-chemistry").text("Cập nhật hóa chất");
                $("#chemistry_id").val(taskChemistry.chemistry_id);
                $("#chemistry_unit").val(taskChemistry.unit);
                $("#chemistry_kpi").val(taskChemistry.kpi);
                //
                $(".btn-add-chemistry").css("display", "none");
                $(".btn-update-chemistry").css("display", "block");
                $("#settingtaskchemistry_id").val(taskChemistry.id);
            } else {
                toastr.error(response.message);
            }
        },
    });
});

$(".btn-open-modal-chemistry").on("click", function () {
    $(".modal-title-chemistry").text("Thêm hóa chất");
    $(".btn-add-chemistry").css("display", "block");
    $(".btn-update-chemistry").css("display", "none");
});

$(document).on("click", ".btn-update-chemistry", function () {
    if (confirm("Bạn có muốn sửa")) {
        let data = {
            id: $("#settingtaskchemistry_id").val(),
            unit: $("#chemistry_unit").val(),
            kpi: $("#chemistry_kpi").val(),
            chemistry_id: $("#chemistry_id").val(),
        };
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: data,
            success: function (response) {
                if (response.status == 0) {
                    closeModal("chemistry");
                    toastr.success("Cập nhật thành công");
                    dataTableChemistry.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-delete-chemistry", function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/settingtaskchemistries/${id}/destroy`,
            success: function (response) {
                if (response.status == 0) {
                    toastr.success("Xóa thành công");
                    dataTableChemistry.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-add-chemistry", function () {
    let data = {
        unit: $("#chemistry_unit").val(),
        kpi: $("#chemistry_kpi").val(),
        chemistry_id: $("#chemistry_id").val(),
        task_id: $("#task_id").val(),
    };
    $.ajax({
        type: "POST",
        data: data,
        url: $(this).data("url"),
        success: function (response) {
            if (response.status == 0) {
                closeModal("chemistry");
                dataTableChemistry.ajax.reload();
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        },
    });
});


function closeModalDetail() {
    $("#modal").css("display", "none");
    $("body").removeClass("modal-open");
    $(".modal-backdrop").remove();
}

$(document).on("click", ".btn-add", function () {
    let data = {
        plan_date: $("#plan_date").val(),
        actual_date: $("#actual_date").val(),
        time_in: $("#time_in").val(),
        time_out: $("#time_out").val(),
        task_id: $("#task_id").val(),
    };

    $.ajax({
        type: "POST",
        data: data,
        url: $(this).data("url"),
        success: function (response) {
            if (response.status == 0) {
                closeModalDetail();
                dataTable.ajax.reload();
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        },
    });
});

$(".btn-open-modal").on("click", function () {
    $(".modal-title-taskdetail").text("Thêm chi tiết nhiệm vụ");
    $(".btn-add-detail").css("display", "block");
    $(".btn-update-detail").css("display", "none");
});

$(document).ready(function () {
    dataTable = $("#table").DataTable({
        ajax: {
            url: `/api/taskdetails?id=${$("#task_id").val()}`,
            dataSrc: "taskDetails",
        },
        columns: [
            // { data: "id" },
            { data: "task.type.name" },
            // { data: function (d) {
            //     return `${formatDate(d.plan_date)}`
            // } },
            { data: "plan_date" },
            { data: "actual_date" },
            { data: "time_in" },
            { data: "time_out" },
            { data: "created_at" },
            {
                data: function (d) {
                    return `<a class="btn btn-primary btn-sm btn-edit-detail" data-id="${d.id}" data-target="#modal" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a class="btn btn-success btn-sm" style="padding: 4px 15px" href="/admin/taskdetails/update/${d.id}">
                                                    <i class="fa-solid fa-info"></i>
                                                </a>
                                                <button data-id="${d.id}"
                                                    class="btn btn-danger btn-sm btn-delete-detail">
                                                    <i class="fas fa-trash"></i>
                                                </button>`;
                },
            },
        ],
    });
});

$(document).on("click", ".btn-edit-detail", function () {
    $.ajax({
        type: "GET",
        url: "/api/taskdetails/" + $(this).data("id") + "/getById",
        success: function (response) {
            if (response.status == 0) {
                let taskDetail = response.taskDetail;
                $("#plan_date").val(taskDetail.plan_date);
                $("#actual_date").val(taskDetail.actual_date);
                // $("#plan_date").val(formatDate(taskDetail.plan_date));
                // $("#actual_date").val(formatDate(taskDetail.actual_date));
                $("#time_in").val(taskDetail.time_in);
                $("#time_out").val(taskDetail.time_out);
                $("#taskdetail_id").val(taskDetail.id);
                //
                $(".modal-title-taskdetail").text("Cập nhật chi tiết nhiệm vụ");
                $(".btn-add-detail").css("display", "none");
                $(".btn-update-detail").css("display", "block");
            } else {
                toastr.error(response.message);
            }
        },
    });
});

function formatDate(date) {
    const dateObj = new Date(date);
    const formattedDate = dateObj.toLocaleDateString();

    console.log(formattedDate);

    return formattedDate;
}

$(document).on("click", ".btn-update-detail", function () {
    if (confirm("Bạn có muốn sửa")) {
        let data = {
            id: $("#taskdetail_id").val(),
            time_in: $("#time_in").val(),
            plan_date: $("#plan_date").val(),
            actual_date: $("#actual_date").val(),
            time_out: $("#time_out").val(),
        };
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: data,
            success: function (response) {
                if (response.status == 0) {
                    closeModalDetail();
                    toastr.success("Cập nhật thành công");
                    dataTable.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-add-detail", function () {
    if (confirm("Bạn có muốn thêm")) {
        let data = {
            time_in: $("#time_in").val(),
            plan_date: $("#plan_date").val(),
            actual_date: $("#actual_date").val(),
            time_out: $("#time_out").val(),
            task_id: $("#task_id").val(),
        };
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: data,
            success: function (response) {
                if (response.status == 0) {
                    closeModalDetail();
                    toastr.success("Thêm thành công");
                    dataTable.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-delete-detail", function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/taskdetails/${id}/destroy`,

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


$(document).on("click", ".btn-save", function () {
    if (confirm("Bạn có muốn lưu")) {
        let id = $('#task_id').val();
        let suggestion = $('#suggestion').val();
        let notice = $('#notice').val();
        $.ajax({
            type: "POST",
            url: `/api/tasks/updateApart`,
            data: {
                id,
                suggestion,
                notice
            },
            success: function (response) {
                if (response.status == 0) {
                    toastr.success(response.message);
                    // dataTable.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});
