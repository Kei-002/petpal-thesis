$(document).ready(function () {
    // Fill datatable
    $("#userTable").DataTable({
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
                        "<a href='#' class='editBtn' id='editbtn' data-id=" +
                        data.id +
                        "><i class='fa-solid fa-pen' aria-hidden='true' style='font-size:24px' ></i></a>"
                    );
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        "<a href='#' class='deletebtn' data-id=" +
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
    $("#exampleModal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });
});
