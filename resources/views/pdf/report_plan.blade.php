<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KẾ HOẠCH DỊCH VỤ</title>
    <style>
        /* @font-face {
            font-family: 'Times New Roman';
            src: url('/fonts/times-new-roman.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        } */

        body {
            font-family: DejaVu Sans, sans-serif;
            /* font-family:'Times New Roman', Times, serif; */
        }

        .tbl-plan {
            border-collapse: collapse;

        }

        .tbl-plan td,
        .tbl-plan th {
            border: 1px solid black;
            padding: 0px 60px 0px 0px;
        }
    </style>
</head>

<body>
    <table>
        <tbody>
            <tr>
                <td rowspan="2">
                    <img width="200px" height="100px" src="{{ public_path('images/logo.png') }}" alt="" />
                </td>
                <td style="text-align:center">
                    <h1>KẾ HOẠCH DỊCH VỤ</h1>
                </td>
            </tr>
            <tr>
                <td>Tháng {{ $data['month'] }} Năm {{ $data['year'] }}</td>
            </tr>
        </tbody>
    </table>
    <p style="color:rgb(13, 102, 235)">Kính gửi (Anh/chị) {{ $data['branch']['manager'] ?? '' }}</p>
    <table>
        <tbody>
            <tr>
                <td style="font-weight:bold;">Công ty</td>
                <td>{{ $data['customer']['name'] ?? '' }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">Chi nhánh</td>
                <td>{{ $data['branch']['name'] ?? '' }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">Địa chỉ</td>
                <td style="color:rgb(13, 102, 235);font-style:italic">{{ $data['branch']['address'] ?? '' }}</td>
            </tr>
        </tbody>
    </table>
    <p style="font-style:italic;text-align:center">Công ty dịch vụ Petskil Việt Nam gửi kế hoạch tháng như sau:</p>
    @if (!empty($data['tasks']))
        @foreach ($data['tasks'] as $info)
            <h3 style="text-decoration: underline; color:rgb(13, 102, 235)">{{ $info['type']['name'] }}</h3>
            <p style="font-weight: bold;text-decoration: underline;">Nhân viên kỹ thuật</p>
            <table style="font-style:italic;width:100%">
                <thead style="text-align: left">
                    <th>Code</th>
                    <th>Tên kỹ thuật viên</th>
                    <th>Điện thoại</th>
                    <th>Chứng minh thư</th>
                    <th>Chức vụ</th>
                </thead>
                <tbody>
                    @foreach ($info['details'] as $detail)
                        @foreach ($detail['task_staffs'] as $staff)
                            <tr>
                                {{-- <td>{{$staff['code'] ?? ''}}</td> --}}
                                <td>{{ $staff['id'] > 10 ? $staff['id'] : 'NV0' . $staff['id'] }}</td>
                                <td>{{ $staff['user']['staff']['name'] ?? '' }}</td>
                                <td>{{ $staff['user']['staff']['tel'] ?? '' }}</td>
                                <td>{{ $staff['user']['staff']['identification'] ?? '' }}</td>
                                <td>{{ $staff['user']['staff']['position'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <br />
            <table class="tbl-plan" style="float:right">
                <thead>
                    <th>Ngày kế hoạch</th>
                    <th>Thứ</th>
                    <th>Giờ vào</th>
                    <th>Giờ ra</th>
                </thead>
                <tbody>
                    @foreach ($info['details'] as $task)
                        <tr>
                            <td>{{ $task['plan_date'] ?? '' }}</td>
                            <td>{{ date('l', strtotime($task['plan_date'] ?? '')) ?? '' }}</td>
                            <td>{{ $task['time_in'] ?? '' }}</td>
                            <td>{{ $task['time_out'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br /><br /><br />
        @endforeach
    @endif
    <br />
    <div class="">
        Lưu ý công việc:
        <br />
        + Thông tin Kế hoạch thực hiện và các lưu ý an toàn sức khỏe tới các bộ phận liên quan.
        <br />
        + Bố trí nhân sự hướng dẫn, giám sát và xác nhận công việc trong quá trình thực hiện.
        <br />
        + Nếu có thay đổi lịch thực hiện thì phải thông tin lại cho Pestkil Việt Nam trước 3 ngày.
        <br />
        <br />
        Liên hệ:
        <br />
        <br />
        Văn phòng: 024 6681 0229
        <br />
        Quản lý kỹ thuật: 0983 683 199
        <br />
        Kinh doanh: 0986 112 486 - 0838 094 888
        <br />
        Email: Admin@pestkil.com.vn
    </div>
    <table style="width:100%;line-height:10px">
        <tbody>
            <tr>
                <td style="width:50%"> </td>
                <td style="" colspan="2">
                    <p>Trân trọng cảm ơn Quý khách hàng</p>
                    <p style="font-weight:bold;">Công ty TNHH dịch vụ Pestkil Vietnam</p>
                </td>
            </tr>
            <tr>
                <td style="width:50%"> </td>
                <td style="">
                    Ngày lập
                </td>
                <td style="">
                    {{now()->format('d/m/Y')}}
                </td>
            </tr>
            <tr>
                <td style="width:50%"> </td>
                <td style="">
                    Lập bởi
                </td>
                <td style="">
                    <p style="font-weight:bold;">Lê Văn Khánh</p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
