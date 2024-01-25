//list
$(".btn-delete").on("click", function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/contracts/${id}/destroy`,
            data: {
                _token: 1,
            },
            success: function (response) {
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

function renderDate() {
    let html = '<option value="0">Cuối tháng</option>';
    for (let index = 1; index <= 31; index++) {
        html += `<option value="${index}">${index}</option> `;
    }

    return html;
}

function renderDay() {
    return `<option value="Monday">Thứ hai</option>
            <option value="Tuesday">Thứ ba</option>
            <option value="Wednesday">Thứ tư</option>
            <option value="Thursday">Thứ năm</option>
            <option value="Friday">Thứ sáu</option>
            <option value="Saturday">Thứ bảy</option>
            <option value="Sunday">Chủ nhật</option>`;
}

function renderOption(type, id_type) {
    let html = `<div class="option-select">
        ${type == "day" ? "Chọn thứ (hàng tuần)" : "Chọn ngày (hàng tháng)"}
        <select multiple="multiple" class="select2 custom-select form-control-border select">
            ${type == "day" ? renderDay() : renderDate()}
            </select>
            </div>`;
    $(".option-type-" + id_type).append(html);
    $(".select2").select2();
}

//btn open modal
// $(".btn-open-modal").on("click", function () {
//     let branch_id = $(this).data("id");
// $(".btn-save").attr("data-id", branch_id);
// });

//btn open modal
function openModal(branch_id) {
    $(".id-branch").val(branch_id);
}

//btn save
$(".btn-save").on("click", function () {
    let dataStorage = JSON.parse(localStorage.getItem("data")) ?? [];
    let branch_id = $(".id-branch").val();
    let data = {
        branch_id: branch_id,
        task_type: [
            ...($(".type_elec").is(":checked") ? [$(".type_elec").val()] : []),
            ...($(".type_water").is(":checked")
                ? [$(".type_water").val()]
                : []),
            ...($(".type_air").is(":checked") ? [$(".type_air").val()] : []),
        ],
        type_elec: $(".select-type-elec").val(),
        value_elec: $(".select-elec").val(),
        type_water: $(".select-type-water").val(),
        value_water: $(".select-water").val(),
        type_air: $(".select-type-air").val(),
        value_air: $(".select-air").val(),
    };

    //push data to storage
    if (data.task_type.length > 0) {
        if (dataStorage.length == 0) {
            dataStorage.push(data);
        } else {
            let count = 0;
            dataStorage = dataStorage.map((e) => {
                if (e.branch_id == branch_id) {
                    count++;
                    return { ...data };
                }
                return e;
            });
            if (count == 0) {
                dataStorage.push(data);
            }
        }
    } else {
        dataStorage = dataStorage.filter((e) => e.branch_id != branch_id);
    }
    localStorage.setItem("data", JSON.stringify(dataStorage));

    // render text info
    let html = "";
    data.task_type.forEach((task_type) => {
        switch (task_type) {
            case "0":
                html += `Đo điện: ${data.value_elec}<br/>`;
                break;
            case "1":
                html += `Đo nước: ${data.value_water}<br/>`;
                break;
            case "2":
                html += `Đo không khí: ${data.value_air}<br/>`;
                break;
        }
    });
    $(".info-branch-" + branch_id).html(html);
});

$(document).on("click", ".option-type", function () {
    let name = $(this).data("name");
    let id = $(this).data("type");
    if (this.checked) {
        if (!$("div.option-type").length) {
            $(".modal-body").append(`<div class="row option option-${id}">
                                        <div class="col-lg-12">
                                            <div class="form-group option-type-${id}" style="align-items: center">
                                                <label for="menu">${name} theo</label>
                                                <select class="custom-select form-control-borders select-type select-type-${id}" data-type="${id}">
                                                    <option value="day">Thứ</option>
                                                    <option value="date" selected>Ngày</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>`);
            renderOption($(".select-type-" + id).find(":selected").val(), id);
        }
    } else {
        $(".option-" + id).remove();
    }

});

// select type
$(document).on("change", ".select-type", function () {
    let type_time = $(this).find(":selected").val();
    let id = $(this).data('type');
    $(".option-type-" + id).find('.option-select').remove();
    renderOption(type_time, id);
});

//select parent type
$(".select-parent-type").on("change", function () {
    $('.option').remove();
    let parent_id = $(this).val();
    if (parent_id) {
        $.ajax({
            type: "GET",
            url: $(this).data("url") + "?id=" + parent_id,
            success: function (response) {
                $(".branch").remove();
                let html = "";
                response.data.forEach((e) => {
                    html += `<div class="custom-control custom-checkbox">
                    <input type="checkbox" data-name="${e.name}" data-type="${e.id}" id="type_${e.id}"
                        class="option-type custom-control-input">
                    <label class="custom-control-label" for="type_${e.id}">${e.name}</label>
                </div>`;
                });
                $(".form-type").html("");
                $(".form-type").append(html);
            },
        });
    } else {
        $(".form-type").html("");
    }
});

//select customer
$(".select-customer").on("change", function () {
    reset();
    let id_customer = $(this).val();
    if (id_customer) {
        $.ajax({
            type: "GET",
            url: $(this).data("url") + "?id=" + id_customer,
            success: function (response) {
                $(".branch").remove();
                let html = "";
                let dataStorage = [];
                response.data.forEach((e) => {
                    let data = {
                        branch_id: e.id,
                    };
                    dataStorage.push(data);
                    html += `<div class="row branch">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <label for="menu">${e.name}</label>&emsp13;
                                <button data-id="${e.id}" type="button" class="btn btn-success btn-open-modal"
                                    data-target="#modal-task" data-toggle="modal" onclick="openModal(${e.id})">
                                    <i class="fa-solid fa-plus"></i></button>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body info-branch info-branch-${e.id}">
                            </div>
                        </div>
                    </div>
                </div>`;
                });
                localStorage.setItem("data", JSON.stringify(dataStorage));
                $(".form-contract").append(html);
            },
        });
    } else {
        $(".branch").remove();
    }
});

//add
$(".btn-create").on("click", function () {
    if (confirm("Xác nhận tạo hợp đồng mới?")) {
        let data = JSON.parse(localStorage.getItem("data"));
        let params = {
            customer_id: $("#customer_id").val(),
            name: $("#name").val(),
            start: $("#start").val(),
            finish: $("#finish").val(),
            content: $("#content").val(),
            attachment: $("#value-attachment").val(),
            data: data,
        };
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: params,
            success: function (response) {
                response.status == 0
                    ? toastr.success(response.message)
                    : toastr.error(response.message);
                reset();
            },
        });
    }
});

//reset localStorage
function reset() {
    localStorage.removeItem("data");
    $(".info-branch").html("");
}
reset();
