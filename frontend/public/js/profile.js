$(document).ready(() => {
    $("#pet_table").DataTable({
        processing: true,
        // columnDefs: [{ width: "20%", targets: 0 }],
        info: true,
        stateSave: true,
        ajax: {
            url: "/api/get-owned-pets",
            dataSrc: function (json) {
                console.log(json.pets);
                return json.pets;
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + localStorage.getItem("token")
                );
            },
        },
        order: [0, "dec"],
        // data: data.pets,
        // columnDefs: [{ width: "20%", targets: 0 }],
        columns: [
            {
                data: null,
                render: function (data, type, JsonResultRow, row) {
                    return (
                        '<img src="' +
                        data.img_path +
                        '" class="rounded-circle"height="100px" width="100px">'
                    );
                },
            },
            { data: "pet_name" },
            { data: "age" },
            // { data: "created_at" },

            // Format created_at to {weekday}, {year}, {month}, {day}, {hour}, {minute}
            {
                data: null,
                render: function (data, type, row) {
                    var d = new Date(data.created_at);
                    return d.toLocaleDateString("en-US");
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        "<a href=#'' class='pet_edit' id='pet_edit' data-id=" +
                        data.id +
                        "><i class='fa-solid fa-pen' aria-hidden='true' style='font-size:24px' ></i></a>"
                    );
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        "<a href='#' class='pet_delete' id='pet_delete' data-id=" +
                        data.id +
                        "><i class='fa-solid fa-trash-can' aria-hidden='true' style='font-size:24px; color:red;'></a></i>"
                    );
                },
            },
        ],
    });

    $.ajax({
        url: "/api/get-owned-pets",
        type: "GET",
        processData: false, // Important!
        contentType: false,
        dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Authorization",
                "Bearer " + localStorage.getItem("token")
            );
        },
        success: function (data) {
            console.log(data.customer);
            var customer = data.customer;
            $("#user_image").attr("src", customer.img_path);
            $("#phone").text(customer.phone);
            $("#address").text(customer.addressline);
        },
    });
});
