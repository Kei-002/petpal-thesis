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

    // Fill datatable
    $("#user_table").DataTable({
        processing: true,
        info: true,
        stateSave: true,
        ajax: {
            url: "http://127.0.0.1:8000/api/user",
            dataSrc: "",
        },
        order: [0, "dec"],
        // data: data,
        columns: [
            { data: "name" },
            { data: "email" },
            { data: "role" },
            { data: "created_at" },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        "<a href=#'' class='user_edit' id='user_edit' data-id=" +
                        data.id +
                        "><i class='fa-solid fa-pen' aria-hidden='true' style='font-size:24px' ></i></a>"
                    );
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        "<a href='#' class='user_delete' id='user_edit' data-id=" +
                        data.id +
                        "><i class='fa-solid fa-trash-can' aria-hidden='true' style='font-size:24px; color:red;'></a></i>"
                    );
                },
            },
        ],
    });

    // Show/Hide Password
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
    $("#create_user_modal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });

    // User Submit
    $("#user_create_button").on("click", function (e) {
        e.preventDefault();
        var data = $("#user_create_form")[0];
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
            url: "http://localhost:8000/api/user",
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
                $("#create_user_modal").modal("hide");
                toastr.success(data.message);
                // var $tableData = $("#userTable").DataTable();
                $("#user_table").DataTable().ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // User Delete
        $("#user_table #user_table_body").on("click", "a.user_delete", function (e) {
            e.preventDefault();
            var table = $("#user_table").DataTable();
            var id = $(this).data("id");
            var $row = $(this).closest("tr");

            console.log(id);
            
            bootbox.confirm({
                message: "Do You Want To Delete This Customer",
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
                            url: "http://localhost:8000/api/user/" + id,
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),

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




}); //Document Ready END



