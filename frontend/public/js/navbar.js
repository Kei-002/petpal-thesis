$(document).ready(function () {
    // $("#userLinks").hide();
    // $("#guestLinks").show();
    // if (
    //     localStorage.getItem("token") !== "null" &&
    //     localStorage.getItem("token")
    // ) {
    //     $("#guestLinks").hide();
    //     $("#userLinks").show();
    // }

    $("#logoutButton").on("click", function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/logout",
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
                location.href = "/";
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});
