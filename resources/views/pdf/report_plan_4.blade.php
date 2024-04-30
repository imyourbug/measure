<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['file_name'] }}</title>
    <style>
        .col9 {
            width: 90%;
            float: left;
        }

        .col8 {
            width: 80%;
            float: left;
        }

        .col7 {
            width: 70%;
            float: left;
        }

        .col6 {
            width: 60%;
            float: left;
        }

        .col5 {
            width: 50%;
            float: left;
        }

        .col4 {
            width: 40%;
            float: left;
        }

        .col3 {
            width: 30%;
            float: left;
        }

        .col2 {
            width: 20%;
            float: left;
        }

        .col1 {
            width: 10%;
            float: left;
        }

        .col10 {
            width: 100%;
            float: left;
        }

        body {
            font-size: 8px;
            font-family: DejaVu Sans, sans-serif;
            /* font-family:'Times New Roman', Times, serif; */
        }

        .tbl-plan {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl-plan td,
        .tbl-plan th {
            border: 0.1px solid black;
            padding: 2px 10px 2px 5px;
        }
    </style>
</head>

<body>
    <header>
        <div class="col10">
            <div class="col7" style="text-align: right">
                <p style="font-size: 12px;font-weight:bold;text-align:center;postion:absolute;margin-left:0">CÔNG TY
                    TNHH DỊCH VỤ PESTKIL VIỆT NAM - CHI NHÁNH:
                    HÀ
                    NỘI <br>- - - o0o - - -</p>
            </div>
            <div class="col3">
                &emsp;
            </div>
        </div>
        <p style="text-align:right">98 Nguyễn Khiêm Ích – Trâu Quỳ - Gia Lâm – TP Hà Nội, ngày {{ date('d') }} tháng
            {{ date('m') }} năm
            {{ date('Y') }}</p>
    </header>
    <div class="" style="text-align: center">
        <p style="font-size: 14px;font-weight:bold;">{{ $data['file_name'] }}</p>
        <p style="font-style:italic">V/v: {{ $data['contract']['name'] ?? '' }} năm {{ date('Y') }}</p>
        <p style="font-style:italic">Hợp đồng số {{ $data['contract']['id'] ?? '' }} ký ngày
            {{ \Illuminate\Support\Carbon::parse($data['contract']['created_at'])->format('d-m-Y') }}</p>
    </div>
    <h3>A. Thành phần tham gia nghiệm thu</h3>
    <h3>BÊN A: {{ $data['customer']['representative'] ?? $data['customer']['name'] }} –
        {{ $data['branch']['name'] ?? '' }}</h3>
    <p style="margin-left: 30px">Đại diện: Ông ( bà ) : {{ $data['branch']['manager'] ?? '' }} Chức vụ :</p>
    <h3>BÊN B: CÔNG TY TNHH DỊCH VỤ PESTKIL VIỆT NAM</h3>
    <p style="margin-left: 30px">Đại diện: Ông ( bà ) :{{ $data['creator']['staff']['name'] ?? '' }} Chức vụ
        :{{ $data['creator']['staff']['position'] ?? '' }}</p>
    <p style="margin-left: 30px">Địa điểm: {{ $data['branch']['name'] ?? '' }} </p>
    <p style="margin-left: 30px">Thời gian: từ
        {{ \Illuminate\Support\Carbon::parse($data['contract']['start'])->format('d-m-Y') }} đến
        {{ \Illuminate\Support\Carbon::parse($data['contract']['finish'])->format('d-m-Y') }} </p>
    <h3>B. Khối lượng hoàn thành </h3>
    @if (!empty($data['tasks']))
        @foreach ($data['tasks'] as $key => $info)
            <p style="font-weight:bold;">{{ $info['type']['name'] ?? '' }} - {{ $data['contract']['name'] ?? '' }}
                Tháng
                {{ $data['month'] }} năm {{ $data['year'] }}, cụ thể như sau:</p>
            <table class="tbl-plan" cellspacing="0">
                <tbody>
                    @php
                        $count = 0;
                    @endphp
                    <tr>
                        <th rowspan="2">STT</th>
                        <th rowspan="2">Tên nhiệm vụ</th>
                        <th colspan="4">Chi tiết</th>
                        <th rowspan="2">Ảnh</th>
                        <th colspan="4">Theo dõi số liệu</th>
                        <th rowspan="2">Ghi chú</th>
                    </tr>
                    <tr>
                        <th>Khu vực</th>
                        <th>Phạm vi</th>
                        <th>Đối tượng</th>
                        <th>Số lượng</th>
                        <th>Đơn vị</th>
                        <th>Kết quả</th>
                        <th>KPI</th>
                        <th>Đánh giá</th>
                    </tr>
                    @php
                        $plan_dates = '';
                        $actual_dates = '';
                        foreach ($info['details'] as $task) {
                            $date = explode('-', $task['plan_date']);
                            if ($date[0] == $data['year'] && $date[1] == $data['month']) {
                                $plan_dates .=
                                    \Illuminate\Support\Carbon::parse($task['plan_date'])->format('d/m') . ';';
                                $actual_dates .=
                                    \Illuminate\Support\Carbon::parse($task['actual_date'])->format('d/m') . ';';
                            }
                        }
                    @endphp
                    @foreach ($info['details'] as $task)
                        @foreach ($task['task_maps'] as $key => $taskMap)
                            @php
                                $count++;
                                $sumResult = 0;
                                $sumKPI = 0;
                                foreach ($taskMap as $taskMapInfo) {
                                    $sumResult += $taskMapInfo['result'] ?? 0;
                                    $sumKPI += $taskMapInfo['kpi'] ?? 0;
                                }
                            @endphp
                            <tr>
                                <td>{{ $count < 10 ? '0' . $count : $count }}</td>
                                <td>{{ $info['type']['name'] ?? '' }}</td>
                                <td>{{ $key }} </td>
                                <td>{{ $taskMap[0]['round'] ?? '' }}</td>
                                <td>{{ $taskMap[0]['target'] ?? '' }}</td>
                                <td>{{ count($taskMap) }}</td>
                                <td>
                                    @if (!empty($taskMap[0]['image']))
                                        <img src="{{ public_path($taskMap[0]['image']) }}" width="20px"
                                            height="20px" alt="">
                                    @endif
                                </td>
                                <td>{{ $taskMap[0]['unit'] ?? '' }}</td>
                                <td>{{ round($sumResult / count($taskMap), 2) }}</td>
                                <td>{{ round($sumKPI / count($taskMap), 2) }}</td>
                                <td>{{ $sumResult < $sumKPI ? 'Không đạt' : 'Đạt' }}</td>
                                <td>{{ $taskMap['note'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endforeach

                </tbody>
            </table>
            <br />
            <br />
            <p style="">Báo cáo phân tích</p>
            @foreach ($info['details'] as $task)
                @foreach ($task['task_maps'] as $key => $taskMaps)
                    @php
                        $keyImage = ($info['id'] ?? '') . $key;
                    @endphp
                    <p>Khu vực {{ $key }}</p>

                    @if ($data['display'])
                        <table class="tbl-plan">
                            <tr>
                                <td>Tháng {{ $data['month'] }} năm {{ $data['year'] }}</td>
                                <td>So sánh {{ $data['month_compare'] . '-' . $data['year_compare'] }} với
                                    {{ $data['month'] . '-' . $data['year'] }}</td>
                                <td>Diễn biến từng tháng</td>
                            </tr>
                            <tr>
                                <td>ph
                                    @if (!empty($data['image_charts'][$keyImage]))
                                        <img src="{{ $data['image_charts'][$keyImage] }}" alt=""
                                            style="margin-bottom: 20px" />
                                    @endif
                                </td>
                                <td style="border: 0.5px solid black;border-right: 0.5px solid black;">
                                    @if (!empty($data['image_trend_charts'][$keyImage]))
                                        <img src="{{ public_path($data['image_trend_charts'][$keyImage]) }}"
                                            alt="" />
                                    @endif

                                </td>
                                <td style="border: 0.5px solid black;border-right: 0.5px solid black;">
                                    @if (!empty($data['image_annual_charts'][$keyImage]))
                                        <img src="{{ public_path($data['image_annual_charts'][$keyImage]) }}"
                                            alt="" />
                                    @endif
                                </td>
                            </tr>
                        </table>
                    @endif
                    <p style="margin-left:20px">- Nhận xét</p>
                    <p style="margin-left:20px">- Chi tiết</p>
                    <p style="margin-left:10px">Kết quả theo dõi: Từ: Tháng {{ $data['month'] }} năm
                        {{ $data['year'] }}
                        đến
                        Tháng {{ $data['month'] }} năm {{ $data['year'] }}</p>
                    <table class="tbl-plan">
                        <tr>
                            <td>Mã sơ đồ</td>
                            @foreach ($taskMaps as $task_map)
                                @if (substr($task_map['code'], 0, 1) === $key)
                                    <td>{{ $task_map['code'] ?? '' }}</td>
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            <td>
                                Kết quả
                            </td>
                            @foreach ($taskMaps as $task_map)
                                @if (substr($task_map['code'], 0, 1) === $key)
                                    <td>
                                        {{ $task_map['kpi'] !== 0 ? round(($task_map['result'] / $task_map['kpi']) * 100, 2) : 0 }}%
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    </table>
                    <p style="margin-left:10px">Kết quả theo dõi: Năm {{ $data['year'] }} so với
                        {{ $data['year_compare'] }}
                    </p>
                    <table class="tbl-plan">
                        <tr>
                            <td>Năm</td>
                            @for ($i = 1; $i <= 12; $i++)
                                <td>
                                    Tháng {{ $i < 10 ? '0' . $i : $i }}
                                </td>
                            @endfor
                        </tr>
                        <tr>
                            <td>
                                {{ $data['year'] }}
                            </td>
                            @for ($i = 1; $i <= 12; $i++)
                                <td>
                                    @if (!empty($data['compare'][$info['id']]['this_year'][$i - 1]))
                                        @php
                                            $result_this_year = 0;
                                            $kpi_this_year = 0;
                                            foreach ($data['compare'][$info['id']]['this_year'][$i - 1] as $value) {
                                                if (!empty($value['task_maps'][$key])) {
                                                    foreach ($value['task_maps'][$key] as $item) {
                                                        $result_this_year += $item['result'] ?? 0;
                                                        $kpi_this_year += $item['kpi'] ?? 0;
                                                    }
                                                }
                                            }
                                        @endphp
                                        {{ $kpi_this_year !== 0 ? round(($result_this_year / $kpi_this_year) * 100, 2) : 0 }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                            @endfor
                        </tr>
                        <tr>
                            <td>
                                {{ $data['year_compare'] }}
                            </td>
                            @for ($i = 1; $i <= 12; $i++)
                                <td>
                                    @if (!empty($data['compare'][$info['id']]['last_year'][$i - 1]))
                                        @php
                                            $result_last_year = 0;
                                            $count_last_year = 0;
                                            foreach ($data['compare'][$info['id']]['last_year'][$i - 1] as $value) {
                                                if (!empty($value['task_maps'][$key])) {
                                                    foreach ($value['task_maps'][$key] as $item) {
                                                        $result_last_year += $item['result'] ?? 0;
                                                        $count_last_year++;
                                                    }
                                                }
                                            }
                                        @endphp
                                        {{ $count_last_year !== 0 ? round(($result_last_year / $count_last_year) * 100, 2) : 0 }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    </table>
                @endforeach
            @endforeach
        @endforeach
    @endif

    <br />
    <p style="font-weight:bold;">C. Các ý kiến khác</p>
    <p style="font-weight:bold;">D. Kết luận</p>
    <input type="checkbox" name="" id=""> <label for="">Đồng ý</label><br>
    <input type="checkbox" name="" id=""> <label for="">Không đồng ý</label>
    <div class="col10">
        <div class="col3" style="text-align: center">
            <p style="font-weight:bold;"> ĐẠI DIỆN BÊN A
                <br>{{ $data['customer']['representative'] ?? $data['customer']['name'] }} –
                {{ $data['branch']['name'] ?? '' }}
            </p>
            <p style="font-style: italic">(Ký và ghi rõ họ tên)</p>
        </div>
        <div class="col4">
            &emsp;
        </div>
        <div class="col3" style="text-align: center">
            <p style="font-weight:bold;"> ĐẠI DIỆN BÊN B
                <br>CÔNG TY TNHH DỊCH VỤ PESTKIL VIỆT NAM – PVSC
            </p>
            <p style="font-style: italic">(Ký và ghi rõ họ tên)</p>
            <div style="">{{ $data['creator']['staff']['name'] ?? '' }}</div>
        </div>
    </div>
</body>

</html>
