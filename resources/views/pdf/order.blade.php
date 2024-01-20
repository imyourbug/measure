<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Convenience Store Order</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 15px;
            line-height: normal;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid black;
        }

        .order-details {
            margin-bottom: 20px;
            text-align: center;
            /* line-height: 5px; */
        }

        .qr-image {
            position: fixed;
            bottom: 20px;
            left: 20px;
        }

        table th,
        td,
        p {
            border: none;
            word-break: break-word;
            white-space: normal;
        }
    </style>
</head>

<body>

    <div class="order-details">
        <img src="{{ public_path('/images/logo.png') }}" alt="" style="width:150px; height:100px">
        <br />{{ $data['market_name'] }}
        <br />Ma so thue: 0305781598
        <br />Dia diem ban: {{ $data['address'] }}
        <br />DT: {{ $data['phone'] }} Hotline: 19008198
        <br />Email: {{ $data['mail'] }}
        <br />Website: a.com.vn
        <br />
        <strong>PHIEU TINH TIEN</strong><br />
        Don hang sieu thi
        <br />Ma CQT: {{ $data['cqt'] }}
    </div>
    <table style="width: 100%; line-height: 5px;">
        <tr>
            <td>Quay: {{ $data['aisle'] }}</td>
            <td style="text-align: right">Ngay: {{ date('m-d-Y H:i:s', strtotime($data['created_at'])) }}</td>
        </tr>
        <tr>
            <td>NV: {{ $data['staff_id'] }}-{{ $data['staff_name'] }}</td>
            <td style="text-align: right">So HD: {{ $data['order_no'] }}</td>
        </tr>
    </table>
    <hr style="border-top: 3px dashed black; border-bottom:none;" />
    <table style="line-height: 10px;width:100%">
        <tbody>
            @foreach ($data['products'] as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    @if ($product['vat'] != 0)
                        <td>VAT{{ $product['vat'] }}%</td>
                    @endif
                    <td>{{ $product['quantity'] }}</td>
                    <td>{{ number_format($product['price'], '0', '.') }} d </td>
                    <td>{{ number_format((int) $product['price'] * (int) $product['quantity'], '0', '.') }}d
                    </td>
                    {{-- <td>Gia goc:&emsp13;{{ number_format($product['price'], '0', '.') }} d </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr style="border-top: 3px dashed black; border-bottom:none;" />
    <table style="width: 100%;line-height: 5px;">
        <tr>
            <td>Tong so luong hang:</td>
            <td style="text-align: right">41</td>
        </tr>
        <tr>
            <td>Tong tien:</td>
            <td style="text-align: right">200 d</td>
        </tr>
        <tr>
            <td>Phuong thuc thanh toan:</td>
            <td style="text-align: right"></td>
        </tr>
        <tr>
            <td>Phieu mua hang khong VAT:</td>
            <td style="text-align: right">41</td>
        </tr>
        <tr>
            <td>Tien mat:</td>
            <td style="text-align: right">28000 d</td>
        </tr>
        <tr>
            <td>Bao gom thue GTGT 10%:</td>
            <td style="text-align: right">28000 d</td>
        </tr>
    </table>
    <hr style="border-top: 3px dashed black; border-bottom:none;width:180px" />
    <div style="text-align: center;line-height: 5px;">
        <p style="">Cam on quy khach - Hen gap lai!</p>
        <img style=";width:400px;height:60px" src="{{ public_path('/images/barcode.png') }}" />
        <p><strong style="font-size:20px">{{ $data['barcode'] }}</strong></p>
    </div>
    <p>Ma GD: {{ $data['transaction_code'] }}</p>
    <hr
        style="height:5px; border-top:2px solid black;
    border-bottom:2px solid black;border-left:none;border-right:none;width:400px" />
    <hr style="border-top: 3px dashed black; border-bottom:none;" />
    <table style="width: 100%;line-height: 15px;">
        <tr>
            <td style="text-align: center;width: 30%">
                <img style="width:170px;height:170px;border: 3px solid black"
                    src="{{ public_path('/images/qr.png') }}" />
                <div class="" style="margin-top:10px;padding:5px 0px;width:170px;border: 3px solid black">
                    Ma xac nhan:<br /><strong>dTk9T1</strong>
                </div>
            </td>
            <td style="width: 70%;">
                <p style="">De cap nhat thong tin hoa don, quy khach quet ma QR.</p>
                <p style="">Hoac truy cap website: https://hddt.saigoncoop.com.vn</p>
                <p style="font-style:italic"><span style="text-decoration: underline">Luu y:</span> Thuc hien cap nhat
                    thong tin xuat hoa don
                    trong vong <strong>120 phut</strong> ke tu luc ket thuc mua hang va chi ap dung trong
                    ngay <strong>(truoc 22h00)</strong>.</p>
                <p style="font-style:italic">** Chung toi tu choi chiu trach nhiem trong truong hop KH cap nhat thong
                    tin xuat hoa don khong dung.</p>
                <p style="font-style:italic">** Quy khach lien he quay dich vu KH khi can duoc ho tro them.</p>
                <p style="font-style:italic">** VUI LONG GIU LAI PHIEU TINH TIEN NAY CAN THAN.</p>
            </td>
        </tr>
    </table>
    <hr style="border-top: 3px dashed black; border-bottom:none;" />
</body>

</html>
