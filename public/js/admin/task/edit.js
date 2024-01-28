var dataTableMap = null;
var dataTableStaff = null;
var dataTableItem = null;
var dataTableChemistry = null;
var dataTableSolution = null;

function closeModal(type) {
    $('#modal-' + type).css('display', 'none');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}

$(document).ready(function () {
    dataTableMap = $('#tableMap').DataTable({
        ajax: {
            url: "/api/taskmaps?id=" + $('#task_id').val(),
            dataSrc: "taskMaps"
        },
        columns: [
            { data: 'id' },
            { data: 'map.code' },
            { data: 'map.area' },
            { data: 'map.target' },
            { data: 'unit' },
            { data: 'kpi' },
            {
                data: function (d) {
                    return `<a class="btn btn-primary btn-sm btn-edit" data-id="${d.id}" data-target="#modal-map" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button data-id="${d.id}"
                                                    class="btn btn-danger btn-sm btn-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>`;
                }
            },
        ]
    });
    //
    dataTableStaff = $('#tableStaff').DataTable({
        ajax: {
            url: "/api/taskstaff?id=" + $('#task_id').val(),
            dataSrc: "taskStaff"
        },
        columns: [
            { data: 'id' },
            {
                data: function (d) {
                    return `NV${d.user.staff.id >= 10 ? d.user.staff.id : '0' + d.user.staff.id}`;
                }
            },
            { data: 'user.staff.name' },
            { data: 'user.staff.position' },
            { data: 'user.staff.identification' },
            { data: 'user.staff.tel' },
            {
                data: function (d) {
                    return `<a class="btn btn-primary btn-sm btn-edit-staff" data-id="${d.id}" data-target="#modal-staff" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button data-id="${d.id}"
                                                    class="btn btn-danger btn-sm btn-delete-staff">
                                                    <i class="fas fa-trash"></i>
                                                </button>`;
                }
            },
        ]
    });
});

$(document).on('click', '.btn-edit', function () {
    $.ajax({
        type: "GET",
        url: "/api/taskmaps/" + $(this).data("id") + "/show",
        success: function (response) {
            if (response.status == 0) {
                let taskMap = response.taskMap;
                $('.modal-title-map').text('Cập nhật sơ đồ');
                $('#map_id').val(taskMap.map_id);
                $('#kpi').val(taskMap.kpi);
                $('#unit').val(taskMap.unit);
                //
                $('.btn-add-map').css('display', 'none');
                $('.btn-update-map').css('display', 'block');
                $('#taskmap_id').val(taskMap.id);
            } else {
                toastr.error(response.message);
            }
        }
    })
});

$('.btn-open-modal').on('click', function () {
    $('.modal-title-map').text('Thêm sơ đồ');
    $('#kpi').val('');
    $('#unit').val('');
    $('.btn-add-map').css('display', 'block');
    $('.btn-update-map').css('display', 'none');
});

$(document).on('click', '.btn-update-map', function () {
    if (confirm("Bạn có muốn sửa")) {
        let data = {
            id: $('#taskmap_id').val(),
            unit: $('#unit').val(),
            kpi: $('#kpi').val(),
            target: $('#target').val(),
            task_id: $('#task_id').val(),
            map_id: $('#map_id').val(),
        };
        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: data,
            success: function (response) {
                if (response.status == 0) {
                    closeModal('map');
                    toastr.success("Cập nhật thành công");
                    dataTableMap.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on('click', '.btn-delete', function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/taskmaps/${id}/destroy`,
            data: {
                _token: 1,
            },
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

$(document).on('click', '.btn-add-map', function () {
    let data = {
        unit: $('#unit').val(),
        kpi: $('#kpi').val(),
        target: $('#target').val(),
        task_id: $('#task_id').val(),
        map_id: $('#map_id').val(),
    };
    $.ajax({
        type: "POST",
        data: data,
        url: $(this).data('url'),
        success: function (response) {
            if (response.status == 0) {
                closeModal('map');
                dataTableMap.ajax.reload();
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        }
    })
});

// staff
$(document).on('click', '.btn-edit-staff', function () {
    $.ajax({
        type: "GET",
        url: "/api/taskstaff/" + $(this).data("id") + "/show",
        success: function (response) {
            if (response.status == 0) {
                let taskStaff = response.taskStaff;
                $('.modal-title-staff').text('Cập nhật nhân sự');
                $('#staff_id').val(taskStaff.user_id);
                //
                $('.btn-add-staff').css('display', 'none');
                $('.btn-update-staff').css('display', 'block');
                $('#taskstaff_id').val(taskStaff.id);
            } else {
                toastr.error(response.message);
            }
        }
    })
});

$('.btn-open-modal-staff').on('click', function () {
    $('.modal-title-staff').text('Thêm nhân sự');
    $('.btn-add-staff').css('display', 'block');
    $('.btn-update-staff').css('display', 'none');
});

$(document).on('click', '.btn-update-staff', function () {
    if (confirm("Bạn có muốn sửa")) {
        let data = {
            id: $('#taskstaff_id').val(),
            task_id: $('#task_id').val(),
            user_id: $('#staff_id').val(),
        };
        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: data,
            success: function (response) {
                if (response.status == 0) {
                    closeModal('staff');
                    toastr.success("Cập nhật thành công");
                    dataTableStaff.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on('click', '.btn-delete-staff', function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/taskstaff/${id}/destroy`,
            data: {
                _token: 1,
            },
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

$(document).on('click', '.btn-add-staff', function () {
    let data = {
        task_id: $('#task_id').val(),
        user_id: $('#staff_id').val(),
    };
    $.ajax({
        type: "POST",
        data: data,
        url: $(this).data('url'),
        success: function (response) {
            if (response.status == 0) {
                closeModal('staff');
                dataTableStaff.ajax.reload();
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        }
    })
});
