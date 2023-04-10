$(document).ready(function () {
    $("#receipt-section").hide();
    $("#product-table").empty();
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
    $("#service-list").empty();
    $("#product-cart").hide();
    $("#service-cart").hide();
    $("#totalQuantity").text(cart.totalQuantity);
    $("#subtotal h1").text("₱ " + cart.totalAmount);
    console.log(cart.items, cart.totalQuantity);
    // $html = "";

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
            $pet_list = $("#pet-select");
            if (Object.keys(data.pets).length >= 0) {
                // $edit_owner_list = $("#edit-owner");
                $.each(data.pets, function (key, value) {
                    console.log(value);
                    $(".pet-select").each(function () {
                        $(this).append(
                            `<option value="${value.id}">${value.pet_name}</option>`
                        );
                    });
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
    // $("#cart-list").hide();
    // $("#service-list").hide();

    if (cart) {
        if (Object.keys(cart.items).length) {
            $("#product-cart").show();
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
                                <td data-th="Quantity">
                                    <input type="number" id="itemQuantity" class="form-control form-control-lg text-center" value="${
                                        item.quantity
                                    }">
                                </td>
                                <td data-th="Price x Quantity">₱ ${
                                    item.price * item.quantity
                                }</td>
                                
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

        if (Object.keys(cart.services).length) {
            $("#service-cart").show();
            $.each(cart.services, function (key, service) {
                console.log(service.name);
                $("#service-list").append(`<tr>
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-md-3 text-center">
                                            <img src="${service.image}" alt="${service.name}"
                                                class="img-fluid d-none d-md-block rounded mb-2 shadow ">
                                        </div>
                                        <div class="col-md-9 text-left mt-sm-2">
                                            <h4>${service.name}</h4>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Pet to Service">
                                    <input type="hidden" id="service-id" value="${service.id}">
                                    <select class="form-select pet-select" aria-label="role-select" name="pet"
                                        id="pet-select">
                                    </select>
                                </td>
                                <td data-th="Price">
                                    ₱ ${service.price}
                                </td>
                                <td class="actions" data-th="">
                                    <div class="text-right">
                                        <button type="button" id="update-item" class="btn btn-white border-secondary bg-white btn-md mb-2" data-id="${service.id}">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                        <button id="remove-item" class="btn btn-white border-secondary bg-white btn-md mb-2" data-id="${service.id}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>`);
            });
        }
    }

    // function setSelected(id) {

    // }

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
        $("#service-list .pet-select").each(function () {
            var pet_id = Number($(this).val());
            var item_id = Number($(this).siblings("#service-id").val());
            // console.log($(this).siblings("#service-id").val(), $(this).val());
            cart.updateService(item_id, pet_id);
        });
        // console.log(cart.services);
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
                $("#product-table-headers").hide();
                $("#service-table-headers").hide();
                $("#product-table").hide();
                $("#service-table").hide();
                console.log(data);
                toastr.success(data.message);
                cart.clear();

                // Set Customer Information in Receipt
                $("#userAddress").text(data.customer.addressline);
                $("#userPhone").text(data.customer.phone);

                // Append order data to receipt
                var orderDate = new Date(data.receipt.created_at);
                $("#orderID")
                    .html(`<i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                                class="text-600 text-90">ID:</span> ${data.receipt.id}`);
                $("#page-order-id").html(` Invoice
                        <small class="page-info">
                            <i class="fa fa-angle-double-right text-80"></i>
                            ID: #${data.receipt.id}
                        </small>`);

                $("#orderDate")
                    .html(`<i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                                class="text-600     text-90">Issue Date:</span>${orderDate.toLocaleDateString(
                                                    "en-US"
                                                )}`);

                // set Total Amount in receipt
                $("#totalAmount span")
                    .html(`<span class="text-150 text-success-d3 opacity-2"
                                                    >$${data.total}</span>`);

                var orderlines = data.orderlines;
                console.log(orderlines);

                if (Object.keys(orderlines).length) {
                    $("#product-table-headers").show();
                    $("#product-table").show();
                    $.each(orderlines, function (key, orderline) {
                        console.log(key, orderline);
                        $("#product-table").append(`
                                        <div class="row mb-2 mb-sm-0 py-25">
                                            <div class="d-none d-sm-block col-1">${
                                                key + 1
                                            }</div>
                                            <div class="col-9 col-sm-5">${
                                                orderline.name
                                            }</div>
                                            <div class="d-none d-sm-block col-2">${
                                                orderline.quantity
                                            }</div>
                                            <div class="d-none d-sm-block col-2 text-95">$${
                                                orderline.price
                                            }</div>
                                            <div class="col-2 text-secondary-d2">$${
                                                orderline.price *
                                                orderline.quantity
                                            }</div>
                                        </div>`);
                    });
                }

                var transactions = data.transactions;
                console.log(transactions);

                if (Object.keys(transactions).length) {
                    $("#service-table-headers").show();
                    $("#service-table").show();
                    $.each(transactions, function (key, transaction) {
                        console.log(key, transaction);
                        $("#service-table").append(`
                                        <div class="row mb-2 mb-sm-0 py-25">
                                            <div class="d-none d-sm-block col-1">${
                                                key + 1
                                            }</div>
                                            <div class="col-9 col-sm-5">${
                                                transaction.name
                                            }</div>
                                            <div class="d-none d-sm-block col-2"></div>
                                            <div class="d-none d-sm-block col-2 text-95">${
                                                transaction.pet_name
                                            }</div>
                                            <div class="col-2 text-secondary-d2">$${
                                                transaction.price
                                            }</div>
                                        </div>`);
                    });
                }

                //     $("#product-table").append(`
                //         <div class="row mb-2 mb-sm-0 py-25">
                //             <div class="d-none d-sm-block col-1">${
                //                 key + 1
                //             }</div>
                //             <div class="col-9 col-sm-5">${
                //                 item.name
                //             }</div>
                //             <div class="d-none d-sm-block col-2">${
                //                 item.quantity
                //             }</div>
                //             <div class="d-none d-sm-block col-2 text-95">$${
                //                 item.price
                //             }</div>
                //             <div class="col-2 text-secondary-d2">$${
                //                 item.price * item.quantity
                //             }</div>
                //         </div>`);
                // });
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
                $("#cart-section").hide("slow");
                $("#receipt-section").show("slow");
                //     },
                //     error: function (error) {
                //         console.log(error);
                //     },
                // });

                // $("#cart-section").hide("slow");
            },
            error: function (error) {
                console.log(error);
            },
        });

        // location.reload();
    });
});
