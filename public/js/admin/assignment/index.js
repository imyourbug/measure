//select
$(".select-contract").on("change", function () {
    let id_contract = $('#contract_id').find(":selected").val();;
    console.log(id_contract, $(this).data("url"));
    if (id_contract) {
        $.ajax({
            type: "GET",
            url: $(this).data("url") + "?id=" + id_contract,
            success: function (response) {
                $(".select-type").empty();
                let html = "";
                response.data.forEach((task_type) => {
                    switch (task_type) {
                        case 0:
                            html += `<option value="0">Đo điện</option>`;
                            break;
                        case 1:
                            html += `<option value="1">Đo nước</option>`;
                            break;
                        case 2:
                            html += `<option value="2">Đo không khí</option>`;
                            break;
                    }
                });
                console.log(html);
                $(".select-type").append(html);
            },
        });
    } else {
        $(".select-type").empty();
    }
});

