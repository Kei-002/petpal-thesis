$(document).ready(function () {
    toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: false,
        progressBar: false,
        positionClass: "toast-top-right",
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "slideDown",
        hideMethod: "slideUp",
    };

    // Get cart from localStorage
    cartObj = JSON.parse(localStorage.getItem("cart")) || [];
    // console.log();
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

    $.ajax({
        url: "/api/get-all-products",
        type: "GET",
        processData: false, // Important!
        contentType: false,
        dataType: "json",
        success: function (data) {
            $(".category-list").empty();
            $(".product-list").empty();
            var total_count = 0;
            var category_with_count = [];
            $categories = data.categories;
            $products = data.products;
            $category_count = data.category_count;

            $.each($categories, function (key, category) {
                // console.log(category.category_name);
                $.each($category_count, function (key, value) {
                    // console.log(value.total);
                    if (value.id == category.id) {
                        if (value.total) {
                            total_count = value.total;
                        }
                        category_with_count.push({
                            id: category.id,
                            category_name: category.category_name,
                            total: total_count,
                        });
                    }
                });
            });

            $.each(category_with_count, function (key, category) {
                // console.log(category.category_name);
                $(".category-list").append(`<li
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
                            ${category.category_name} <span class="badge badge-primary badge-pill">${category.total}</span> </li>`);
            });

            $.each($products, function (key, product) {
                // console.log(category.category_name);
                $(
                    ".product-list"
                ).append(`<div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-3">
                            <div class="card"> <img class="card-img-top product-img mx-auto"
                                    src="${product.img_path}">
                                <div class="card-body">
                                    <h6 class="font-weight-bold pt-1">${product.product_name}</h6>
                                    <div class="text-muted description">${product.description}</div>
                                    <div class="d-flex align-items-center product"> <span class="fas fa-star"></span>
                                        <span class="fas fa-star"></span> <span class="fas fa-star"></span> <span
                                            class="fas fa-star"></span> <span class="far fa-star"></span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between pt-3">
                                        <div class="d-flex flex-column">
                                            <div class="h6 font-weight-bold">$${product.sell_price}</div>
                                        </div>
                                        <button type="button" id="add-to-cart" class="btn btn-primary"
                                        data-id="${product.id}" 
                                        data-name="${product.product_name}"
                                        data-price="${product.sell_price}"
                                        data-image="${product.img_path}"
                                        >Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>`);
            });

            // console.log(category_with_count);
        },
    });

    $(".product-list").on("click", "button#add-to-cart", function (e) {
        e.preventDefault();
        var name = $(this).data("name");
        var image = $(this).data("image");
        var price = Number($(this).data("price"));
        var id = Number($(this).data("id"));
        cart.add({
            id: id,
            name: name,
            image: image,
            price: price,
            quantity: 1,
        });
        toastr.success("Product " + name + " added to cart");
    });

    // Clear items
    $(".clear-cart").click(function () {
        shoppingCart.clearCart();
        displayCart();
    });
});
