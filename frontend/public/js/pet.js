$(document).ready(function () {
    // Toastr Options
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
    $("#pet_table").DataTable({
        processing: true,
        info: true,
        stateSave: true,
        ajax: {
            url: "http://127.0.0.1:8000/api/pet",
            dataSrc: "",
        },
        order: [0, "dec"],
        // data: data,
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
            {
                data: null,
                render: function (data, type, row) {
                    return data.customer.fname + " " + data.customer.lname;
                },
            },
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

    // Clear modal when close
    $("#create_pet_modal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });
    $("#update_pet_modal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });

    // Load customer to select options input
    $.ajax({
        url: "http://localhost:8000/api/customer",
        type: "GET",
        processData: false, // Important!
        contentType: false,
        dataType: "json",
        success: function (data) {
            $owner_list = $("#owner");
            $edit_owner_list = $("#edit-owner");
            $.each(data, function (key, value) {
                // console.log(key, value);
                $owner_list.append(
                    `<option value="${value.id}">${value.fname} ${value.lname}</option>`
                );
                $edit_owner_list.append(
                    `<option value="${value.id}">${value.fname} ${value.lname}</option>`
                );
            });
        },
    });

    // Set select option to select2
    // $(".owner-select").select2();
    $(".owner-select").select2({
        dropdownParent: $("#create_pet_modal"),
        placeholder: "Select pet owner",
        theme: "bootstrap-5",
    });

    $(".edit-owner-select").select2({
        dropdownParent: $("#update_pet_modal"),
        placeholder: "Select pet owner",
        theme: "bootstrap-5",
    });

    // Pet Submit
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
            url: "http://localhost:8000/api/pet",
            data: formData,
            contentType: false,
            processData: false,

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            // beforeSend: function (xhr) {
            //     xhr.setRequestHeader(
            //         "Authorization",
            //         "Bearer " + localStorage.getItem("token")
            //     );
            // },

            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#create_pet_modal").modal("hide");
                toastr.success(data.message);
                // var $tableData = $("#petTable").DataTable();
                $("#pet_table").DataTable().ajax.reload();
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    // Pet Delete
    $("#pet_table #pet_table_body").on("click", "a.pet_delete", function (e) {
        e.preventDefault();
        var table = $("#pet_table").DataTable();
        var id = $(this).data("id");
        var $row = $(this).closest("tr");

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
                        url: "http://localhost:8000/api/pet/" + id,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),

                            // Authorization:
                            //     "Bearer " + localStorage.getItem("token"),
                        },

                        dataType: "json",
                        contentType: "application/json",
                        success: function (data) {
                            console.log(data);
                            // bootbox.alert('success');
                            $row.fadeOut(2000, function () {
                                table.row($row).remove().draw(false);
                            });
                            toastr.success(data.message);
                        },
                        error: function (error) {
                            console.log(error);
                        },
                    });
            },
        });
    });

    // Pet Edit
    $("#pet_table #pet_table_body").on("click", "a.pet_edit", function (e) {
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
            url: "http://localhost:8000/api/pet/" + id + "/edit",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            // beforeSend: function (xhr) {
            //     xhr.setRequestHeader(
            //         "Authorization",
            //         "Bearer " + localStorage.getItem("token")
            //     );
            // },
            dataType: "json",
            success: function (data) {
                $("#update_pet_modal").modal("show");
                $pet = data.pet;
                $("#edit-pet_id").val($pet.id);
                $("#edit-pet_name").val($pet.pet_name);
                $("#edit-age").val($pet.age);
                // Set current owner in select option
                $(".edit-owner-select").val($pet.customer_id).trigger("change");
            },
            error: function (error) {
                console.log("error");
            },
        }); 
    });

    // Pet Update
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
            url: "http://localhost:8000/api/pet-update/" + id,
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            // beforeSend: function (xhr) {
            //     xhr.setRequestHeader(
            //         "Authorization",
            //         "Bearer " + localStorage.getItem("token")
            //     );
            // },
            dataType: "json",
            success: function (data) {
                // console.log(data.img_path);
                $("#update_pet_modal").modal("hide");
                $("#pet_table").DataTable().ajax.reload();
                console.log("data", data);
                // console.log("message", data.message);
                // console.log("request", data.request);
                toastr.success(data.message);
            },
            error: function (error) {
                console.log("error", error);
            },
        });
    });
}); //Document Ready END
