$(document).ready(function () {
    const myUrl = new URL(window.location.toLocaleString());
    var product_id = myUrl.searchParams.get("id");
    // console.log(test);

    $("#loading-spinner").show();

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
        url: "/api/get-product/" + product_id,
        type: "GET",
        processData: false, // Important!
        contentType: false,
        dataType: "json",
        success: function (data) {
            console.log(data);
            $product = data.product;
            $("#product_name").html(
                `${$product.product_name}
                        <small class="text-info">${data.category}</small>
                        <i class="fa fa-star fa-2x text-warning"></i>
                        <i class="fa fa-star fa-2x text-warning"></i>
                        <i class="fa fa-star fa-2x text-warning"></i>
                        <i class="fa fa-star fa-2x text-warning"></i>
                        <i class="fa fa-star fa-2x text-muted"></i>
                        <span class="fa fa-2x">
                            <h5>(109) Votes</h5>
                        </span>
                        <a href="javascript:void(0);">109 customer reviews</a>`
            );

            $("#more-information p").text($product.description);

            $("#add-to-cart").append(
                `<div class="col-sm-12 col-md-6 col-lg-6">
                            <button type="button" class="btn btn-success btn-lg" id="add-to-cart-btn" data-id="${$product.id}" 
                                        data-name="${$product.product_name}"
                                        data-price="${$product.sell_price}"
                                        data-image="${$product.img_path}">Add to cart ($${$product.sell_price})</button>
                        </div>`
            );

            $("#loading-spinner").addClass("d-none");
            // $(".loading-spinner").hide();
            $(".product-body").removeAttr("hidden");
            // $(".product-body").show();
        },
    });

    $("#add-to-cart").on("click", "button#add-to-cart-btn", function (e) {
        e.preventDefault();
        var name = $(this).data("name");
        var image = $(this).data("image");
        var price = Number($(this).data("price"));
        var id = Number($(this).data("id"));
        console.log(id, name);
        cart.add({
            id: id,
            name: name,
            image: image,
            price: price,
            quantity: 1,
        });
        toastr.success("Product " + name + " added to cart");
    });
});
