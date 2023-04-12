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

    // $.ajax({
    //     url: "/api/get-all-services",
    //     type: "GET",
    //     processData: false, // Important!
    //     contentType: false,
    //     dataType: "json",
    //     success: function (data) {
    //         var services = data.services;
    //         console.log(services);
    //         // $(".category-list").empty();
    //         $("#service-list").empty();

    //         $.each(services, function (key, service) {
    //             // console.log(category.category_name);
    //             $("#service-list").append(`
    //             <div class="col mb-5">
    //                 <div class="card h-100">
    //                     <!-- Product image-->
    //                     <img class="card-img-top" src="${service.img_path}" alt="..." />
    //                     <!-- Product details-->
    //                     <div class="card-body p-4">
    //                         <div class="text-center">
    //                             <!-- Product name-->
    //                             <h5 class="fw-bolder">${service.groom_name}</h5>
    //                             <!-- Product reviews-->
    //                             <div class="d-flex justify-content-center small text-warning mb-2">
    //                                 <div class="bi-star-fill"></div>
    //                                 <div class="bi-star-fill"></div>
    //                                 <div class="bi-star-fill"></div>
    //                                 <div class="bi-star-fill"></div>
    //                                 <div class="bi-star-fill"></div>
    //                             </div>
    //                             <!-- Product price-->
    //                             ${service.price}
    //                         </div>
    //                     </div>
    //                     <!-- Product actions-->
    //                     <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
    //                         <div class="text-center"><a type="button" id="add-to-cart" class="btn btn-outline-dark mt-auto"
    //                             data-id="${service.id}"
    //                             data-name="${service.groom_name}"
    //                             data-price="${service.price}"
    //                             data-image="${service.img_path}"">
    //                         Add to cart</a></div>

    //                     </div>
    //                 </div>
    //             </div>`);
    //         });

    //         // console.log(category_with_count);
    //     },
    // });

    $("#service-list").on("click", "button#add-to-cart", function (e) {
        e.preventDefault();
        // var pet_id = $(this).siblings("#pet-select").val();
        var name = $(this).data("name");
        var image = $(this).data("image");
        var price = Number($(this).data("price"));
        var id = Number($(this).data("id"));
        // console.log(id, pet_id);
        unique_id = Date.now() + Math.random();
        cart.addService({
            uid: unique_id,
            id: id,
            name: name,
            image: image,
            price: price,
            pet_id: null,
            pet_name: null,
            quantity: 1,
        });
        console.log(cart.services);
        addQuantityText();
        toastr.success("Service " + name + " added to cart");
    });

    $(".product-list").on("click", "div#product", function () {
        var id = $(this).data("id");
        // console.log(id);
        location.href = "/product?id=" + id;
    });

    function addQuantityText() {
        var old_quantity = $("#cartHtml span").text();
        var new_quantity = Number(old_quantity) + 1;
        $("#cartHtml span").text(new_quantity);
        // console.log(new_quantity);
    }
});
