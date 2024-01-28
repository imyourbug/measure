<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KẾ HOẠCH DỊCH VỤ</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .tbl-plan {
            border-collapse: collapse;

        }

        .tbl-plan td,
        .tbl-plan th {
            border: 1px solid black;
            padding: 0;
        }
    </style>
</head>

<body>
    <table>
        <tbody>
            <tr>
                <td rowspan="3">
                    <img width="100px" height="100px" src="{{ public_path('images/logo.png') }}" alt="" />
                </td>
                <td style="text-align:center">
                    Công ty
                </td>
                <td style="text-align:center">
                    UNIBEN Hưng Yên
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    Địa chỉ
                </td>
                <td style="text-align:center">
                    Nhà máy Hưng Yên
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    Số hợp đồng
                </td>
                <td style="text-align:center">
                    01/01/2021 UNIBEN_PETSKIL
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    Tháng {{ $data['month'] }} Năm {{ $data['year'] }}
                </td>
                <td colspan="2">
                    BÁO CÁO TÓM TẮT DỊCH VỤ VÀ PHÂN TÍCH KỸ THUẬT
                </td>
            </tr>
        </tbody>
    </table>
    <p style="color:rgb(13, 102, 235)">Kính gửi (Anh/chị) Mr.Dũng</p>
    <table>
        <tbody>
            <tr>
                <td style="font-weight:bold;">Công ty</td>
                <td>Tên công ty</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">Chi nhánh</td>
                <td>Nhà máy Hưng Yên</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">Địa chỉ</td>
                <td style="color:rgb(13, 102, 235);font-style:italic">KCN Phố Nối A</td>
            </tr>
        </tbody>
    </table>
    <p style="font-style:italic;text-align:center">Công ty dịch vụ Pestkil Việt Nam gửi kế hoạch tháng như sau:</p>
    <h3 style="text-decoration: underline; color:rgb(13, 102, 235)">Kiểm soát chuột định kỳ và ĐVGH</h3>
    <p style="font-weight: bold;text-decoration: underline;">Nhân viên kỹ thuật</p>

    <table style="font-style:italic">
        <thead>
            <th>Code</th>
            <th>Tên kỹ thuật viên</th>
            <th>Điện thoại</th>
            <th>Chứng minh thư</th>
            <th>Chức vụ</th>
        </thead>
        <tbody>
            <tr>
                <td>Code</td>
                <td>Tên kỹ tduật viên</td>
                <td>Điện tdoại</td>
                <td>Chứng minh thư</td>
                <td>Chức vụ</td>
            </tr>
        </tbody>
    </table>
    <table class="tbl-plan" style="float:right">
        <thead>
            <th>Ngày kế hoạch</th>
            <th>Thứ</th>
            <th>Giờ vào</th>
            <th>Giờ ra</th>
        </thead>
        <tbody>
            <tr>
                <td>Ngày kế hoạch</td>
                <td>Thứ</td>
                <td>Giờ vào</td>
                <td>Giờ ra</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
