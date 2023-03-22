$(document).ready(function () {
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

    $("#employee_table").DataTable({
        processing: true,
        info: true,
        stateSave: true,
        ajax: {
            url: "http://127.0.0.1:8000/api/employee",
            dataSrc: "",
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
            { data: "lname" },
            { data: "fname" },
            { data: "addressline" },
            { data: "phone" },
            // { data: "created_at" },
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
                        "<a href=#'' class='employee_edit' id='employee_edit' data-id=" +
                        data.id +
                        "><i class='fa-solid fa-pen' aria-hidden='true' style='font-size:24px' ></i></a>"
                    );
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        "<a href='#' class='employee_delete' id='employee_delete' data-id=" +
                        data.id +
                        "><i class='fa-solid fa-trash-can' aria-hidden='true' style='font-size:24px; color:red;'></a></i>"
                    );
                },
            },
        ],
    });

    $("#show_hide_password1 button").on("click", function (event) {
        console.log("test");
        event.preventDefault();
        if ($("#show_hide_password1 input").attr("type") == "text") {
            $("#show_hide_password1 input").attr("type", "password");
            $("#show_hide_password1 i").addClass("fa-eye-slash");
            $("#show_hide_password1 i").removeClass("fa-eye");
        } else if ($("#show_hide_password1 input").attr("type") == "password") {
            $("#show_hide_password1 input").attr("type", "text");
            $("#show_hide_password1 i").removeClass("fa-eye-slash");
            $("#show_hide_password1 i").addClass("fa-eye");
        }
    });
    $("#show_hide_password2 button").on("click", function (event) {
        // console.log("test");
        event.preventDefault();
        if ($("#show_hide_password2 input").attr("type") == "text") {
            $("#show_hide_password2 input").attr("type", "password");
            $("#show_hide_password2 i").addClass("fa-eye-slash");
            $("#show_hide_password2 i").removeClass("fa-eye");
        } else if ($("#show_hide_password2 input").attr("type") == "password") {
            $("#show_hide_password2 input").attr("type", "text");
            $("#show_hide_password2 i").removeClass("fa-eye-slash");
            $("#show_hide_password2 i").addClass("fa-eye");
        }
    });

    // Clear modal when close
    $("#create_employee_modal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });
    $("#update_employee_modal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });

    $("#create_employee_button").on("click", function (e) {
        e.preventDefault();
        var data = $("#create_employee_form")[0];
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
            url: "http://localhost:8000/api/employee",
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
                $("#create_employee_modal").modal("hide");
                toastr.success(data.message);
                // var $tableData = $("#userTable").DataTable();
                $("#employee_table").DataTable().ajax.reload();
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    // User Delete
    $("#employee_table #employee_table_body").on(
        "click",
        "a.employee_delete",
        function (e) {
            e.preventDefault();
            var table = $("#employee_table").DataTable();
            var id = $(this).data("id");
            var $row = $(this).closest("tr");

            console.log(id);

            bootbox.confirm({
                message: "Do You Want To Delete This Employee",
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
                            url: "http://localhost:8000/api/employee/" + id,
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
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
        }
    );

    // User Edit
    $("#employee_table #employee_table_body").on(
        "click",
        "a.employee_edit",
        function (e) {
            e.preventDefault();
            $("#update_employee_modal").modal("show");
            var id = $(this).data("id");
            // var id = $(e.relatedTarget).attr("id");
            console.log(id);

            $.ajax({
                type: "GET",
                enctype: "multipart/form-data",
                processData: false, // Important!
                contentType: false,
                cache: false,
                url: "http://localhost:8000/api/employee/" + id + "/edit",
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
                success: function (data) {
                    console.log(data);
                    $user = data.user;
                    $account = data.account;
                    // console.log($user);
                    // console.log($account);
                    $("#edit-employee_id").val($account.id);
                    $("#edit-fname").val($account.fname);
                    $("#edit-lname").val($account.lname);
                    $("#edit-addressline").val($account.addressline);
                    $("#edit-phone").val($account.phone);
                    $("#edit-email").val($user.email);

                    // $("#img_path").html(
                    //     `<img src="${data.img_path}" width="100" class="img-fluid img-thumbnail">`);
                    // $("#dispEmployee").attr("src", data.img_path);
                    // $("#edit-role").val($user.role).change();
                },
                error: function (error) {
                    console.log("error", error);
                },
            });
        }
    );

    // User Update
    $("#update_employee_button").on("click", function (e) {
        e.preventDefault();
        var id = $("#edit-employee_id").val();
        console.log(id);
        var data = $("#update_employee_form")[0];
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
            url: "http://localhost:8000/api/employee-update/" + id,
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
                $("#update_employee_modal").modal("hide");
                $("#employee_table").DataTable().ajax.reload();
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
