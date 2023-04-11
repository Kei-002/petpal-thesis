$(document).ready(() => {
    toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: false,
        progressBar: false,
        positionClass: "toast-top-right",
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "slideDown",
        hideMethod: "slideUp",
    };

    var date_options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
    };

    // Fill datatable
    $("#order_table").DataTable({
        processing: true,
        info: true,
        stateSave: true,
        select: true,
        ajax: {
            url: "/api/all-orders",
            dataSrc: function (json) {
                (arrayList = []), (obj_c_processed = []);
                var g = json.orders;
                var c = json.receipts;
                for (var i in g) {
                    var obj = {
                        id: g[i].id,
                        customer_name: g[i].customer_name,
                        address: g[i].address,
                        total_purchase: g[i].total_purchase,
                        payment_status: g[i].payment_status,
                        orderlines: g[i].orderlines,
                        created_at: g[i].created_at,
                        receipt_path: g[i].receipt_path,
                        receipt_id: g[i].receipt_id,
                    };

                    for (var j in c) {
                        if (g[i].id == c[j].item_id) {
                            obj.payment_status = c[j].payment_status;
                            obj.receipt_path = c[j].receipt_path;
                            obj.address = c[j].addressline;
                            obj.total_purchase = c[j].total_purchase;
                            obj.receipt_id = c[j].id;
                            obj.customer_name = c[j].fname + " " + c[j].lname;
                            obj_c_processed[c[j].id] = true;
                        }
                    }

                    // obj.circle = obj.circle || 'no';
                    arrayList.push(obj);
                }

                for (var j in c) {
                    if (typeof obj_c_processed[c[j].id] == "undefined") {
                        arrayList.push({
                            id: c[j].id,
                            item_id: c[j].item_id,
                            customer_name: c[j].fname + " " + c[j].lname,
                            payment_status: c[j].payment_status,
                            address: c[j].addressline,
                            receipt_path: c[j].receipt_path,
                            created_at: c[j].created_at,
                        });
                    }
                }

                return arrayList;
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + localStorage.getItem("token")
                );
            },
        },
        order: [3, "asc"],
        // data: data,
        columns: [
            {
                data: "id",
            },
            { data: "customer_name" },
            {
                data: "address",
                render: function (data, type, row) {
                    return (
                        "<div class='text-wrap' style='font-size:0.8rem'>" +
                        data +
                        "</div>"
                    );
                },
            },
            {
                data: "payment_status",
                render: function (data, type, row) {
                    if (data == "Paid") {
                        return (
                            '<span class="badge rounded-pill bg-success">' +
                            data +
                            "</span>"
                        );
                    } else {
                        return (
                            '<span class="badge rounded-pill bg-danger">' +
                            data +
                            "</span>"
                        );
                    }
                },
            },
            { data: "total_purchase" },
            // {
            //     data: null,
            //     render: function (data, type, row) {
            //         return data.customer.fname + " " + data.customer.lname;
            //     },
            // },
            // { data: "created_at" },

            // Format created_at to {weekday}, {year}, {month}, {day}, {hour}, {minute}
            {
                data: null,
                render: function (data, type, row) {
                    var d = new Date(data.created_at);
                    return d.toLocaleDateString("en-US", date_options);
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    console.log(data);
                    if (data.payment_status == "Paid") {
                        return (
                            "<a href='#' class='btn bg-white btn-light mx-1px text-95 update_status disabled' id='update_status' data-id=" +
                            data.id +
                            // <i class="fa-solid fa-box-circle-check"></i>
                            "><i class='fa fa-solid fa-check' style='font-size:24px; color:green;'></i>Payment Done</a>"
                        );
                    } else {
                        return (
                            "<a href='#' class='btn bg-white btn-light mx-1px text-95 update_status' id='update_status' data-id=" +
                            data.id +
                            // <i class="fa-solid fa-box-circle-check"></i>
                            "><i class='fa fa-solid fa-check' style='font-size:24px; color:red;'></i>Comfirm Payment</a>"
                        );
                    }
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        '<a class="btn bg-white btn-light mx-1px text-95" href="' +
                        data.receipt_path +
                        '"data-title="PDF" target="_blank" ><i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>Export</a>'
                    );
                },
            },
        ],
    });

    $("#order_table").on("click", "a#update_status", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        console.log(id);
        $.ajax({
            type: "POST",
            // cache: false,
            contentType: false,
            processData: false,
            url: "/api/update-order-status/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + localStorage.getItem("token")
                );
            },
            dataType: "json",
            success: function (data) {
                // console.log(data.img_path);
                // $("#update_customer_modal").modal("hide");
                $("#order_table").DataTable().ajax.reload();
                console.log("data", data);
                // console.log("message", data.message);
                // console.log("request", data.request);
                toastr.success(data.message);
            },
            error: function (error) {
                console.log("error", error);
                // toastr.error(error);
            },
        });
    });
});
