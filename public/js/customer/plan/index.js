var dataTable = null;
$(document).ready(function () {
    dataTable = $("#table").DataTable({
        ajax: {
            url: `/api/contracts/getAll?customer_id=${$('#customer_id').val()}`,
            dataSrc: "contracts",
        },
        columns: [{
            data: function (d) {
                return `${$('#select-month').val() == 0 ? 'Tất cả' : $('#select-month').val()}`;
            },
        }, {
            data: function (d) {
                return `${d.customer.name}`;
            },
        },
        {
            data: function (d) {
                return `${d.branch ? d.branch.name : ""}`;
            },
        },
        {
            data: function (d) {
                return `${d.branch ? (d.branch.address || "") : ""}`;
            },
        },

        {
            data: function (d) {
                return `<a class="btn btn-success btn-sm" style="padding: 4px 15px"
                            href='/customer/contracts/detail/${d.id}'>
                            <i class="fa-solid fa-info"></i>
                        </a>`;
            },
        },
        ],
    });
})
$(document).on("change", "#select-month", function () {
    let requestUrl = `/api/contracts/getAll?customer_id=${$('#customer_id').val()}&month=${$(this).val()}`;
    dataTable.ajax.url(requestUrl).load();
});