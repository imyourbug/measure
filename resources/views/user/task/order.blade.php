@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
    <script type="text/javascript">
        class Product {
            id;
            name;
            quantity;
            price;
            vat;
            constructor(id, name, quantity, price, vat) {
                this.id = id;
                this.name = name;
                this.quantity = quantity;
                this.price = price;
                this.vat = vat;
            }
            setName(name) {
                this.name = name;
            }
            setPrice(price) {
                this.price = price;
            }
            setQuantity(quantity) {
                this.quantity = quantity;
            }
            setVat(vat) {
                this.vat = vat;
            }
        }
        var products = [{
            id: 1,
            name: 'Bánh mì',
            quantity: 12,
            price: 120000,
            vat: 8,
        }];

        function getID() {
            if (products.length == 0) {
                return 1;
            }
            return products[products.length - 1].id + 1;
        }

        function reload() {
            let html = '';
            products.forEach(e => {
                html += `<tr>
                            <td>${e.name}</td>
                            <td>${e.quantity}</td>
                            <td>${e.price}</td>
                            <td>${e.vat}</td>
                            <td>
                                <button class="btn btn-info btn-edit" data-toggle="modal"
                                        data-target="#modal" data-id="${e.id}" onclick="edit('${e.id}')">Sửa</button>
                                <button class="btn btn-danger btn-delete" data-id="${e.id}" onclick="deleteProduct('${e.id}')">Xóa</button>
                            </td>
                        </tr>`;
            });
            $('.content-table').html('');
            $('.content-table').html(html);
            //
            reset();
        }
        reload();

        function validate(className) {
            let val = $('.' + className).val();
            return val == undefined || val == null || val == '';
        }

        function reset() {
            $('.name').val('');
            $('.quantity').val('');
            $('.price').val('');
            $('.vat').val('');
        }

        $('.btn-export').on('click', function() {
            if (products.length == 0) {
                alert('Vui lòng thêm sản phẩm')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('tasks.export') }}',
                    data: {
                        products: products,
                        market_name: $('.market_name').val(),
                        address: $('.address').val(),
                        phone: $('.phone').val(),
                        mail: $('.mail').val(),
                        created_at: $('.created_at').val(),
                        cqt: $('.cqt').val(),
                        aisle: $('.aisle').val(),
                        staff_id: $('.staff_id').val(),
                        staff_name: $('.staff_name').val(),
                        order_no: $('.order_no').val(),
                        transaction_code: $('.transaction_code').val(),
                        barcode: $('.barcode').val(),
                    },
                    success: function(response) {
                        if (response.status == 0) {
                            var url = response.url;
                            var filename = response.filename;
                            if ($('a[class*="download"]').length > 0) {
                                $('.dowload').attr({
                                    href: url,
                                    download: filename,
                                });
                            } else {
                                $('.export').append(`
                            <a class="download" href="${url}" download="${filename}">Tải xuống</a>
                            `);
                            }
                        }
                    },
                })
            }
        });
        $('.btn-add').on('click', function() {
            if (validate('name') || validate('quantity') || validate('price')) {
                alert('Vui lòng điền đầy đủ thông tin');
            } else {
                let id = getID();
                let product = new Product(
                    id,
                    $('.name').val(),
                    $('.quantity').val(),
                    $('.price').val(),
                    $('.vat').val() ?? 0,
                );
                products.push(product);
                reload();
            }
        });
        $('.btn-save').on('click', function() {
            if (validate('edit-name') || validate('edit-quantity') || validate('edit-price')) {
                alert('Vui lòng điền đầy đủ thông tin');
            } else {
                products.forEach((e) => {
                    if (e.id == $('.edit-id').val()) {
                        e.name = $('.edit-name').val();
                        e.price = $('.edit-price').val();
                        e.quantity = $('.edit-quantity').val();
                        e.vat = $('.edit-vat').val();
                    };
                })
                reload();
            }
        });

        function edit(id) {
            let product = null;
            products.forEach((e) => {
                if (e.id == id) {
                    product = e;
                };
            })
            $('.edit-id').val(product.id);
            $('.edit-name').val(product.name);
            $('.edit-quantity').val(product.quantity);
            $('.edit-price').val(product.price);
            $('.edit-vat').val(product.vat);
        }

        function deleteProduct(id) {
            if (confirm('Xác nhận xóa?')) {
                products = products.filter((e) => e.id != id);
            }
            reload();
        }
    </script>
@endpush
@section('content')
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <label for="">Tên sản phẩm</label>
                    <input class="form-control name" type="text" placeholder="Nhập tên sản phẩm..." required>
                </div>
                <div class="form-group">
                    <label for="">Số lượng</label>
                    <input class="form-control quantity" type="number" min="1" value="1"
                        placeholder="Nhập số lượng sản phẩm..." required>
                </div>
                <div class="form-group">
                    <label for="">Giá</label>
                    <input class="form-control price" type="text" placeholder="Nhập giá sản phẩm..." required>
                </div>
                <div class="form-group">
                    <label for="">VAT</label>
                    <input class="form-control vat" type="number" placeholder="Nhập VAT...">
                </div>
                <div class="export" style="d-flex text-end">
                    <button class="btn btn-warning btn-add">Lưu</button>
                    <button type="button" class="btn btn-success btn-export">
                        Xuất hóa đơn
                    </button>
                </div>
                <h5 class="mt-4">Thông tin khác</h5>
                <div class="form-group">
                    <label for="">Tên siêu thị</label>
                    <input class="form-control market_name" type="text" placeholder="Nhập tên siêu thị..." required>
                </div>
                <div class="form-group">
                    <label for="">Địa chỉ</label>
                    <input class="form-control address" type="text" placeholder="Nhập địa chỉ..." required>
                </div>
                <div class="form-group">
                    <label for="">Số điện thoại</label>
                    <input class="form-control phone" type="text" placeholder="Nhập số điện thoại..." required>
                </div>
                <div class="form-group">
                    <label for="">Mail</label>
                    <input class="form-control mail" type="text" placeholder="Nhập mail..." required>
                </div>
                <div class="form-group">
                    <label for="">Ngày tạo</label>
                    <input class="form-control created_at" type="datetime-local" required>
                </div>
                <div class="form-group">
                    <label for="">Mã nhân viên</label>
                    <input class="form-control staff_id" type="text" placeholder="Nhập mã nhân viên..." required>
                </div>
                <div class="form-group">
                    <label for="">Tên nhân viên</label>
                    <input class="form-control staff_name" type="text" placeholder="Nhập tên nhân viên..." required>
                </div>
                <div class="form-group">
                    <label for="">Số hóa đơn</label>
                    <input class="form-control order_no" type="text" placeholder="Nhập số hóa đơn..." required>
                </div>
                <div class="form-group">
                    <label for="">Mã giao dịch</label>
                    <input class="form-control transaction_code" type="text" placeholder="Nhập mã giao dịch..." required>
                </div>
                <div class="form-group">
                    <label for="">Quầy</label>
                    <input class="form-control aisle" type="text" placeholder="Nhập quầy..." required>
                </div>
                <div class="form-group">
                    <label for="">CQT</label>
                    <input class="form-control cqt" type="text" placeholder="Nhập CQT..." required>
                </div>
                <div class="form-group">
                    <label for="">Barcode</label>
                    <input class="form-control barcode" type="text" placeholder="Nhập barcode..." required>
                </div>

            </div>
            <div class="col-lg-6 col-md-12">
                <table class="table-product" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>VAT</th>
                            <th>Thao tác</th>
                        </tr>
                    <tbody class="content-table">
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="modal" style="display: none; padding-right: 17px;" data-id="123" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cập nhật nhiệm vụ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Tên sản phẩm</label>
                        <input class="form-control edit-name" type="text" placeholder="Nhập tên sản phẩm..." required>
                    </div>
                    <div class="form-group">
                        <label for="">Số lượng</label>
                        <input class="form-control edit-quantity" type="number" min="1" value="1"
                            placeholder="Nhập số lượng sản phẩm..." required>
                    </div>
                    <div class="form-group">
                        <label for="">Giá</label>
                        <input class="form-control edit-price" type="text" placeholder="Nhập giá sản phẩm..." required>
                    </div>
                    <div class="form-group">
                        <label for="">VAT</label>
                        <input class="form-control edit-vat" type="number" placeholder="Nhập VAT...">
                    </div>
                    <input type="hidden" class="edit-id">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" type="submit" class="btn btn-primary btn-save">Lưu</button>
                </div>
            </div>
        </div>
    </div>
@endsection
