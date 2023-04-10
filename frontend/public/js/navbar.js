$(document).ready(function () {
    var cartObj = JSON.parse(localStorage.getItem("cart")) || [];

    console.log(cartObj.totalQuantity);
    var totalQuantity = 0;
    if (cartObj) {
        totalQuantity = cartObj.totalQuantity;
    }

    $("#cartHtml span").text(totalQuantity);

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
                localStorage.removeItem("cart");
                toastr.success("User successfully logged out!");
                location.href = "/";
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    // function addQuantityText() {
    //     var test = $("#cartHtml span").text(totalQuantity);
    //     console.log(test);
    // }
});
