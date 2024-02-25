@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
    {{-- <script src="/js/admin/contract/index.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive: true
            });

        });
        var listMapChart = [];
        var listTrendMapChart = [];
        var listAnnualMapChart = [];
        $('#form-export').submit(function(event) {
            event.preventDefault();
            let pattern = /^\d{4}$/;
            let year = $('.select-year').val();
            let month = $('.select-month').val();

            // $(this).unbind('submit').submit();
            if (!month | !year | !pattern.test(year)) {
                alert('Kiểm tra thông tin đã nhập!');
            } else {
                $(this).unbind('submit').submit();
            }
        })

        $('.btn-preview').on('click', function() {
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
            // $('.blockChart').html('');
            let year = $('.select-year').val();
            let month = $('.select-month').val();
            let contract_id = $('.contract_id').val();
            if (type_report == 1) {
                $.ajax({
                    type: "GET",
                    url: "/api/exports/getDataMapChart?month=" + month + "&year=" + year + "&contract_id=" +
                        contract_id,
                    success: function(response) {
                        let html = '';
                        let data = Object.keys(response.data).map((key) => response.data[key]);
                        data.forEach(e => {
                            html +=
                                `<canvas id="mapChart${e.task_id}" style="display:block;"></canvas>`;
                        });
                        $('.groupChart').html('');
                        $('.groupChart').html(html);

                        data.forEach(e => {
                            let labels = [];
                            let dataResults = [];
                            let dataKpi = [];
                            let backgroundColor = [];
                            let dataChart = [];
                            Object.keys(e).forEach((key) => {
                                if (key != 'task_id') {
                                    dataChart.push(e[key]);
                                }
                            });
                            dataChart.forEach(d => {
                                labels.push(
                                    `${d.area}-${d.map_id.toString().padStart(3, "0") }`
                                );
                                dataResults.push(d.all_result);
                                dataKpi.push(d.all_kpi);
                                // backgroundColor.push(getRandomRGBColor());
                                backgroundColor.push('#E50B4E');
                            });
                            let map = {
                                task_id: e.task_id,
                                chart: new Chart($('#mapChart' + e.task_id), {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                                label: 'Kết quả thực tế',
                                                data: dataResults,
                                                backgroundColor: backgroundColor,
                                                borderWidth: 1,
                                                order: 2,
                                            },
                                            {
                                                type: 'line',
                                                label: 'KPI',
                                                data: dataKpi,
                                                fill: false,
                                                borderColor: 'rgb(54, 162, 235)',
                                                order: 1,
                                            }
                                        ]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                })
                            }
                            listMapChart.push(map);
                        });
                    },
                })

                $.ajax({
                    type: "GET",
                    url: "/api/exports/getTrendDataMapChart?contract_id=" +
                        contract_id,
                    success: function(response) {
                        let html = '';
                        let data = Object.keys(response.data).map((key) => response.data[key]);
                        data.forEach(e => {
                            html +=
                                `<canvas id="trendMapChart${e.task_id}" style="display:block;"></canvas>`;
                        });
                        $('.groupTrendChart').html('');
                        $('.groupTrendChart').html(html);

                        data.forEach(e => {
                            let labels = [];
                            let dataResultsTrend = [];
                            let dataKpiTrend = [];
                            let backgroundColor = [];
                            let dataTrendChart = [];
                            Object.keys(e).forEach((key) => {
                                if (key != 'task_id') {
                                    dataTrendChart.push(e[key]);
                                }
                            });
                            dataTrendChart.forEach(d => {
                                labels.push(
                                    `${d.month}-${d.year}`
                                );
                                dataResultsTrend.push(d.result);
                                dataKpiTrend.push(d.kpi);
                                // backgroundColor.push(getRandomRGBColor());
                                backgroundColor.push('#E50B4E');
                            });
                            let map = {
                                task_id: e.task_id,
                                chart: new Chart($('#trendMapChart' + e.task_id), {
                                    type: 'line',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                                type: 'line',
                                                label: 'Kết quả thực tế',
                                                data: dataResultsTrend,
                                                fill: false,
                                                borderColor: 'rgb(00, 162, 000)',
                                                order: 1,
                                            },
                                            {
                                                type: 'line',
                                                label: 'KPI',
                                                data: dataKpiTrend,
                                                fill: false,
                                                borderColor: 'rgb(54, 162, 235)',
                                                order: 1,
                                            }
                                        ]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                })
                            }
                            listTrendMapChart.push(map);
                        });
                    },
                })

                $.ajax({
                    type: "GET",
                    url: "/api/exports/getDataAnnualMapChart?contract_id=" +
                        contract_id,
                    success: function(response) {
                        let html = '';
                        let data = Object.keys(response.data).map((key) => response.data[key]);
                        let this_year = '';
                        let last_year = '';
                        data.forEach(e => {
                            html +=
                                `<canvas id="annualMapChart${e.task_id}" style="display:block;"></canvas>`;
                        });
                        $('.groupAnnualChart').html('');
                        $('.groupAnnualChart').html(html);

                        data.forEach(e => {
                            let labels = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
                            let dataResultsThisYear = [];
                            let dataResultsLastYear = [];
                            let backgroundColor = [];
                            let dataLastYearChart = [];
                            let dataThisYearChart = [];
                            last_year = e.last_year['year'] ?? '';
                            this_year = e.this_year['year'] ?? '';

                            Object.keys(e.last_year).forEach((key) => {
                                if (key != 'task_id' && key != 'year') {
                                    dataLastYearChart.push(e.last_year[key]);
                                }
                            });
                            dataLastYearChart.forEach(d => {
                                dataResultsLastYear.push(d.result);
                                // backgroundColor.push('#E50B4E');
                            });
                            //
                            Object.keys(e.this_year).forEach((key) => {
                                if (key != 'task_id' && key != 'year') {
                                    dataThisYearChart.push(e.this_year[key]);
                                }
                            });
                            dataThisYearChart.forEach(d => {
                                dataResultsThisYear.push(d.result);
                                // backgroundColor.push('#E50B4E');
                            });
                            //

                            let map = {
                                task_id: e.task_id,
                                chart: new Chart($('#annualMapChart' + e.task_id), {
                                    type: 'line',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                                type: 'line',
                                                label: this_year,
                                                data: dataResultsThisYear,
                                                fill: false,
                                                borderColor: 'rgb(00, 162, 000)',
                                                order: 1,
                                            },
                                            {
                                                type: 'line',
                                                label: last_year,
                                                data: dataResultsLastYear,
                                                fill: false,
                                                borderColor: 'rgb(54, 162, 235)',
                                                order: 1,
                                            }
                                        ]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                })
                            }
                            listAnnualMapChart.push(map);
                        });
                    },
                })
            }

            setTimeout(() => {
                if (type_report == 1) {
                    console.log(listMapChart);
                    console.log(listTrendMapChart);
                    console.log(listAnnualMapChart);

                    listMapChart.forEach(e => {
                        $('.groupImage').append(
                            `<input type="hidden" name="image_charts[${e.task_id}]" value="${e.chart.toBase64Image('image/png', 1)}" alt="" />`
                        );
                    });
                    listTrendMapChart.forEach(e => {
                        $('.groupTrendImage').append(
                            `<input type="hidden" name="image_trend_charts[${e.task_id}]" value="${e.chart.toBase64Image('image/png', 1)}" alt="" />`
                        );
                    });
                    listAnnualMapChart.forEach(e => {
                        $('.groupAnnualImage').append(
                            `<input type="hidden" name="image_annual_charts[${e.task_id}]" value="${e.chart.toBase64Image('image/png', 1)}" alt="" />`
                        );
                    });
                }

                $('.month').val($('.select-month').val());
                $('.year').val($('.select-year').val());
                $('.type_report').val($('.select-type').val());
                $('.user_id').val($('.select-user').val());
                $('.display').val($('#select-display').is(':checked') ? $('#select-display').val() : 0);
                setTimeout(() => {
                    $('.btn-export').prop('disabled', false);
                }, 2000);
            }, 2000);
        });

        function getRandomRGBColor() {
            const red = Math.floor(Math.random() * 256);
            const green = Math.floor(Math.random() * 256);
            const blue = Math.floor(Math.random() * 256);

            return `rgb(${red}, ${green}, ${blue})`;
        };
    </script>
@endpush
@section('content')
    <div style="position: relative;index:1;">
        {{-- <div class="groupChart blockChart" style="display: block;visibility:hidden;position: absolute;index:-1">
    </div>
    <div class="groupTrendChart blockChart" style="display: block;visibility:hidden;position: absolute;index:-1">
    </div>
    <div class="groupAnnualChart blockChart" style="display: block;visibility:hidden;position: absolute;index:-1">
    </div> --}}
        <div class="groupChart blockChart" style="display: block;position: absolute;index:-1;opacity:0">
        </div>
        <div class="groupTrendChart blockChart" style="display: block;position: absolute;index:-2;opacity:0">
        </div>
        <div class="groupAnnualChart blockChart" style="display: block;position: absolute;index:-3;opacity:0">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="menu">Tên hợp đồng</label>
                            <p class="form-control">
                                {{ $contract->name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="menu">Khách hàng</label>
                            <p class="form-control">
                                {{ $contract->customer->name }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="menu">Chi nhánh</label>
                            <p class="form-control">
                                {{ $contract->branch->name }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="menu">Ngày bắt đầu</label>
                            <p class="form-control">
                                {{ $contract->start }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="menu">Ngày kết thúc</label>
                            <p class="form-control">
                                {{ $contract->finish }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="menu">Nội dung</label>
                            <textarea placeholder="Nhập nội dung..." class="form-control" name="content" cols="30" rows="3">{{ old('content') ?? $contract->content }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group form-attachment">
                            <label class="notification" for="menu">Tệp đính kèm</label>&emsp13;
                            @if ($contract->attachment)
                                <a href="{{ $contract->attachment }}" target="_blank">Xem</a>
                            @else
                                Trống
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
                                <label for="menu">Chọn loại báo cáo</label>
                                <select class="form-control select-type">
                                    <option value="0">
                                        Kế hoạch dịch vụ
                                    </option>
                                    <option value="1">
                                        Kết quả tháng
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn người lập báo cáo</label>
                                <select class="form-control select-user">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->staff->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn tháng</label>
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
                                <label for="menu">Chọn năm</label>
                                <input class="form-control select-year" type="text" value="{{ now()->format('Y') }}"
                                    placeholder="Nhập năm..." />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Hiển thị biểu đồ năm</label>
                                <div class="custom-control custom-checkbox">
                                    <input value="1" type="checkbox" id="select-display"
                                        class="option-type custom-control-input">
                                    <label class="custom-control-label" for="select-display">Có</label>
                                </div>
                            </div>
                        </div>
                    </div>
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
            <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nhiệm vụ</th>
                        <th>Ghi chú</th>
                        <th>Ngày lập</th>
                        <th>Thao tác</th>
                    </tr>
                <tbody>
                    @foreach ($contract->tasks as $task)
                        <tr class="row{{ $task->id }}">
                            <th>{{ $task->id }}</th>
                            <th>{{ $task->type->name }}</th>
                            <td>{{ $task->note ?? 'Trống' }}</td>
                            <td>{{ date('d-m-Y', strtotime($task->created_at)) }}</td>
                            <td><a class="btn btn-success btn-sm" style="padding: 4px 15px"
                                    href='{{ route('admin.tasks.detail', ['id' => $task->id]) }}'>
                                    <i class="fa-solid fa-info"></i>
                                </a>
                                {{-- <button data-id="{{ $task->id }}" class="btn btn-danger btn-sm btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </thead>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-export" style="display:none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
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
                    <input type="hidden" class="contract_id" value="{{ $contract->id }}" name="contract_id" />
                    <input type="hidden" class="user_id" name="user_id" />
                    <input type="hidden" class="display" name="display" />
                    <div class="modal-footer justify-content-between">
                        <button class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary btn-export" disabled>Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
