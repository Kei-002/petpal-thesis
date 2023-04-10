$(document).ready(() => {
    $("#thank-you").hide();

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
            console.log(data);
            console.log(data.pets);
            // $pet_list = $("#pet-select");
            if (Object.keys(data.pets).length >= 0) {
                // $edit_owner_list = $("#edit-owner");
                $.each(data.pets, function (key, value) {
                    console.log(value);

                    $("#pet-radio").append(
                        `<label class="radio"> 
                                <input type="radio" name="this-pet" value="${value.id}"> <span> <i class="fa fa-user"></i> ${value.pet_name} </span> </label>`
                    );

                    // $("#pet-radio").each(function () {
                    //     $(this).append(
                    //         `<label class="radio mr-1">
                    //             <input type="radio" name="${value.name}" value="${value.id}"> <span> <i class="fa fa-user"></i> ${value.name} </span> </label>`
                    //     );
                    // });
                    // $(".pet-select")
                    //     .siblings()
                    //     .append(
                    //         `<option value="${value.id}">${value.pet_name}</option>`
                    //     );
                });
            } else {
                console.log("No Pets");
            }
        },
    });

    $(".confirm-button").on("click", function (e) {
        // console.log($(this).data("id"), $("#cart-list #itemQuantity").val());
        e.preventDefault();
        // var id = $("#edit-customer_id").val();
        // console.log(id);
        var data = $("#consultation_form")[0];
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
            url: "/api/consultation",
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
                // // console.log(data.img_path);
                // $("#update_customer_modal").modal("hide");
                // $("#customer_table").DataTable().ajax.reload();
                console.log("data", data);
                $("#appointment").hide();
                $("#thank-you").show("fast");
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
    $("#another-appoint").on("click", function (e) {
        // console.log($(this).data("id"), $("#cart-list #itemQuantity").val());
        e.preventDefault();
        // var id = $("#edit-customer_id").val();
        // console.log(id);
        $("#thank-you").hide();
        $("#appointment").show("fast");
    });
});
