@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
@endpush
@push('scripts')
    <script src="/js/admin/task/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.0/js/dataTables.select.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.0/js/select.dataTables.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>
    <script src="https://cdn.datatables.net/keytable/2.12.0/js/dataTables.keyTable.js"></script>
    <script src="https://cdn.datatables.net/keytable/2.12.0/js/keyTable.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var listMapChart = [];
        var listTrendMapChart = [];
        var listAnnualMapChart = [];
        $('#form-export').submit(function(e) {
            e.preventDefault();
            let pattern = /^\d{4}$/;
            let year = $('.select-year').val();
            let month = $('.select-month').val();
            let column = $('.select-column').val();
            let contract_id = $('.select-contract').val();
            let url = $(this).attr('action');

            $.ajax({
                type: "POST",
                data: $(this).serialize(),
                url: $(this).attr('action'),
                success: function(response) {
                    console.log(response);
                    if (response.status == 0) {
                        console.log(response);
                        window.open(response.url);
                    } else {
                        toastr.error(response.message);
                    }
                }
            })
        });

        $('.btn-preview').on('click', async function() {
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
                    success: function(response) {
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
                                            }, ]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        // Include a dollar sign in the ticks
                                                        callback: function(
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
                    success: function(response) {
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
                                                    callback: function(
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
                    success: function(response) {
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
                                                        callback: function(
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

        $(document).on('click', function(e) {
            const clickedElement = $(e.target);
            const clickedElementId = clickedElement.attr('id'); // or use any other identifier
            const targetElement = $('.modal-content-export'); // Replace with your element's ID

            if (!clickedElement.is(targetElement) && !clickedElement.parents().is(targetElement) && $('body')
                .hasClass('modal-open')) {
                // Clicked outside the element
                $('.blockChart').html('');
            }
        });
        $(document).on('click', '.close', function(e) {
            $('.blockChart').html('');
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <form action="{{ route('admin.contracts.update', ['id' => $contract->id]) }}" method="POST"
                class="form-contract">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Tên hợp đồng <span class="required">(*)</span></label>
                                <input class="form-control" type="text" name="name"
                                    value="{{ old('name') ?? $contract->name }}" placeholder="Nhập tên hợp đồng..." />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Khách hàng <span class="required">(*)</span></label>
                                <select class="form-control" name="customer_id">
                                    <option value="">--Khách hàng--</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ $customer->id == $contract->customer_id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chi nhánh</label>
                                <input class="form-control" type="text" disabled
                                    value="{{ $contract->branch->name ?? '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Ngày bắt đầu <span class="required">(*)</span></label>
                                <input type="date" class="form-control" id="start" name="start"
                                    value="{{ old('start') ?? $contract->start }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Ngày kết thúc <span class="required">(*)</span></label>
                                <input type="date" class="form-control" id="finish" name="finish"
                                    value="{{ old('finish') ?? $contract->finish }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Nội dung</label>
                                <textarea placeholder="Nhập nội dung..." class="form-control" name="content" cols="30" rows="5">{{ old('content') ?? $contract->content }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group form-attachment">
                                <label class="notification" for="menu">Tệp đính kèm</label>
                                <div class="">
                                    <input type="file" id="attachment">
                                    <input type="hidden" name="attachment" id="value-attachment"
                                        value="{{ $contract->attachment }}">
                                </div>
                            </div>
                            @if ($contract->attachment)
                                <a href="{{ $contract->attachment }}" target="_blank">Xem</a>
                            @else
                                Trống
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-create">Lưu</button>
                    <a href="{{ route('admin.contracts.index') }}" class="btn btn-success">Xem danh sách</a>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Báo cáo</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn loại báo cáo <span class="required">(*)</span></label>
                                <select class="form-control select-type">
                                    <option value="0">
                                        KẾ HOẠCH THỰC HIỆN DỊCH VỤ
                                    </option>
                                    <option value="1">
                                        KẾ HOẠCH CHI TIẾT
                                    </option>
                                    <option value="2">
                                        BÁO CÁO ĐÁNH GIÁ KẾT QUẢ THỰC HIỆN DỊCH VỤ
                                    </option>
                                    <option value="3">
                                        BIÊN BẢN NGHIỆM THU CÔNG VIỆC HOÀN THÀNH
                                    </option>
                                    <option value="4" selected>
                                        BIÊN BẢN XÁC NHẬN KHỐI LƯỢNG HOÀN THÀNH-BÁO CÁO CHI TIẾT
                                    </option>
                                    <option value="5">
                                        BẢNG KÊ CÔNG VIỆC/DỊCH VỤ
                                    </option>
                                    <option value="6">
                                        BIÊN BẢN XÁC NHẬN CÔNG VIỆC/DỊCH VỤ
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Lựa chọn</label>
                                <div class="custom-control custom-checkbox">
                                    <input checked value="1" type="checkbox" id="select-display"
                                        class="option-type custom-control-input">
                                    <label class="custom-control-label" for="select-display">Hiển thị ảnh</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn tháng <span class="required">(*)</span></label>
                                <select class="form-control select-month">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}"
                                            {{ $i == now()->format('m') ? 'selected' : '' }}>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn năm <span class="required">(*)</span></label>
                                <input class="form-control select-year" type="text" value="{{ now()->format('Y') }}"
                                    placeholder="Nhập năm..." />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn tháng so sánh<span class="required">(*)</span></label>
                                <select class="form-control select-month-compare">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}"
                                            {{ $i == now()->format('m') ? 'selected' : '' }}>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Năm so sánh <span class="required">(*)</span></label>
                                <input value="{{ date('Y') - 1 }}" type="text"
                                    class="form-control year_compare select-year-compare">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn người lập báo cáo <span class="required">(*)</span></label>
                                <select class="form-control select-user">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->staff->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Số lượng cột hiển thị <span class="required">(*)</span></label>
                                <input value="10" min="1" type="number" id="select-column"
                                    class="form-control select-column" />
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="select-contract" value="{{ request()->id }}" />
                    <button class="btn btn-danger btn-preview" data-target="#modal-export" data-toggle="modal">Xuất
                        PDF</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card direct-chat direct-chat-primary">
        <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
            <h3 class="card-title text-bold">Nhiệm vụ</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: block;padding: 10px !important;">
            <div class="mb-3">
                <a href="{{ route('admin.tasks.index') }}" target="_blank" class="btn btn-success">Thêm mới</a>
                <input class="" style="" type="date" id="from"
                    value="{{ Request::get('from') ?? now()->format('Y-m-01') }}" />
                <input class="" style="" type="date" id="to"
                    value="{{ Request::get('to') ?? now()->format('Y-m-t') }}" />
                <button class="btn btn-warning btn-filter">Lọc</button>
            </div>
            <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
                <thead>
                    <tr>
                        <th>Nhiệm vụ</th>
                        <th>Hợp đồng</th>
                        <th>Ghi chú</th>
                        <th>Tần suất</th>
                        <th>Xác nhận</th>
                        <th>Hiện trạng</th>
                        <th>Nguyên nhân</th>
                        <th>Biện pháp</th>
                        <th>Ngày lập</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title">Cập nhật nhiệm vụ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Loại nhiệm vụ <span class="required">(*)</span></label>
                                <select class="form-control" id="type_id">
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">
                                            {{ $type->id . '-' . $type->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Hợp đồng</label>
                                <select class="form-control select-contract" id="contract_id">
                                    <option value="">--Hợp đồng--</option>
                                    @foreach ($contracts as $contract)
                                        <option value="{{ $contract->id }}">
                                            {{ $contract->name . '-' . ($contract->branch->name ?? '') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Tần suất</label>
                                <input class="form-control" type="text" id="frequence" placeholder="Nhập tần suất" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Xác nhận</label>
                                <input class="form-control" type="text" id="confirm" placeholder="Nhập xác nhận" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Hiện trạng</label>
                                <input class="form-control" type="text" id="status"
                                    placeholder="Nhập hiện trạng" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Nguyên nhân</label>
                                <input class="form-control" type="text" id="reason"
                                    placeholder="Nhập nguyên nhân" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Biện pháp</label>
                                <input class="form-control" type="text" placeholder="Nhập biện pháp"
                                    id="solution" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Ghi chú <span class="required">(*)</span></label>
                                <input class="form-control" type="text" placeholder="Nhập ghi chú..."
                                    id="note" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" data-url="{{ route('tasks.update') }}"
                        class="btn btn-primary btn-update">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-export" style="display:none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content modal-content-export">
                <form action="{{ route('exports.plan') }}" method="POST" id="form-export">
                    <div class="modal-header">
                        <h4 class="modal-title">Xuất báo cáo?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="groupImage">
                    </div>
                    <div class="groupTrendImage">
                    </div>
                    <div class="groupAnnualImage">
                    </div>
                    {{-- <div class="groupChart" style="display: block;">
                    </div>
                    <div class="groupTrendChart" style="display: block;">
                    </div>
                    <div class="groupAnnualChart" style="display: block;">
                    </div> --}}
                    <input type="hidden" class="month" name="month" />
                    <input type="hidden" class="year" name="year" />
                    <input type="hidden" class="type_report" name="type_report" />
                    <input type="hidden" class="contract_id" value="{{ request()->id }}" name="contract_id" />
                    <input type="hidden" class="user_id" name="user_id" />
                    <input type="hidden" class="display" name="display" />
                    <input type="hidden" class="year_compare" name="year_compare" />
                    <input type="hidden" class="month_compare" name="month_compare" />
                    <div class="modal-footer justify-content-between">
                        <button class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary btn-export" disabled>Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="task_id" />
    <input type="hidden" id="request_contract_id" value="{{ request()->id }}" />
    <div style="" class="allChart">
        <div class="groupChart blockChart" style="">
        </div>
        <div class="groupTrendChart blockChart" style="">
        </div>
        <div class="groupAnnualChart blockChart" style="">
        </div>
    </div>
@endsection
