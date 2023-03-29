$(document).ready(function () {
    var cartObj = JSON.parse(localStorage.getItem("cart")) || [];
    let cart;
    // If cart is not empty, load the items in cartObj to a new Cart instance
    if (cartObj != null) {
        cart = new Cart(
            cartObj.items,
            cartObj.services,
            cartObj.totalQuantity,
            cartObj.totalAmount
        );
    } else {
        // else create a new Cart class instance
        cart = new Cart();
    }
    $("#product-table").empty();
    $("#totalAmount").text("$" + cart.totalAmount);
    if (cart != null) {
        $.each(cart.items, function (key, item) {
            console.log(item.name);

            $("#product-table").append(`
                                <div class="row mb-2 mb-sm-0 py-25">
                                    <div class="d-none d-sm-block col-1">${
                                        key + 1
                                    }</div>
                                    <div class="col-9 col-sm-5">${
                                        item.name
                                    }</div>
                                    <div class="d-none d-sm-block col-2">${
                                        item.quantity
                                    }</div>
                                    <div class="d-none d-sm-block col-2 text-95">$${
                                        item.price
                                    }</div>
                                    <div class="col-2 text-secondary-d2">$${
                                        item.price * item.quantity
                                    }</div>
                                </div>`);
        });
    }

    $.ajax({
        url: "/api/receipt-info/19",
        type: "GET",
        processData: false, // Important!
        contentType: false,
        // dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Authorization",
                "Bearer " + localStorage.getItem("token")
            );
        },
        success: function (data) {
            console.log(data);
            // $category_list = $("#category");
            // $edit_category_list = $("#edit-category");
            // $.each(data, function (key, value) {
            //     // console.log(key, value);
            //     $category_list.append(
            //         `<option value="${value.id}">${value.category_name}</option>`
            //     );
            //     $edit_category_list.append(
            //         `<option value="${value.id}">${value.category_name}</option>`
            //     );
            // });
        },
        error: function (error) {
            console.log(error);
        },
    });
});
