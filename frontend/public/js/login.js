$(document).ready(function () {
    $("#loginSubmit").on("click", function (e) {
        e.preventDefault();
        var data = $("#loginForm")[0];
        console.log(data);
        let formData = new FormData(data);
        console.log(formData);
        for (var pair of formData.entries()) {
            console.log(pair[0] + "," + pair[1]);
        }

        $.ajax({
            type: "POST",
            // url: "http://localhost:8000/login",
            url: "/login",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                // console.log(data.data.token);
                localStorage.setItem("token", response.data.token);
                toastr.success("User successfully logged in!");
                if (response.data.role != "customer") {
                    location.href = "/dashboard";
                    console.log(response.data.role);
                } else {
                    location.href = "/";
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});
