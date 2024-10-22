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
                },
            },
        ],
    });
    //
    $('.btn-filter').click();
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
                // render images
                $('.block-image').html('');
                let html = '';
                response.task.images.forEach((image) => {
                    html += `<span class="image-task" data-id="${image.id}" style="position: relative;">
                                <img style="width: 100px;height:100px" src="${image.url}" data-id="${image.id}" data-task_id="${image.task_id}"
                                    alt="image" />
                                <span class="btn btn-sm btn-danger" style="right:0px;position: absolute;">
                                    <i data-id="${image.id}"
                                        class="fa-solid fa-trash btn-remove-image"></i>
                                </span>
                            </span>`;
                });
                $('.block-image').html(html);
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

$(document).on('submit', '#form-export', function (e) {
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
    });
});

$(document).on('click', '.btn-preview', async function () {
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
        // first chart
        await $.ajax({
            type: "GET",
            url: `/api/exports/getDataMapChart?month=${month}&year=${year}&contract_id=${contract_id}`,
            success: function (response) {
                let html = '';
                response.data.forEach(e => {
                    let dataE = Object.keys(e).map((key) => e[key]);
                    dataE.forEach(item => {
                        if (typeof item !== 'number') {
                            let dataItem = Object.keys(item).map((key) =>
                                item[
                                key]);
                            let mapCode = dataItem[0]['code'].split('-');

                            html +=
                                `<canvas id="mapChart${e.task_id}${mapCode[0]}" style="display:block;"></canvas>`;
                        }
                    });
                });
                $('.groupChart').html('');
                $('.groupChart').html(html);

                response.data.forEach(e => {
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
                        let dataKpis = [];
                        let backgroundColorResult = [];
                        let backgroundColorKpi = [];
                        let dataD = Object.keys(d).map((key) => d[key]);
                        dataD.forEach((itemD) => {
                            if (dataResults.length < column) {
                                labels.push(itemD.code);
                                dataResults.push(itemD.all_result);
                                dataKpis.push(itemD.all_kpi);
                                backgroundColorResult.push('#38A3EB');
                                backgroundColorKpi.push('#F16C16');
                            }
                        })

                        //
                        let mapCode = dataD[0].code.split('-');
                        let map = {
                            task_id: e.task_id,
                            chart: new Chart($(
                                `#mapChart${e.task_id}${mapCode[0]}`
                            ), {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Kết quả',
                                        data: dataResults,
                                        backgroundColor: backgroundColorResult,
                                        borderWidth: 1,
                                        order: 1,
                                    }, {
                                        label: 'KPI',
                                        data: dataKpis,
                                        borderColor: '#F16C16',
                                        backgroundColor: backgroundColorKpi,
                                        type: 'line',
                                        order: 0
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
                                                    ticks
                                                ) {
                                                    return value;
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
        // second chart
        await $.ajax({
            type: "GET",
            url: `/api/exports/getDataAnnualMapChart?month_compare=${month_compare}&year_compare=${year_compare}&month=${month}&year=${year}&contract_id=${contract_id}`,
            success: function (response) {
                let html = '';
                let allCodeMap = [];
                // get id chart
                response.data.forEach(e => {
                    let value = Object.keys(e.value).map((key) => e
                        .value[key]);
                    value.forEach(item => {
                        let mapCode = item.code.split('-');
                        if (!allCodeMap.includes(`${e.task_id}${mapCode[0]}`)) {
                            allCodeMap.push(`${e.task_id}${mapCode[0]}`);
                        }
                    });
                });
                // create chart
                allCodeMap.forEach(item => {
                    html +=
                        `<canvas id="annualMapChart${item}" style="display:block;"></canvas>`;
                });
                $('.groupAnnualChart').html('');
                $('.groupAnnualChart').html(html);

                response.data.forEach(e => {
                    let value = Object.keys(e.value).map((key) => e
                        .value[key]);
                    let codeGroup = [];
                    value.forEach(item => {
                        let mapCode = item.code.split('-');
                        if (!codeGroup.includes(mapCode[0])) {
                            codeGroup.push(mapCode[0]);
                        }
                    });


                    let dataCreateCharts = [];
                    codeGroup.forEach(code => {
                        let labels = [];
                        let last_month = [];
                        let this_month = [];
                        let kpi_this_month = [];
                        let backgroundColorLastMonth = [];
                        let backgroundColorThisMonth = [];
                        let backgroundColorKpiThisMonth = [];
                        let count = 0;
                        value.forEach(item => {
                            let mapCode = item.code.split('-');
                            if (mapCode[0] == code && count < column) {
                                labels.push(item.code);
                                last_month.push(item.last_month.result);
                                this_month.push(item.this_month.result);
                                kpi_this_month.push(item.this_month.kpi);
                                backgroundColorLastMonth.push('#38A3EB');
                                backgroundColorThisMonth.push('#3E7B35');
                                backgroundColorKpiThisMonth.push('#F37519');
                                count++;
                            }
                        });
                        dataCreateCharts.push({
                            code: code,
                            labels,
                            last_month,
                            this_month,
                            kpi_this_month,
                            backgroundColorLastMonth,
                            backgroundColorThisMonth,
                            backgroundColorKpiThisMonth,
                        });
                    });

                    dataCreateCharts.forEach(dataCreateChart => {
                        let map = {
                            task_id: e.task_id,
                            chart: new Chart($(
                                `#annualMapChart${e.task_id}${dataCreateChart.code}`
                            ), {
                                type: 'bar',
                                data: {
                                    labels: dataCreateChart.labels,
                                    datasets: [{
                                        label: `Số lượng ${month}/${year}`,
                                        data: dataCreateChart.this_month,
                                        order: 1,
                                        backgroundColor: dataCreateChart.backgroundColorThisMonth
                                    },
                                    {
                                        label: `Số lượng ${month_compare}/${year_compare}`,
                                        data: dataCreateChart.last_month,
                                        order: 2,
                                        backgroundColor: dataCreateChart.backgroundColorLastMonth
                                    },
                                    {
                                        label: 'KPI',
                                        data: dataCreateChart.kpi_this_month,
                                        borderColor: '#F37519',
                                        backgroundColor: dataCreateChart.backgroundColorKpiThisMonth,
                                        type: 'line',
                                        order: 0
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
                                                    return `${value}`;
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
        // third chart
        await $.ajax({
            type: "GET",
            url: `/api/exports/getTrendDataMapChart?month_compare=${month_compare}&year_compare=${year_compare}&month=${month}&year=${year}&contract_id=${contract_id}`,
            success: function (response) {
                let html = '';
                let data = Object.keys(response.data).map((key) => response.data[key]);
                let allCodeMap = [];

                // get all code map
                data.forEach(e => {
                    e.value.forEach(item => {
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
                            `<canvas id="trendMapChart${e.task_id}${code}" style="display:block;"></canvas>`;
                    })
                });
                $('.groupTrendChart').html('');
                $('.groupTrendChart').html(html);

                data.forEach(e => {
                    let result = [];
                    let value = Object.keys(e.value).map((key) => e
                        .value[key]);
                    allCodeMap.forEach(code => {
                        let rs = {
                            code: code,
                            month: [],
                            value_kpi_this_year: [],
                            value_month_this_year: [],
                            value_month_last_year: [],
                            backgroundColorThisYear: [],
                            backgroundColorLastYear: [],
                            backgroundColorKpiThisYear: [],
                        };
                        value.forEach(item => {
                            if (rs.month.length < month) {
                                let itemValue = Object.keys(item).map((
                                    key) => item[key]);
                                itemValue.forEach(v => {
                                    if (code == v.code) {
                                        rs.value_kpi_this_year.push(v.this_year.kpi);
                                        rs.value_month_this_year.push(v.this_year.result);
                                        rs.value_month_last_year.push(v.last_year.result);
                                    }
                                });

                                rs.month.push(item.month);
                                rs.backgroundColorThisYear.push('#38A3EB');
                                rs.backgroundColorLastYear.push('#3E7B35');
                                rs.backgroundColorKpiThisYear.push('#F37519');
                            }

                        });
                        result.push(rs);
                    });

                    result.forEach(d => {
                        let map = {
                            task_id: e.task_id,
                            chart: new Chart($(
                                `#trendMapChart${e.task_id}${d.code}`
                            ), {
                                type: 'bar',
                                data: {
                                    labels: [
                                        'Tháng 01',
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
                                    ].slice(0, month),
                                    datasets: [{
                                        label: `Số lượng ${year}`,
                                        data: d.value_month_this_year,
                                        order: 1,
                                        backgroundColor: d.backgroundColorThisYear
                                    },
                                    {
                                        label: `Số lượng ${year_compare}`,
                                        data: d.value_month_last_year,
                                        order: 2,
                                        backgroundColor: d.backgroundColorLastYear
                                    },
                                    {
                                        label: 'KPI',
                                        data: d.value_kpi_this_year,
                                        borderColor: '#F37519',
                                        backgroundColor: d.backgroundColorKpiThisYear,
                                        type: 'line',
                                        order: 0
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
                                                    return `${value}`;
                                                }
                                            }
                                        }
                                    }
                                }
                            })
                        }
                        listTrendMapChart.push(map);
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
        $('.month').val(month);
        $('.year').val(year);
        $('.type_report').val(type_report);
        $('.contract_id').val(contract_id);
        $('.user_id').val($('.select-user').val());
        $('.month_compare').val(month_compare);
        $('.year_compare').val(year_compare);
        $('.column').val(column);
        $('.display').val($('#select-display').is(':checked') ? $(
            '#select-display')
            .val() : 0);
        $('.display-first').val($('#select-display-first').is(':checked') ? $(
            '#select-display-first')
            .val() : 0);
        $('.display-second').val($('#select-display-second').is(':checked') ? $(
            '#select-display-second')
            .val() : 0);
        $('.display-third').val($('#select-display-third').is(':checked') ? $(
            '#select-display-third')
            .val() : 0);
        //
        $('.display-year').val($('#display-year').is(':checked') ? 1 : 0);
        $('.display-month-compare').val($('#display-month-compare').is(':checked') ? 1 : 0);
        $('.display-year-compare').val($('#display-year-compare').is(':checked') ? 1 : 0);
        //
        $('.task_id').val($('.select-task').val());
        //
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

$(document).on('click', '.display-year', function (e) {
    $('.blockChart').html('');
});

$(document.body).on("change", "#contracts", function (e) {
    let selectedContracts = $('#contracts').select2('data');
    if (selectedContracts.length > 0) {
        let contract_id = selectedContracts[0].id;
        $('.select-contract-copy').select2().val(contract_id).trigger('change');
        $('.select-contract').select2().val(contract_id).trigger('change');
    }
});

// $(document.body).on("change", ".select-contract-copy", function (e) {
//     let selectedContracts = $('.select-contract-copy').select2('data');
//     if (selectedContracts.length > 0) {
//         let contract_id = selectedContracts[0].id;
//         $('.select-contract').select2().val(contract_id).trigger('change');
//     }
// });

// $(document.body).on("change", ".select-contract", function (e) {
//     let selectedContracts = $('.select-contract').select2('data');
//     if (selectedContracts.length > 0) {
//         let contract_id = selectedContracts[0].id;
//         $('.select-contract-copy').select2().val(contract_id).trigger('change');
//     }
// });
