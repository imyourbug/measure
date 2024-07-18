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
    @include('pdf.header', ['data' => $data])
    {{-- body --}}
    <div class="" style="text-align: center">
        <p style="font-size: 14px;font-weight:bold;">{{ $data['file_name'] }}</p>
        <p style="font-style:italic">V/v: {{ $data['contract']['name'] ?? '' }} năm {{ date('Y') }}</p>
    </div>
    <h3>A. Thành phần tham gia nghiệm thu</h3>
    <h3>BÊN A:
        {{ $data['customer']['name'] ?? '' }}{{ !empty($data['branch']['name']) ? ' - ' . $data['branch']['name'] : '' }}
    </h3>
    <p style="margin-left: 50px">Đại diện: Ông ( bà ) : {{ $data['branch']['manager'] ?? '' }} Chức vụ :
        {{ $data['customer']['position'] ?? '' }}</p>
    <p style="">Chi tiết địa chỉ: {{ $data['branch']['address'] ?? ($data['customer']['address'] ?? '') }} </p>
    <h3>BÊN B: {{ $data['setting']['company-name'] ?? '' }}</h3>
    <p style="margin-left: 50px">Đại diện: Ông ( bà ) :{{ $data['creator']['name'] ?? '' }} Chức vụ
        :{{ $data['creator']['position'] ?? '' }}</p>
    <div class="" style="text-align: left">
        <p style="font-style:italic">Ngày: ___/_____/_______________</p>
    </div>
    @if (!empty($data['tasks']))
        @foreach ($data['tasks'] as $info)
            @if ($info['id'] == $data['task_id'])
                <p style="font-weight:bold;">{{ $info['type']['parent']['name'] ?? '' }} -
                    {{ $info['type']['name'] ?? '' }}
                </p>
                <table class="tbl-plan tbl-staff" cellspacing="0">
                    <tbody>
                        <tr>
                            <td colspan="4">Nhân sự</td>
                            <td colspan="2">Thời gian thực hiện</td>
                            <td rowspan="2" style="width: 60px">Xác nhận (Yes/No)</td>
                        </tr>
                        <tr>
                            <td>Mã NS</td>
                            <td>Tên NS</td>
                            <td>CCCD</td>
                            <td>Số điện thoại</td>
                            <td>Giờ vào</td>
                            <td>Giờ ra</td>
                        </tr>
                        @foreach ($info['setting_task_staffs'] as $staff)
                            <tr>
                                @php
                                    $staffId = $staff['staff']['id'] ?? 0;
                                @endphp
                                <td>{{ 'NV' . ($staffId < 10 ? '0' . $staffId : $staffId) }}</td>
                                <td>{{ $staff['staff']['name'] ?? '' }}</td>
                                <td>{{ $staff['staff']['tel'] ?? '' }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <table class="tbl-plan tbl-chemistry" cellspacing="0">
                    <tbody>
                        <tr>
                            <td colspan="4">Hóa chất/Vật tư</td>
                            <td colspan="4">Số lượng sử dụng</td>
                            <td rowspan="2" style="width: 60px">Xác nhận (Yes/No)</td>
                        </tr>
                        <tr>
                            <td>Mã HC</td>
                            <td>Tên HC</td>
                            <td>Số đăng ký</td>
                            <td>Nhà cung cấp</td>
                            <td>Mang vào</td>
                            <td>Mang ra</td>
                            <td>ĐVT</td>
                            <td>Số lượng</td>
                        </tr>
                        @foreach ($info['setting_task_chemistries'] as $chemistry)
                            <tr>
                                <td>{{ $chemistry['chemistry']['code'] ?? '' }}</td>
                                <td>{{ $chemistry['chemistry']['name'] ?? '' }}</td>
                                <td>{{ $chemistry['chemistry']['number_register'] ?? '' }}</td>
                                <td>{{ $chemistry['chemistry']['supplier'] ?? '' }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <table class="tbl-plan tbl-item" cellspacing="0">
                    <tbody>
                        <tr>
                            <td colspan="4">Vật tư/Thiết bị</td>
                            <td colspan="4">Vật tư và thiết bị sử dụng</td>
                            <td rowspan="2" style="width: 60px">Xác nhận (Yes/No)</td>
                        </tr>
                        <tr>
                            <td>Mã VT</td>
                            <td>Tên VT</td>
                            <td>Số đăng ký</td>
                            <td>Nhà cung cấp</td>
                            <td>Mang vào</td>
                            <td>Mang ra</td>
                            <td>ĐVT</td>
                            <td>Số lượng</td>
                        </tr>
                        @foreach ($info['setting_task_items'] as $item)
                            <tr>
                                @php
                                    $itemId = $item['item']['id'] ?? 0;
                                @endphp
                                <td>{{ 'VT' . ($itemId < 10 ? '0' . $itemId : $itemId) }}</td>
                                <td>{{ $item['item']['name'] ?? '' }}</td>
                                <td>{{ $item['item']['number_register'] ?? '' }}</td>
                                <td>{{ $chemistry['chemistry']['supplier'] ?? '' }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <table class="tbl-plan tbl-solution" cellspacing="0">
                    <tbody>
                        <tr>
                            <td colspan="3">Phương pháp thực hiện</td>
                            <td rowspan="2" style="width: 60px">Xác nhận (Yes/No)</td>
                        </tr>
                        <tr>
                            <td>Mã PP</td>
                            <td>Tên PP</td>
                            <td>Mô tả</td>
                        </tr>
                        @foreach ($info['setting_task_solutions'] as $solution)
                            <tr>
                                @php
                                    $solutionId = $solution['solution']['id'] ?? 0;
                                @endphp
                                <td>{{ 'PP' . ($solutionId < 10 ? '0' . $solutionId : $solutionId) }}</td>
                                <td>{{ $solution['solution']['name'] ?? '' }}</td>
                                <td>{{ $solution['solution']['description'] ?? '' }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <div class="" style="">
                    Khuyến nghị khách hàng: {!! $info['suggestion'] ?? '' !!}
                    <br>Lưu ý: {!! $info['notice'] ?? '' !!}
                </div>
                @foreach ($info['group_details'] as $areas)
                    @foreach ($areas as $key => $tasks)
                        @php
                            // dd($key, $tasks);
                        @endphp
                        <p>Chi tiết: Khu vực: {{ $key }} – Phạm vi:
                            {{ $tasks[array_key_first($tasks)]['round'] ?? '' }} - SL: {{ count($tasks) }}</p>
                        <table class="tbl-plan tbl-solution" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>Chỉ tiêu</td>
                                    <td colspan="{{ count($tasks) }}">Mã sơ đồ</td>
                                </tr>
                                <tr>
                                    <td>ĐVT</td>
                                    @foreach ($tasks as $task)
                                        <td>{{ $task['code'] ?? '' }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Số liệu</td>
                                    @foreach ($tasks as $task)
                                        {{-- <td>{{ $task['result'] ?? '' }}</td> --}}
                                        <td></td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        <br />
                    @endforeach
                @endforeach
                <br />
                <table class="tbl-last tbl-plan" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="width: 70px;height:70px;text-align:center">Kết quả</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width: 70px;height:70px;text-align:center">Ghi chú</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                {{-- <div class="" style="">
                Kết quả:______________________________________________________
                <br>Ghi chú: {!! $info['note'] ?? '' !!}
            </div> --}}
                <br /> <br />
            @endif
        @endforeach
    @endif
    <br />
    <div class="col10">
        <div class="col7">
            &emsp;
        </div>
        <div class="col3" style="text-align: right">
            <p> <span style="font-weight:bold;">{{ $data['setting']['company-name'] ?? '' }}</p>
            <p> <span style="font-weight:bold;">PVSC</p>
            <div style="">{{ $data['creator']['name'] ?? '' }}</div>
        </div>
    </div>
</body>

</html>
