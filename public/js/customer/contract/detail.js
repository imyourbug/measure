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
    // let contract_id = $('#request_contract_id').val();
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
    let contract_id = $('#request_contract_id').val();
    let column = $('.select-column').val();
    if (type_report == 4) {
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
                                // dataResults.push((itemD.all_result /
                                // itemD.all_kpi) * 100);
                                // backgroundColor.push(getRandomRGBColor());
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

        await $.ajax({
            type: "GET",
            url: `/api/exports/getTrendDataMapChart?month_compare=${month_compare}&year_compare=${year_compare}&month=${month}&year=${year}&contract_id=${contract_id}`,
            success: function (response) {
                console.log(response);
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
                                        data: d.value_month_last_year,
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

        await $.ajax({
            type: "GET",
            url: `/api/exports/getDataAnnualMapChart?year=${year}&contract_id=${contract_id}`,
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
                            if (rs.month.length < month) {
                                let itemValue = Object.keys(item).map((
                                    key) => item[key]);
                                itemValue.forEach(v => {
                                    if (code == v.code) {
                                        // rs.value_month.push(v
                                        //     .kpi != 0 ? (v
                                        //         .result / v
                                        //             .kpi) *
                                        // 100 : 0);
                                        rs.value_month.push(v.result);
                                    }
                                });

                                rs.month.push(item.month);
                                rs.backgroundColor.push('#38A3EB');
                            }

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
                                        label: 'Số lượng',
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
        $('.contract_id').val($('#request_contract_id').val());
        $('.user_id').val($('.select-user').val());
        $('.month_compare').val($('.select-month-compare').val());
        $('.year_compare').val($('.select-year-compare').val());
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
