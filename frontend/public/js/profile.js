$(document).ready(() => {
    const colors = ["info", "success", "danger", "dark", "primary"];

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
            var pets = data.pets;
            console.log(pets);

            $.each(pets, function (key, pet) {
                console.log(key, pet);
                var color = colors[Math.floor(Math.random() * colors.length)];
                $("#pet-row").append(`
                                        <div class="card border-${color} mx-auto mb-3" style="width: 18rem;">
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
                $("#create_pet_modal").modal("hide");
                toastr.success(data.message);
                location.reload();
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
        // var $row = $(this).closest("tr");

        console.log(id);

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
                            location.reload();
                        },
                        error: function (error) {
                            console.log(error);
                        },
                    });
            },
        });
    });
});
