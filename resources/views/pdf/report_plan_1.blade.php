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
    {{-- <header>
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
    </header> --}}
    <div class="" style="text-align: center">
        <p style="font-size: 14px;font-weight:bold;">{{ $data['file_name'] }}</p>
        <p style="font-style:italic">V/v: {{ $data['contract']['name'] ?? '' }} tháng {{ $data['month'] ?? '' }} năm
            {{ $data['year'] ?? '' }}</p>
        <p style="font-style:italic">Hợp đồng số {{ $data['contract']['id'] ?? '' }} ký ngày
            {{ \Illuminate\Support\Carbon::parse($data['contract']['created_at'])->format('d-m-Y') }}</p>
    </div>
    @if (!empty($data['tasks']))
        @foreach ($data['tasks'] as $info)
            <p style="font-weight:bold;">{{ $info['type']['parent']['name'] ?? '' }} - {{ $info['type']['name'] ?? '' }}
            </p>
            <table class="tbl-plan" cellspacing="0">
                <tbody>
                    @php
                        $taskMaps = [];
                        $taskStaff = [];
                        $taskChemistries = [];
                        $taskItems = [];
                        $taskSolutions = [];
                        foreach ($info['details'] as $task) {
                            $date = explode('-', $task['plan_date']);
                            if ($date[0] == $data['year'] && $date[1] == $data['month']) {
                                count($task['task_maps']) === 0 ?: array_push($taskMaps, ...$task['task_maps']);
                                count($task['task_staffs']) === 0 ?: array_push($taskStaff, ...$task['task_staffs']);
                                count($task['task_chemitries']) === 0 ?:
                                array_push($taskChemistries, ...$task['task_chemitries']);
                                count($task['task_items']) === 0 ?: array_push($taskItems, ...$task['task_items']);
                                count($task['task_solutions']) === 0 ?:
                                array_push($taskSolutions, ...$task['task_solutions']);
                            }
                        }
                    @endphp
                    <tr>
                        <th style="width:50px">STT</th>
                        <th style="width:150px">Hạng mục</th>
                        <th>Thông tin</th>
                    </tr>
                    <tr>
                        <td>01</td>
                        <td>Sơ đồ</td>
                        <td>
                            @foreach ($taskMaps as $taskMap)
                                {{ $taskMap['target'] ?? '' }} - {{ $taskMap['area'] ?? '' }} -
                                {{ $taskMap['round'] ?? '' }}
                                <br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>02</td>
                        <td>Nhân sự</td>
                        <td>
                            @foreach ($taskStaff as $staff)
                                {{ 'NV' . $staff['user']['staff']['id'] ?? '' }} -
                                {{ $staff['user']['staff']['name'] ?? '' }} -
                                {{ $staff['user']['staff']['identification'] ?? '' }} -
                                {{ $staff['user']['staff']['tel'] ?? '' }}
                                <br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>03</td>
                        <td>Thuốc/Hóa chất</td>
                        <td>
                            @foreach ($taskChemistries as $taskChemistry)
                                {{ $taskChemistry['chemistry']['id'] ?? '' }} -
                                {{ $taskChemistry['chemistry']['name'] ?? '' }} -
                                {{ $taskChemistry['chemistry']['number_regist'] ?? '' }}
                                <br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>04</td>
                        <td>Vật tư/Thiết bị</td>
                        <td>
                            @foreach ($taskItems as $taskItem)
                                {{ $taskItem['item']['id'] ?? '' }} -
                                {{ $taskItem['item']['name'] ?? '' }} -
                                {{ $taskItem['item']['target'] ?? '' }} -
                                {{ $taskItem['item']['supplier'] ?? '' }}
                                <br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>05</td>
                        <td>Phương pháp thực hiện</td>
                        <td>
                            @foreach ($taskSolutions as $taskSolution)
                                {{ $taskSolution['solution']['id'] ?? '' }} -
                                {{ $taskSolution['solution']['name'] ?? '' }} -
                                {{ $taskSolution['solution']['target'] ?? '' }}
                                <br>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <br />
            <div class="" style="margin-left: 20px">
                <p>1 - Khuyến nghị</p>
                <p>2 - Lưu ý</p>
            </div>
        @endforeach
    @endif
    <br />
    <div class="col10">
        <div class="col7">
            <p style="font-weight:bold;text-decoration: underline">THÔNG TIN LIÊN HỆ</p>
            <p style="font-weight:bold;">Trung tâm CSKH PESTKIL VIỆT NAM</p>
            <table>
                <tbody>
                    <tr>
                        <td><img src="{{ public_path('images/building.png') }}" width="20px" height="20px"
                                alt="" /></td>
                        <td>T118 Lô đất L2 khu 31 Ha, Trâu Quỳ - Gia Lâm - HN</td>
                    </tr>
                    <tr>
                        <td><img src="{{ public_path('images/tel.png') }}" width="20px" height="20px"
                                alt="" />
                        </td>
                        <td>0961063486 – 0838 094 888</td>
                    </tr>
                    <tr>
                        <td><img src="{{ public_path('images/email.png') }}" width="20px" height="20px"
                                alt="" /></td>
                        <td>Cskh@pestkil.com.vn </td>
                    </tr>
                    <tr>
                        <td><img src="{{ public_path('images/fb.png') }}" width="20px" height="20px"
                                alt="" />
                        </td>
                        <td>Facebook: </td>
                    </tr>
                    <tr>
                        <td><img src="{{ public_path('images/down.png') }}" width="20px" height="20px"
                                alt="" />
                        </td>
                        <td>Tải ứng dụng CSKH trên IOS và Android</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col3" style="text-align: right">
            <p> <span style="font-weight:bold;">CÔNG TY TNHH DỊCH VỤ PESTKIL VIỆT NAM</p>
            <p> <span style="font-weight:bold;">PVSC</p>
            <div style="">{{ $data['creator']['staff']['name'] ?? '' }}</div>
        </div>
    </div>
</body>

</html>
