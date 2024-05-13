var dataTable = null;

var searchParams = new Map([
    ["from", ""],
    ["to", ""],
    ["contracts", ""],
]);

function getQueryUrlWithParams() {
    let query = ``;
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
        .url(`/api/tasks/getAll?${getQueryUrlWithParams()}`)
        .load();
});

$(document).on("click", ".btn-refresh", async function () {
    dataTable.ajax
        .url(`/api/tasks/getAll`)
        .load();
});

$(document).ready(function () {
    // select 2
    $(".select2").select2();
    // solution
    dataTable = $("#table").DataTable({
        ajax: {
            url: `/api/tasks/getAll`,
            dataSrc: "tasks",
        },
        columns: [
            { data: "type.name" },
            {
                data: function (d) {
                    return `${d.contract.name} - ${d.contract.branch ? d.contract.branch.name : ""}`;
                },
            },
            { data: "note" },
            { data: "frequence" },
            { data: "confirm" },
            { data: "status" },
            { data: "reason" },
            { data: "solution" },
            { data: "created_at" },
            {
                data: function (d) {
                    return `<a class="btn btn-primary btn-sm btn-edit" data-id="${d.id}" data-target="#modal" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a class="btn btn-success btn-sm" style="padding: 4px 15px" href="/admin/reports/task/${d.id}">
                                                    <i class="fa-solid fa-info"></i>
                                                </a>`;
                    // return `<a class="btn btn-primary btn-sm btn-edit" data-id="${d.id}" data-target="#modal" data-toggle="modal">
                    //                             <i class="fas fa-edit"></i>
                    //                         </a>
                    //                         <a class="btn btn-success btn-sm" style="padding: 4px 15px" href="/admin/reports/task/${d.id}">
                    //                             <i class="fa-solid fa-info"></i>
                    //                         </a>
                    //                         <button data-id="${d.id}"
                    //                             class="btn btn-danger btn-sm btn-delete">
                    //                             <i class="fas fa-trash"></i>
                    //                         </button>`;
                },
            },
        ],
    });
});

$(document).on("click", ".btn-edit", function () {
    $.ajax({
        type: "GET",
        url: "/api/tasks/" + $(this).data("id") + "/getById",
        success: function (response) {
            if (response.status == 0) {
                let task = response.task;
                $("#type_id").val(task.type_id);
                $("#contract_id").val(task.contract_id);
                $("#note").val(task.note);
                $("#frequence").val(task.frequence);
                $("#confirm").val(task.confirm);
                $("#reason").val(task.reason);
                $("#status").val(task.status);
                $("#solution").val(task.solution);
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
            frequence: $("#frequence").val(),
            confirm: $("#confirm").val(),
            status: $("#status").val(),
            solution: $("#solution").val(),
            reason: $("#reason").val(),
        };
        console.log(data);
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: data,
            success: function (response) {
                if (response.status == 0) {
                    closeModal("modal");
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

function closeModal() {
    $("#modal").css("display", "none");
    $("body").removeClass("modal-open");
    $(".modal-backdrop").remove();
}

// report
var listMapChart = [];
var listTrendMapChart = [];
var listAnnualMapChart = [];
$('#form-export').submit(function (e) {
    e.preventDefault();
    // let pattern = /^\d{4}$/;
    // let year = $('.select-year').val();
    // let month = $('.select-month').val();
    // let column = $('.select-column').val();
    // let contract_id = $('.select-contract').val();
    // let url = $(this).attr('action');

    $.ajax({
        type: "POST",
        data: $(this).serialize(),
        url: $(this).attr('action'),
        success: function (response) {
            if (response.status == 0) {
                window.open(response.url);
            } else {
                toastr.error(response.message);
            }
        }
    })
});

$('.btn-preview').on('click', async function () {
    // reset
    $('.btn-export').prop('disabled', true);
    $('.groupAnnualImage').html('');
    $('.groupTrendImage').html('');
    $('.groupImage').html('');
    listMapChart.forEach((e) => {
        if (e.chart !== null) {
            e.chart.destroy();
        }
    });
    listTrendMapChart.forEach((e) => {
        if (e.chart !== null) {
            e.chart.destroy();
        }
    });
    listAnnualMapChart.forEach((e) => {
        if (e.chart !== null) {
            e.chart.destroy();
        }
    });
    listMapChart = [];
    listTrendMapChart = [];
    listAnnualMapChart = [];
    // declare
    let type_report = $('.select-type').val();
    let year = $('.select-year').val();
    let month = $('.select-month').val();
    let year_compare = $('.select-year-compare').val();
    let month_compare = $('.select-month-compare').val();
    let contract_id = $('.select-contract').val();
    let column = $('.select-column').val();
    if (type_report == 4) {
        await $.ajax({
            type: "GET",
            url: `/api/exports/getDataMapChart?month=${month}&year=${year}&contract_id=${contract_id}`,
            success: function (response) {
                let html = '';
                let data = Object.keys(response.data).map((key) => response.data[key]);
                data.forEach(e => {
                    let dataE = Object.keys(e).map((key) => e[key]);
                    dataE.forEach(item => {
                        if (typeof item !== 'number') {
                            let dataItem = Object.keys(item).map((key) =>
                                item[
                                key]);
                            html +=
                                `<canvas id="mapChart${e.task_id}${dataItem[0]['code'].substring(0, 1)}" style="display:block;"></canvas>`;
                        }
                    });
                });
                $('.groupChart').html('');
                $('.groupChart').html(html);

                data.forEach(e => {
                    let dataChart = [];
                    Object.keys(e).forEach((key) => {
                        if (key != 'task_id') {
                            dataChart.push(e[key]);
                        }
                    });
                    // let areaKey = [];
                    dataChart.forEach(d => {
                        let labels = [];
                        let dataResults = [];
                        let dataKpi = [];
                        let backgroundColor = [];
                        let dataD = Object.keys(d).map((key) => d[key]);
                        dataD.forEach((itemD) => {

                            if (dataResults.length < column) {
                                labels.push(itemD.code);
                                dataResults.push((itemD.all_result /
                                    itemD.all_kpi) * 100);
                                // backgroundColor.push(getRandomRGBColor());
                                backgroundColor.push('#38A3EB');
                            }
                        })

                        let map = {
                            task_id: e.task_id,
                            chart: new Chart($(
                                `#mapChart${e.task_id}${dataD[0].code.substring(0, 1)}`
                            ), {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Tỷ lệ',
                                        data: dataResults,
                                        backgroundColor: backgroundColor,
                                        borderWidth: 1,
                                        order: 2,
                                    },]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                // Include a dollar sign in the ticks
                                                callback: function (
                                                    value,
                                                    index,
                                                    ticks
                                                ) {
                                                    return value +
                                                        '%';
                                                }
                                            }
                                        }
                                    }
                                }
                            })
                        }
                        listMapChart.push(map);
                    })
                });
            }
        });

        await $.ajax({
            type: "GET",
            url: `/api/exports/getTrendDataMapChart?month_compare=${month_compare}&year_compare=${year_compare}&month=${month}&year=${year}&contract_id=${contract_id}`,
            success: function (response) {
                let html = '';
                let data = Object.keys(response.data).map((key) => response.data[key]);

                data.forEach(e => {
                    html +=
                        `<canvas id="trendMapChart${e.code}" style="display:block;"></canvas>`;
                });
                $('.groupTrendChart').html('');
                $('.groupTrendChart').html(html);

                data.forEach(e => {
                    let backgroundColor = ['#38A3EB', '#38A3EB'];
                    let map = {
                        chart: new Chart($(
                            `#trendMapChart${e.code}`
                        ), {
                            type: 'bar',
                            data: {
                                labels: [
                                    `Năm ${year_compare < year ? year_compare : year}`,
                                    `Năm ${year_compare > year ? year_compare : year}`
                                ],
                                datasets: [{
                                    label: 'Tỷ lệ',
                                    data: [year_compare <
                                        year ? e
                                        .last_year :
                                        e.this_year,
                                    year_compare >
                                        year ?
                                        e.last_year :
                                        e.this_year
                                    ],
                                    order: 1,
                                    backgroundColor
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            // Include a dollar sign in the ticks
                                            callback: function (
                                                value,
                                                index,
                                                ticks) {
                                                return `${value}%`;
                                            }
                                        }
                                    }
                                }
                            }
                        })
                    }
                    listTrendMapChart.push(map);
                });

            },
        });

        await $.ajax({
            type: "GET",
            url: `/api/exports/getDataAnnualMapChart?year=${year}&contract_id=${contract_id}`,
            success: function (response) {
                let html = '';
                let data = Object.keys(response.data).map((key) => response.data[key]);
                let allCodeMap = [];

                // get all code map
                data.forEach(e => {
                    let value = Object.keys(e.value).map((key) => e
                        .value[key]);
                    value.forEach(item => {
                        let item_value = Object.keys(item).map((key) =>
                            item[
                            key]);
                        item_value.forEach((v) => {
                            if (!allCodeMap.includes(v.code)) {
                                allCodeMap.push(v.code);
                            }
                        })
                    });
                });
                data.forEach(e => {
                    allCodeMap.forEach(code => {
                        html +=
                            `<canvas id="annualMapChart${e.task_id}${code}" style="display:block;"></canvas>`;
                    })
                });
                $('.groupAnnualChart').html('');
                $('.groupAnnualChart').html(html);

                data.forEach(e => {
                    let result = [];
                    let value = Object.keys(e.value).map((key) => e
                        .value[key]);
                    allCodeMap.forEach(code => {
                        let rs = {
                            code: code,
                            month: [],
                            value_month: [],
                            backgroundColor: [],
                        };
                        value.forEach(item => {
                            let itemValue = Object.keys(item).map((
                                key) => item[key]);
                            itemValue.forEach(v => {
                                if (code == v.code) {
                                    rs.value_month.push(v
                                        .kpi != 0 ? (v
                                            .result / v
                                                .kpi) *
                                    100 : 0);
                                }
                            });

                            rs.month.push(item.month);
                            rs.backgroundColor.push('#38A3EB');

                        });
                        result.push(rs);
                    });

                    result.forEach(d => {
                        let map = {
                            task_id: e.task_id,
                            chart: new Chart($(
                                `#annualMapChart${e.task_id}${d.code}`
                            ), {
                                type: 'bar',
                                data: {
                                    labels: ['Tháng 01',
                                        'Tháng 02',
                                        'Tháng 03',
                                        'Tháng 04',
                                        'Tháng 05',
                                        'Tháng 06',
                                        'Tháng 07',
                                        'Tháng 08',
                                        'Tháng 09',
                                        'Tháng 10',
                                        'Tháng 11',
                                        'Tháng 12'
                                    ],
                                    datasets: [{
                                        label: 'Tỷ lệ',
                                        data: d
                                            .value_month,
                                        order: 1,
                                        backgroundColor: d
                                            .backgroundColor
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                // Include a dollar sign in the ticks
                                                callback: function (
                                                    value,
                                                    index,
                                                    ticks) {
                                                    return `${value}%`;
                                                }
                                            }
                                        }
                                    }
                                }
                            })
                        }
                        listAnnualMapChart.push(map);
                    });

                });
            },
        });
        setTimeout(() => {
            listMapChart.forEach(e => {
                $('.groupImage').append(
                    `<input type="hidden" name="image_charts[${e.chart.canvas.id.replace('mapChart', '')}]" value="${e.chart.toBase64Image('image/png', 1)}" alt="" />`
                );
            });
            listTrendMapChart.forEach(e => {
                $('.groupTrendImage').append(
                    `<input type="hidden" name="image_trend_charts[${e.chart.canvas.id.replace('trendMapChart', '')}]" value="${e.chart.toBase64Image('image/png', 1)}" alt="" />`
                );
            });
            listAnnualMapChart.forEach(e => {
                $('.groupAnnualImage').append(
                    `<input type="hidden" name="image_annual_charts[${e.chart.canvas.id.replace('annualMapChart', '')}]" value="${e.chart.toBase64Image('image/png', 1)}" alt="" />`
                );
            });
        }, 2000);
    }
    setTimeout(() => {
        $('.month').val($('.select-month').val());
        $('.year').val($('.select-year').val());
        $('.type_report').val($('.select-type').val());
        $('.contract_id').val($('.select-contract').val());
        $('.user_id').val($('.select-user').val());
        $('.month_compare').val($('.select-month-compare').val());
        $('.year_compare').val($('.select-year-compare').val());
        $('.display').val($('#select-display').is(':checked') ? $(
            '#select-display')
            .val() : 0);
        $('.btn-export').prop('disabled', false);
    }, 4000);
});

function getRandomRGBColor() {
    const red = Math.floor(Math.random() * 256);
    const green = Math.floor(Math.random() * 256);
    const blue = Math.floor(Math.random() * 256);

    return `rgb(${red}, ${green}, ${blue})`;
};

$(document).on('click', function (e) {
    const clickedElement = $(e.target);
    const clickedElementId = clickedElement.attr('id'); // or use any other identifier
    const targetElement = $('.modal-content-export'); // Replace with your element's ID

    if (!clickedElement.is(targetElement) && !clickedElement.parents().is(targetElement) &&
        $('body')
            .hasClass('modal-open')) {
        // Clicked outside the element
        $('.blockChart').html('');
    }
});
$(document).on('click', '.close', function (e) {
    $('.blockChart').html('');
});
