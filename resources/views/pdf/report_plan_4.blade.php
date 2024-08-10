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
    {{-- header --}}
    @include('pdf.common.header', ['data' => $data])
    {{-- body --}}
    <div class="" style="text-align: center">
        <p style="font-size: 14px;font-weight:bold;">{{ $data['file_name'] }}</p>
        <p style="font-style:italic">V/v: {{ $data['contract']['name'] ?? '' }} năm {{ date('Y') }}</p>
    </div>
    <h3>A. Thành phần tham gia nghiệm thu</h3>
    <h3>BÊN A:
        {{ $data['customer']['name'] ?? '' }}{{ !empty($data['branch']['name']) ? ' - ' . $data['branch']['name'] : '' }}
    </h3>
    <p style="margin-left: 50px">Đại diện: Ông (bà):
        {{ $data['branch']['manager'] ?? ($data['customer']['manager'] ?? '') }} Chức vụ:
        {{ $data['customer']['position'] ?? '' }}</p>
    <p style="">Chi tiết địa chỉ: {{ $data['branch']['address'] ?? ($data['customer']['address'] ?? '') }} </p>
    <h3>BÊN B: {{ $data['setting']['company-name'] ?? '' }}</h3>
    <p style="margin-left: 50px">Đại diện: Ông (bà): {{ $data['creator']['name'] ?? '' }} Chức vụ:
        {{ $data['creator']['position'] ?? '' }}</p>
    <h3>B. Khối lượng hoàn thành </h3>
    @if (!empty($data['tasks']))
        @foreach ($data['tasks'] as $key => $info)
            @php
                $countDetail = !empty(count($info['details'])) ? count($info['details']) : 1;
            @endphp
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
                        <th colspan="8">Chi tiết</th>
                    </tr>
                    <tr>
                        <th>Khu vực</th>
                        <th>Phạm vi</th>
                        <th>Đối tượng</th>
                        <th>Tần suất</th>
                        <th>Biện pháp</th>
                        <th>Ghi chú</th>
                        <th>Hiện trạng</th>
                        <th>Nguyên nhân</th>
                    </tr>

                    @php
                        $positions = [];
                        $targets = [];
                        $rounds = [];
                        foreach ($info['group_details'] as $areas) {
                            foreach ($areas as $key => $tasks) {
                                foreach ($tasks as $taskMapInfo) {
                                    if (!in_array($taskMapInfo['position'], $positions)) {
                                        $positions[] = $taskMapInfo['position'] ?? '';
                                    }
                                    if (!in_array($taskMapInfo['target'], $targets)) {
                                        $targets[] = $taskMapInfo['target'] ?? '';
                                    }
                                    if (!in_array($taskMapInfo['round'], $rounds)) {
                                        $rounds[] = $taskMapInfo['round'] ?? '';
                                    }
                                }
                            }
                        }
                    @endphp
                    <tr>
                        <td>{{ 01 }}</td>
                        <td>{{ $info['type']['name'] ?? '' }}</td>
                        <td>{{ implode(',', $positions) }} </td>
                        <td>{{ implode(',', $rounds) }} </td>
                        <td>{{ implode(',', $targets) }} </td>
                        <td>{{ $info['frequence'] ?? '' }}</td>
                        <td>{{ $info['solution'] ?? '' }}</td>
                        <td>{{ $info['note'] ?? '' }}</td>
                        <td>{{ $info['status'] ?? '' }}</td>
                        <td>{{ $info['reason'] ?? '' }}</td>
                    </tr>

                </tbody>
            </table>
            <p style="">- Nhận xét: {{ $info['comment'] }}</p>
            <p style="">- Chi tiết: {{ $info['detail'] }}</p>
            @if (count($info['group_details']) > 0)
                <p style="">Báo cáo phân tích</p>
                @foreach ($info['group_details'] as $areas)
                    @foreach ($areas as $key => $tasks)
                        @php
                            $keyImage = ($info['id'] ?? '') . $key;
                        @endphp
                        <p style="font-weight: bold">Khu vực {{ $tasks[array_key_first($tasks)]['position'] ?? '' }}
                        </p>
                        @if (count($tasks) > 0)
                            <p style="">BÁO CÁO: DIỄN BIẾN THÁNG</p>
                            <p style="">Tháng {{ $data['month'] }} năm {{ $data['year'] }}</p>
                            <table class="tbl-plan">
                                <tr>
                                    <td style="width: 60px">Mã sơ đồ</td>
                                    @php
                                        $count_column = 0;
                                    @endphp
                                    @foreach ($tasks as $task_map)
                                        @php
                                            $mapCode = explode('-', $task_map['code']);
                                        @endphp
                                        @if ($mapCode[0] == $key && $count_column < $data['column'])
                                            <td>{{ $task_map['code'] ?? '' }}</td>
                                            @php
                                                $count_column++;
                                            @endphp
                                        @endif
                                    @endforeach
                                    <td style="width: 90px">
                                        Tổng:Trung bình
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ ($tasks[array_key_first($tasks)]['unit'] ?? 'Đơn vị') . ' - Tháng ' . $data['month'] . '.' . $data['year'] }}
                                    </td>
                                    @php
                                        $sum_result = 0;
                                        $count_column = 0;
                                    @endphp
                                    @foreach ($tasks as $task_map)
                                        @php
                                            $mapCode = explode('-', $task_map['code']);
                                        @endphp
                                        @if ($mapCode[0] == $key && $count_column < $data['column'])
                                            @php
                                                $count_column++;
                                                $sum_result += (int) $task_map['this_month']['result'];
                                            @endphp
                                            <td>
                                                {{ strlen($task_map['this_month']['result']) ? (int) $task_map['this_month']['result'] : 'N/A' }}
                                            </td>
                                        @endif
                                    @endforeach
                                    <td>
                                        {{ (int) ($sum_result / ($count_column ?? 1)) }}
                                    </td>
                                </tr>
                                <tr style="display: none">
                                    <td>
                                        KPI
                                    </td>
                                    @php
                                        $sum_kpi = 0;
                                        $count_kpi = 0;
                                        $count_column = 0;
                                    @endphp
                                    @foreach ($tasks as $task_map)
                                        @php
                                            $mapCode = explode('-', $task_map['code']);
                                        @endphp
                                        @if ($mapCode[0] == $key && $count_column < $data['column'])
                                            @php
                                                $sum_kpi += (int) $task_map['kpi'];
                                                $count_kpi++;
                                                $count_column++;
                                            @endphp
                                            <td>
                                                {{ strlen($task_map['kpi']) ? (int) $task_map['kpi'] : 'N/A' }}
                                            </td>
                                        @endif
                                    @endforeach
                                    <td>
                                        {{ (int) ($sum_kpi / ($count_kpi ?? 1)) }}
                                    </td>
                                </tr>
                            </table>
                        @endif
                        @if ($data['display'] && !empty($data['display_first']) && !empty($data['image_charts'][$keyImage]))
                            <p style="text-align:center">DIỄN BIẾN THÁNG</p>
                            <img src="{{ $data['image_charts'][$keyImage] }}" alt=""
                                style="margin-bottom: 20px" />
                        @endif
                        @if (!empty($data['display_third']) && !empty($data['display_year']) && !empty($data['image_annual_charts'][$keyImage]))
                            <div class="" style="margin-top: 20px">
                                <p style="">BÁO CÁO: SO SÁNH THÁNG</p>
                                <p style="">Tháng {{ $data['month'] }} năm {{ $data['year'] }} so với tháng
                                    {{ $data['month_compare'] }} năm {{ $data['year_compare'] }}</p>
                                <table class="tbl-plan">
                                    <tr>
                                        <td style="width: 100px">Mã sơ đồ</td>
                                        @php
                                            $count_column = 0;
                                        @endphp
                                        @foreach ($tasks as $task_map)
                                            @php
                                                $mapCode = explode('-', $task_map['code']);
                                            @endphp
                                            @if ($mapCode[0] == $key && $count_column < $data['column'])
                                                <td>{{ $task_map['code'] ?? '' }}</td>
                                                @php
                                                    $count_column++;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <td style="width: 90px">
                                            Tổng:Trung bình
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ ($tasks[array_key_first($tasks)]['unit'] ?? 'Đơn vị') . ' - Tháng ' . $data['month'] . '.' . $data['year'] }}
                                        </td>
                                        @php
                                            $sum_result = 0;
                                            $count_column = 0;
                                        @endphp
                                        @foreach ($tasks as $task_map)
                                            @php
                                                $mapCode = explode('-', $task_map['code']);
                                            @endphp
                                            @if ($mapCode[0] == $key && $count_column < $data['column'])
                                                <td>
                                                    {{ strlen($task_map['this_month']['result']) ? (int) $task_map['this_month']['result'] : 'N/A' }}
                                                </td>
                                                @php
                                                    $sum_result += (int) $task_map['this_month']['result'];
                                                    $count_column++;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <td>
                                            {{ (int) ($sum_result / ($count_column ?? 1)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ ($tasks[array_key_first($tasks)]['unit'] ?? 'Đơn vị') . ' - Tháng ' . $data['month_compare'] . '.' . $data['year_compare'] }}
                                        </td>
                                        @php
                                            $sum_result = 0;
                                            $count_column = 0;
                                        @endphp
                                        @foreach ($tasks as $task_map)
                                            @php
                                                $mapCode = explode('-', $task_map['code']);
                                            @endphp
                                            @if ($mapCode[0] == $key && $count_column < $data['column'])
                                                <td>
                                                    {{ strlen($task_map['last_month']['result']) ? (int) $task_map['last_month']['result'] : 'N/A' }}
                                                </td>
                                                @php
                                                    $sum_result += (int) $task_map['last_month']['result'];
                                                    $count_column++;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <td>
                                            {{ (int) ($sum_result / ($count_column ?? 1)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            KPI
                                        </td>
                                        @php
                                            $sum_kpi = 0;
                                            $count_column = 0;
                                        @endphp
                                        @foreach ($tasks as $task_map)
                                            @php
                                                $mapCode = explode('-', $task_map['code']);
                                            @endphp
                                            @if ($mapCode[0] == $key && $count_column < $data['column'])
                                                <td>
                                                    {{ strlen($task_map['this_month']['kpi']) ? (int) $task_map['this_month']['kpi'] : 'N/A' }}
                                                </td>
                                                @php
                                                    $sum_kpi += (int) $task_map['this_month']['kpi'];
                                                    $count_column++;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <td>
                                            {{ (int) ($sum_kpi / ($count_column ?? 1)) }}
                                        </td>
                                    </tr>
                                </table>
                                <p style="text-align:center">SO SÁNH THÁNG</p>
                                <img src="{{ public_path($data['image_annual_charts'][$keyImage]) }}" alt="" />
                            </div>
                        @endif
                        @if (!empty($data['display_year_compare']) && count($tasks) > 0)
                            <p style="">BÁO CÁO: DIỄN BIẾN NĂM</p>
                            <p style="">Năm {{ $data['year'] }} so với
                                {{ $data['year_compare'] }}
                            </p>
                            <table class="tbl-plan">
                                <tr>
                                    <td style="width: 60px">Năm</td>
                                    @for ($i = 1; $i <= (int) ($data['month'] ?? 0); $i++)
                                        <td>
                                            Tháng {{ $i < 10 ? '0' . $i : $i }}
                                        </td>
                                    @endfor
                                    <td style="width: 90px">Tổng:Trung bình</td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $data['year'] }}
                                    </td>
                                    @php
                                        $sum_result_this_year = 0;
                                    @endphp
                                    @for ($i = 1; $i <= (int) ($data['month'] ?? 0); $i++)
                                        <td>
                                            @php
                                                $dataThisYear =
                                                    $data['dataCompareYear'][$info['id']][$key]['this_year'][$i] ?? '';
                                            @endphp

                                            @if (!empty($dataThisYear))
                                                @php
                                                    $sum_result_this_year += $dataThisYear['result'] ?? 0;
                                                @endphp
                                                {{ (int) ($dataThisYear['result'] / ($countDetail ?? 1)) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    @endfor
                                    <td>
                                        {{ (int) ($sum_result_this_year / $data['month'] / ($countDetail ?? 1)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $data['year_compare'] }}
                                    </td>
                                    @php
                                        $sum_result_last_year = 0;
                                    @endphp
                                    @for ($i = 1; $i <= (int) ($data['month'] ?? 0); $i++)
                                        <td>
                                            @php
                                                $dataLastYear =
                                                    $data['dataCompareYear'][$info['id']][$key]['last_year'][$i] ?? '';
                                            @endphp
                                            @if (!empty($dataLastYear))
                                                @php
                                                    $sum_result_last_year += $dataLastYear['result'] ?? 0;
                                                @endphp
                                                {{ (int) ($dataLastYear['result'] / ($countDetail ?? 1)) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    @endfor
                                    <td>
                                        {{ (int) ($sum_result_last_year / $data['month'] / ($countDetail ?? 1)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        KPI
                                    </td>
                                    @php
                                        $sum_kpi_this_year = 0;
                                    @endphp
                                    @for ($i = 1; $i <= (int) ($data['month'] ?? 0); $i++)
                                        <td>
                                            @php
                                                $dataThisYear =
                                                    $data['dataCompareYear'][$info['id']][$key]['this_year'][$i] ?? '';
                                            @endphp
                                            @if (!empty($dataThisYear))
                                                @php
                                                    $sum_kpi_this_year += $dataThisYear['kpi'] ?? 0;
                                                @endphp
                                                {{ (int) ($dataThisYear['kpi'] / ($countDetail ?? 1)) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    @endfor
                                    <td>
                                        {{ (int) ($sum_kpi_this_year / $data['month'] / ($countDetail ?? 1)) }}
                                    </td>
                                </tr>
                            </table>
                        @endif

                        @if (
                            !empty($data['display_second']) &&
                                !empty($data['display_month_compare']) &&
                                !empty($data['image_trend_charts'][$keyImage]))
                            <p style="text-align:center">DIỄN BIẾN NĂM</p>
                            <img src="{{ public_path($data['image_trend_charts'][$keyImage]) }}" alt="" />
                        @endif
                    @endforeach
                @endforeach
            @endif
            <br />
            <p style="font-weight:bold;">Các ý kiến khác</p>
            {{-- <p style="font-weight:bold;">C. Các ý kiến khác</p> --}}
            @if (count($info['images']) > 0)
                <table class="tbl-plan1" cellspacing="0">
                    <tbody>
                        <tr>
                            @foreach ($info['images'] as $image)
                                <td>
                                    <img style="width: 100px; height:100px" src="{{ public_path($image['url']) }}"
                                        alt="" />
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
                <br><br>
            @endif
        @endforeach
    @endif
    <p style="font-weight:bold;">C. Kết luận</p>
    {{-- <p style="font-weight:bold;">D. Kết luận</p> --}}
    <input type="checkbox" name="" id=""> <label for="">Đồng ý</label><br>
    <input type="checkbox" name="" id=""> <label for="">Không đồng ý</label>
    <div class="col10">
        <div class="col3" style="text-align: center">
            <p style="font-weight:bold;"> ĐẠI DIỆN BÊN A
                <br>{{ $data['customer']['name'] ?? '' }}
            </p>
            <p style="font-style: italic">(Ký và ghi rõ họ tên)</p>
        </div>
        <div class="col4">
            &emsp;
        </div>
        <div class="col3" style="text-align: center">
            <p style="font-weight:bold;"> ĐẠI DIỆN BÊN B
                <br>{{ $data['setting']['company-name'] ?? '' }} – PVSC
            </p>
            <p style="font-style: italic">(Ký và ghi rõ họ tên)</p>
            <div style="">{{ $data['creator']['name'] ?? '' }}</div>
        </div>
    </div>
</body>

</html>
