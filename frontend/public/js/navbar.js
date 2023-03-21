$(document).ready(function () {
    $("#userLinks").hide();
    $("#guestLinks").show();
    if (
        localStorage.getItem("token") !== "null" &&
        localStorage.getItem("token")
    ) {
        $("#guestLinks").hide();
        $("#userLinks").show();
    }

    $("#logoutButton").on("click", function (e) {
        e.preventDefault();
        // var data = $("#loginForm")[0];
        // console.log(data);
        // let formData = new FormData(data);
        // console.log(formData);
        // for (var pair of formData.entries()) {
        //     console.log(pair[0] + "," + pair[1]);
        // }

        $.ajax({
            type: "POST",
            url: "http://localhost:8000/api/logout",
            data: null,
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
                // xhr.setRequestHeader("Content-Type", "application/json");
                // xhr.setRequestHeader("Accept", "text/json");
            },

            dataType: "json",
            success: function (data) {
                console.log(data);
                // console.log(data.data.token);
                localStorage.removeItem("token");
                toastr.success("User successfully logged out!");
                location.href = "http://localhost:8000/home";
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});
