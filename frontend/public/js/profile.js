$(document).ready(() => {
    const colors = ["info", "success", "danger", "dark", "primary"];
    var date_options = {
        year: "numeric",
        month: "long",
        day: "numeric",
    };
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
        order: [3, "asc"],
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

    $("#create_pet_modal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });

    $("#update_pet_modal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });

    // Fetch user info
    $.ajax({
        url: "/api/profile",
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
            var pets = data.pets;
            console.log(pets);

            $.each(pets, function (key, pet) {
                console.log(key, pet);
                var color = colors[Math.floor(Math.random() * colors.length)];
                $("#pet-row").append(`
                                        <div class="card border-${color} mx-auto mb-3" style="width: 18rem;" id="card-pet-${pet.id}">
                                            <img src="${pet.img_path}" style="width: 150px"
                                                class="card-img-top mt-2 rounded-circle border border-dark img-center " alt="/storage/images/pet-placeholder.png">
                                            <div class="card-body">
                                                <h5 class="card-title">${pet.pet_name}</h5>
                                                <p class="card-text">Age: ${pet.age}.</p>          
                                            </div>
                                            <div class="card-footer img-center" style="background-color:rgba(255, 255, 255, 0.03); border-top:none">
                                                 <a href="#" id="pet_edit" class="btn btn-info card-link" data-id="${pet.id}"><i class="bi bi-pencil-square"></i>  Edit</a>
                                                    <a href="#" id="pet_delete" class="btn btn-danger card-link" data-id="${pet.id}"><i class="bi bi-trash"></i>  Delete</a>
                                            </div>
                                        </div>`);
            });
            $("#user_image").attr("src", customer.img_path);
            $("#phone").text(customer.phone);
            $("#address").text(customer.addressline);
            $("#edit-btn-div")
                .html(`<button type="button" class="btn btn-outline-secondary float-right rounded-pill" id="edit-profile-btn" data-id="${customer.id}"
                            style="margin-top: 10px;">Edit Profile</button>`);
        },
    });

    // Submit button for adding pets
    $("#create_pet_button").on("click", function (e) {
        e.preventDefault();
        var data = $("#create_pet_form")[0];
        console.log(data);
        let formData = new FormData(data);
        console.log(formData);
        for (var pair of formData.entries()) {
            console.log(pair[0] + "," + pair[1]);
        }

        // var data = $("#createform").serialize();
        // console.log(data);
        $.ajax({
            type: "POST",
            url: "/api/owner-add-pet",
            data: formData,
            contentType: false,
            processData: false,

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
                console.log(data);
                var pet = data.pet;
                $("#create_pet_modal").modal("hide");
                var color = colors[Math.floor(Math.random() * colors.length)];
                $("#pet-row").append(`
                                        <div class="card border-${color} mx-auto mb-3" style="width: 18rem;" id="card-pet-${pet.id}">
                                            <img src="${pet.img_path}" style="width: 150px"
                                                class="card-img-top mt-2 rounded-circle border border-dark img-center " alt="/storage/images/pet-placeholder.png">
                                            <div class="card-body">
                                                <h5 class="card-title">${pet.pet_name}</h5>
                                                <p class="card-text">Age: ${pet.age}.</p>
                                            </div>
                                            <div class="card-footer img-center" style="background-color:rgba(255, 255, 255, 0.03); border-top:none">
                                                 <a href="#" id="pet_edit" class="btn btn-info card-link" data-id="${pet.id}"><i class="bi bi-pencil-square"></i>  Edit</a>
                                                    <a href="#" id="pet_delete" class="btn btn-danger card-link" data-id="${pet.id}"><i class="bi bi-trash"></i>  Delete</a>
                                            </div>
                                        </div>`);

                // $("#pet-row").load("#pet-row");
                toastr.success(data.message);
                // $("#pet-row").html(spinner).load(url);
                // location.reload();
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    // Pet EDit button Click
    $("#pet-row ").on("click", "a#pet_edit", function (e) {
        e.preventDefault();
        //
        var id = $(this).data("id");
        // var id = $(e.relatedTarget).attr("id");
        console.log(id);

        $.ajax({
            type: "GET",
            enctype: "multipart/form-data",
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/owner-edit-pet/" + id,
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
                $("#update_pet_modal").modal("show");
                $pet = data.pet;
                $("#img_saved").attr("src", $pet.img_path);
                // $("#img_path").val($pet.img_path);
                $("#old_img").val($pet.img_path);
                $("#edit-pet_id").val($pet.id);
                $("#edit-pet_name").val($pet.pet_name);
                $("#edit-age").val($pet.age);
                // Set current owner in select option
                // $(".edit-owner-select").val($pet.customer_id).trigger("change");
            },
            error: function (error) {
                console.log("error");
            },
        });
    });

    $("#update_pet_button").on("click", function (e) {
        e.preventDefault();
        var id = $("#edit-pet_id").val();
        console.log(id);
        var data = $("#update_pet_form")[0];
        console.log(data);

        let formData = new FormData(data);
        for (var pair of formData.entries()) {
            console.log(pair[0] + "," + pair[1]);
        }
        $.ajax({
            type: "POST",
            // cache: false,
            contentType: false,
            processData: false,
            url: "/api/owner-update-pet/" + id,
            data: formData,
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
                $("#update_pet_modal").modal("hide");
                // $("#pet_table").DataTable().ajax.reload();
                console.log("data", data);
                // console.log("message", data.message);
                // console.log("request", data.request);
                toastr.success(data.message);
                location.reload();
            },
            error: function (error) {
                console.log("error", error);
            },
        });
    });

    $("#pet-row").on("click", "a#pet_delete", function (e) {
        e.preventDefault();
        // var table = $("#pet_table").DataTable();
        var id = $(this).data("id");
        // var $card = $(this).parents(".card");

        // console.log(id, $card);

        bootbox.confirm({
            message: "Do You Want To Delete This Pet?",
            buttons: {
                confirm: {
                    label: "Yes",
                    className: "btn-success",
                },
                cancel: {
                    label: "No",
                    className: "btn-danger",
                },
            },
            callback: function (result) {
                console.log(result);
                if (result)
                    $.ajax({
                        type: "DELETE",
                        url: "/api/owner-delete-pet/" + id,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader(
                                "Authorization",
                                "Bearer " + localStorage.getItem("token")
                            );
                        },

                        dataType: "json",
                        contentType: "application/json",
                        success: function (data) {
                            console.log(data);
                            // bootbox.alert('success');
                            toastr.success(data.message);
                            // $("#pet-row").remove($card);
                            $("#card-pet-" + id).remove();
                            // $(this).parents(".card").remove();
                            // id = "card-pet-${pet.id}";
                            // location.reload();
                        },
                        error: function (error) {
                            console.log(error);
                        },
                    });
            },
        });
    });

    $("#edit-btn-div").on("click", "button#edit-profile-btn", function (e) {
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
            url: "/api/profile",
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
                console.log(data);
                $user = data.user;
                $account = data.customer;
                // // console.log($user);
                // // console.log($account);
                $("#edit-user_id").val($user.id);
                $("#edit-fname").val($account.fname);
                $("#edit-lname").val($account.lname);
                $("#edit-addressline").val($account.addressline);
                $("#edit-phone").val($account.phone);
                $("#edit-email").val($user.email);

                // // $("#edit-role option").each(function () {
                // //     if ($(this).val() == $user.role) {
                // //         $(this).prop("selected", true);
                // //     }
                // // });

                // console.log($user.role);
                // if ($user.role == "admin") {
                //     $("#edit-role").val("employee");
                // } else {
                //     $("#edit-role").val($user.role);
                // }

                // $("#img_path").html(
                //     `<img src="${data.img_path}" width="100" class="img-fluid img-thumbnail">`);
                // $("#dispCustomer").attr("src", data.img_path);
                // $("#edit-role").val($user.role).change();
                $("#update_user_modal").modal("show");
            },
            error: function (error) {
                console.log("error", error);
            },
        });
    });

    $("#update_user_button").on("click", function (e) {
        e.preventDefault();
        var id = $("#edit-user_id").val();
        console.log(id);
        var data = $("#update_user_form")[0];
        console.log(data);

        let formData = new FormData(data);
        for (var pair of formData.entries()) {
            console.log(pair[0] + "," + pair[1]);
        }
        $.ajax({
            type: "POST",
            // cache: false,
            contentType: false,
            processData: false,
            url: "/api/profile-update/" + id,
            data: formData,
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
                // $("#update_user_modal").modal("hide");
                // $("#user_table").DataTable().ajax.reload();
                console.log("data", data);
                // console.log("message", data.message);
                // console.log("request", data.request);
                location.reload();
                toastr.success(data.message);
            },
            error: function (error) {
                console.log("error");
            },
        });
    });

    $("#appointment_table").DataTable({
        processing: true,
        info: true,
        stateSave: true,
        select: true,
        ajax: {
            url: "/api/get-owned-appointments",
            dataSrc: "",
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
            {
                data: null,
                render: function (data, type, row) {
                    var d = new Date(data.appointment_date);
                    return d.toLocaleDateString("en-US");
                },
            },
            {
                data: "appointment_status",
            },
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

    $("#order_table").DataTable({
        processing: true,
        info: true,
        stateSave: true,
        select: true,
        ajax: {
            url: "/api/get-owned-orders",
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
                console.log(arrayList);
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
            {
                data: null,
                render: function (data, type, row) {
                    var d = new Date(data.created_at);
                    return d.toLocaleDateString("en-US", date_options);
                },
            },
            { data: "total_purchase" },
        ],
    });

    $("#transaction_table").DataTable({
        processing: true,
        info: true,
        stateSave: true,
        select: true,
        ajax: {
            url: "/api/get-owned-transactions",
            dataSrc: function (json) {
                (arrayList = []), (obj_c_processed = []);
                var g = json.transactions;
                var c = json.receipts;
                for (var i in g) {
                    var obj = {
                        id: g[i].id,
                        customer_name: g[i].customer_name,
                        address: g[i].address,
                        total_purchase: g[i].total_purchase,
                        payment_status: g[i].payment_status,
                        transactionlines: g[i].transactionlines,
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
            {
                data: null,
                render: function (data, type, row) {
                    var d = new Date(data.created_at);
                    return d.toLocaleDateString("en-US", date_options);
                },
            },
            { data: "total_purchase" },
        ],
    });
});
