$(document).ready(() => {
    // Fill datatable
    // $("#order_table").DataTable({
    //     processing: true,
    //     info: true,
    //     stateSave: true,
    //     select: true,
    //     ajax: {
    //         url: "/api/all-orders",
    //         dataSrc: function (json) {
    //             (arrayList = []), (obj_c_processed = []);
    //             var g = json.orders;
    //             var c = json.receipts;
    //             for (var i in g) {
    //                 var obj = {
    //                     id: g[i].id,
    //                     customer_name: g[i].customer_name,
    //                     address: g[i].address,
    //                     total_purchase: g[i].total_purchase,
    //                     payment_status: g[i].payment_status,
    //                     orderlines: g[i].orderlines,
    //                     created_at: g[i].created_at,
    //                     receipt_path: g[i].receipt_path,
    //                     receipt_id: g[i].receipt_id,
    //                 };

    //                 for (var j in c) {
    //                     if (g[i].id == c[j].item_id) {
    //                         obj.payment_status = c[j].payment_status;
    //                         obj.receipt_path = c[j].receipt_path;
    //                         obj.address = c[j].addressline;
    //                         obj.total_purchase = c[j].total_purchase;
    //                         obj.receipt_id = c[j].id;
    //                         obj.customer_name = c[j].fname + " " + c[j].lname;
    //                         obj_c_processed[c[j].id] = true;
    //                     }
    //                 }

    //                 // obj.circle = obj.circle || 'no';
    //                 arrayList.push(obj);
    //             }

    //             for (var j in c) {
    //                 if (typeof obj_c_processed[c[j].id] == "undefined") {
    //                     arrayList.push({
    //                         id: c[j].id,
    //                         item_id: c[j].item_id,
    //                         customer_name: c[j].fname + " " + c[j].lname,
    //                         payment_status: c[j].payment_status,
    //                         address: c[j].addressline,
    //                         receipt_path: c[j].receipt_path,
    //                         created_at: c[j].created_at,
    //                     });
    //                 }
    //             }

    //             return arrayList;
    //         },
    //         beforeSend: function (xhr) {
    //             xhr.setRequestHeader(
    //                 "Authorization",
    //                 "Bearer " + localStorage.getItem("token")
    //             );
    //         },
    //     },
    //     order: [3, "asc"],
    //     // data: data,
    //     columns: [
    //         {
    //             data: "id",
    //         },
    //         { data: "customer_name" },
    //         {
    //             data: "address",
    //             render: function (data, type, row) {
    //                 return (
    //                     "<div class='text-wrap' style='font-size:0.8rem'>" +
    //                     data +
    //                     "</div>"
    //                 );
    //             },
    //         },
    //         {
    //             data: "payment_status",
    //             render: function (data, type, row) {
    //                 if (data == "Paid") {
    //                     return (
    //                         '<span class="badge rounded-pill bg-success">' +
    //                         data +
    //                         "</span>"
    //                     );
    //                 } else {
    //                     return (
    //                         '<span class="badge rounded-pill bg-danger">' +
    //                         data +
    //                         "</span>"
    //                     );
    //                 }
    //             },
    //         },
    //         { data: "total_purchase" },
    //         // {
    //         //     data: null,
    //         //     render: function (data, type, row) {
    //         //         return data.customer.fname + " " + data.customer.lname;
    //         //     },
    //         // },
    //         // { data: "created_at" },

    //         // Format created_at to {weekday}, {year}, {month}, {day}, {hour}, {minute}
    //         {
    //             data: null,
    //             render: function (data, type, row) {
    //                 var d = new Date(data.created_at);
    //                 return d.toLocaleDateString("en-US", date_options);
    //             },
    //         },
    //         {
    //             data: null,
    //             render: function (data, type, row) {
    //                 console.log(data);
    //                 if (data.payment_status == "Paid") {
    //                     return (
    //                         "<a href='#' class='btn bg-white btn-light mx-1px text-95 update_status disabled' id='update_status' data-id=" +
    //                         data.id +
    //                         // <i class="fa-solid fa-box-circle-check"></i>
    //                         "><i class='fa fa-solid fa-check' style='font-size:24px; color:green;'></i>Payment Done</a>"
    //                     );
    //                 } else {
    //                     return (
    //                         "<a href='#' class='btn bg-white btn-light mx-1px text-95 update_status' id='update_status' data-id=" +
    //                         data.id +
    //                         // <i class="fa-solid fa-box-circle-check"></i>
    //                         "><i class='fa fa-solid fa-check' style='font-size:24px; color:red;'></i>Comfirm Payment</a>"
    //                     );
    //                 }
    //             },
    //         },
    //         {
    //             data: null,
    //             render: function (data, type, row) {
    //                 return (
    //                     '<a class="btn bg-white btn-light mx-1px text-95" href="' +
    //                     data.receipt_path +
    //                     '"data-title="PDF" target="_blank" ><i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>Export</a>'
    //                 );
    //             },
    //         },
    //     ],
    // });

    $("#update_appointment_modal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });
    var date_options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
    };
    // Fill datatable
    $("#appointment_table").DataTable({
        processing: true,
        info: true,
        stateSave: true,
        ajax: {
            url: "/api/consultation",
            dataSrc: "",
            // function (json) {
            //     console.log(json);
            // },
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + localStorage.getItem("token")
                );
            },
        },
        order: [0, "dec"],
        // data: data,
        columns: [
            { data: "id" },
            {
                data: null,
                render: function (data, type, row) {
                    return data.customer.fname + " " + data.customer.lname;
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    var d = new Date(data.appointment_date);
                    return d.toLocaleDateString("en-US", date_options);
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    switch (data.appointment_status) {
                        case "Confirmed":
                            return (
                                "<a href='#' class='btn bg-white btn-light mx-1px text-95 update_status disabled' id='update_status' data-id=" +
                                data.id +
                                // <i class="fa-solid fa-box-circle-check"></i>
                                "><i class='fa fa-solid fa-check' style='font-size:24px; color:green;'></i>Confirmed</a>"
                            );
                            break;
                        case "Cancelled":
                            // code block
                            return (
                                "<a href='#' class='btn bg-white btn-light mx-1px text-95 update_status disabled' id='update_status' data-id=" +
                                data.id +
                                // <i class="fa-solid fa-box-circle-check"></i>
                                "><i class='fa fa-calendar-xmark' style='font-size:24px; color:red;'></i>Cancelled</a>"
                            );
                            break;
                        case "Reschedule":
                            return (
                                "<a href='#' class='btn bg-white btn-light mx-1px text-95 update_status disabled' id='update_status' data-id=" +
                                data.id +
                                // <i class="fa-solid fa-box-circle-check"></i>
                                "><i class='fa fa-calendar-days' style='font-size:24px; color:blue;'></i>Rescheduled</a>"
                            );
                            break;
                        default:
                            return (
                                "<a href='#' class='btn bg-white btn-light mx-1px text-95 update_status' id='update_status' data-id=" +
                                data.id +
                                // <i class="fa-solid fa-box-circle-check"></i>
                                "><i class='fa fa-solid fa-check' style='font-size:24px; color:red;'></i>Comfirm Appointment</a>"
                            );
                    }

                    if (data.appointment_status == "Confirmed") {
                    } else {
                    }
                },
            },
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
                    return (
                        "<a href='#' class='appointment_edit' id='appointment_edit' data-id=" +
                        data.id +
                        "><i class='fa-solid fa-edit' aria-hidden='true' style='font-size:24px; color:blue;'></a></i>"
                    );
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        "<a href='#' class='appointment_delete' id='appoinment_delete' data-id=" +
                        data.id +
                        "><i class='fa-solid fa-trash-can' aria-hidden='true' style='font-size:24px; color:red;'></a></i>"
                    );
                },
            },
        ],
    });

    $("#appointment_table").on("click", "a#update_status", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        console.log(id);
        $.ajax({
            type: "POST",
            // cache: false,
            contentType: false,
            processData: false,
            url: "/api/appointment-confirm/" + id,
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
                $("#appointment_table").DataTable().ajax.reload();
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

    $("#appointment_table").on("click", "a.appointment_edit", function (e) {
        e.preventDefault();

        var id = $(this).data("id");
        // var id = $(e.relatedTarget).attr("id");
        console.log(id);

        $.ajax({
            type: "GET",
            enctype: "multipart/form-data",
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "api/consultation/" + id + "/edit",
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
                $infos = data;
                console.log($infos.id, $infos);
                $("#edit-appointment_id").val($infos.id);
                $("#edit-fname").val($infos.customer.fname);
                $("#edit-lname").val($infos.customer.lname);
                $("#edit-appointment_date").val($infos.appointment_date);
                $("#edit-appointment_status")
                    .val($infos.appointment_status)
                    .change();
                $("#edit-description").val($infos.description);
                $("#update_appointment_modal").modal("show");
            },
            error: function (error) {
                console.log("error", error);
            },
        });
    });

    $("#appointment_table").on("click", "a.appointment_delete", function (e) {
        e.preventDefault();

        var id = $(this).data("id");
        // var id = $(e.relatedTarget).attr("id");
        console.log(id);

        $.ajax({
            type: "POST",
            enctype: "multipart/form-data",
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "api/cancel-appointment/" + id,
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
                $infos = data;
                console.log($infos.id, $infos);
                $("#appointment_table").DataTable().ajax.reload();
                toastr.success(data.message);
            },
            error: function (error) {
                console.log("error", error);
            },
        });
    });
    // Full Calendar Section
    // document.addEventListener("DOMContentLoaded", function () {
    //     var calendarEl = document.getElementById("calendar");

    //     var calendar = new FullCalendar.Calendar(calendarEl, {
    //         initialView: "dayGridMonth",
    //         initialDate: "2023-03-07",
    //         headerToolbar: {
    //             left: "prev,next today",
    //             center: "title",
    //             right: "dayGridMonth,timeGridWeek,timeGridDay",
    //         },
    //         events: [
    //             {
    //                 title: "All Day Event",
    //                 start: "2023-03-01",
    //             },
    //             {
    //                 title: "Long Event",
    //                 start: "2023-03-07",
    //                 end: "2023-03-10",
    //             },
    //             {
    //                 groupId: "999",
    //                 title: "Repeating Event",
    //                 start: "2023-03-09T16:00:00",
    //             },
    //             {
    //                 groupId: "999",
    //                 title: "Repeating Event",
    //                 start: "2023-03-16T16:00:00",
    //             },
    //             {
    //                 title: "Conference",
    //                 start: "2023-03-11",
    //                 end: "2023-03-13",
    //             },
    //             {
    //                 title: "Meeting",
    //                 start: "2023-03-12T10:30:00",
    //                 end: "2023-03-12T12:30:00",
    //             },
    //             {
    //                 title: "Lunch",
    //                 start: "2023-03-12T12:00:00",
    //             },
    //             {
    //                 title: "Meeting",
    //                 start: "2023-03-12T14:30:00",
    //             },
    //             {
    //                 title: "Birthday Party",
    //                 start: "2023-03-13T07:00:00",
    //             },
    //             {
    //                 title: "Click for Google",
    //                 url: "http://google.com/",
    //                 start: "2023-03-28",
    //             },
    //         ],
    //     });

    //     calendar.render();
    // });
});
