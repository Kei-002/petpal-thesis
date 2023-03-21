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
            url: "http://localhost:8000/api/login",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                // console.log(data.data.token);
                localStorage.setItem("token", data.data.token);
                toastr.success("User successfully logged in!");
                if (data.data.role != "customer") {
                    location.href = "http://localhost:8000/dashboard";
                    console.log(data.data.role);
                } else {
                    location.href = "http://localhost:8000";
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});
