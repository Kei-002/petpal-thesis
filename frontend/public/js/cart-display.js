$(document).ready(function () {
    // Get cart from localStorage
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
    $("#cart-list").empty();
    $("#totalQuantity").text(cart.totalQuantity);
    $("#subtotal h1").text("₱ " + cart.totalAmount);
    console.log(cart.items, cart.totalQuantity);
    if (cart != null) {
        $.each(cart.items, function (key, item) {
            console.log(item.name);

            $("#cart-list").append(`<tr>
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-md-3 text-center">
                                            <img src="${
                                                item.image
                                            }" alt="${item.name}"
                                                class="img-fluid d-none d-md-block rounded mb-2 shadow ">
                                        </div>
                                        <div class="col-md-9 text-left mt-sm-2">
                                            <h4>${item.name}</h4>
                                            <p class="font-weight-light">₱ ${
                                                item.price
                                            }</p>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Price x Quantity">₱ ${
                                    item.price * item.quantity
                                }</td>
                                <td data-th="Quantity">
                                    <input type="number" id="itemQuantity" class="form-control form-control-lg text-center" value="${
                                        item.quantity
                                    }">
                                </td>
                                <td class="actions" data-th="">
                                    <div class="text-right">
                                        <button type="button" id="update-item" class="btn btn-white border-secondary bg-white btn-md mb-2" data-id="${
                                            item.id
                                        }">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                        <button id="remove-item" class="btn btn-white border-secondary bg-white btn-md mb-2" data-id="${
                                            item.id
                                        }">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>`);
        });
    }

    $("#cart-list").on("click", "button#update-item", function (e) {
        // console.log($(this).data("id"), $("#cart-list #itemQuantity").val());
        itemID = Number($(this).data("id"));
        itemQuantity = Number($("#cart-list #itemQuantity").val());
        cart.update(itemID, itemQuantity);

        location.reload();
    });

    $("#cart-list").on("click", "button#remove-item", function (e) {
        // console.log($(this).data("id"), $("#cart-list #itemQuantity").val());
        itemID = Number($(this).data("id"));
        // itemQuantity = Number($("#cart-list #itemQuantity").val());
        cart.remove(itemID);

        location.reload();
    });

    $("#checkoutButton").on("click", function (e) {
        // console.log($(this).data("id"), $("#cart-list #itemQuantity").val());
        // itemID = Number($(this).data("id"));
        // itemQuantity = Number($("#cart-list #itemQuantity").val());
        // cart.remove(itemID);
        // console.log(cart);
        $.ajax({
            url: "/api/checkout",
            type: "POST",
            data: JSON.stringify(cart),
            processData: false,
            contentType: "application/json; charset=UTF-8",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + localStorage.getItem("token")
                );
            },
            success: function (data) {
                console.log(data);
                // $("#create_customer_modal").modal("hide");
                toastr.success(data.message);
                // // var $tableData = $("#userTable").DataTable();
                // $("#customer_table").DataTable().ajax.reload();
                // cart.clear();
                location.href = "/receipt";
            },
            error: function (error) {
                console.log(error);
            },
        });
        // location.reload();
    });
});
