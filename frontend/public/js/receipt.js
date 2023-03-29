$(document).ready(function () {
    const myUrl2 = new URL(window.location.toLocaleString());
    console.log(
        myUrl2,
        myUrl2.searchParams.get("order_id"),
        myUrl2.searchParams.get("transaction_id")
    );

    var order_id = myUrl2.searchParams.get("order_id");
    var transaction_id = myUrl2.searchParams.get("transaction_id");

    // console.log(myUrl2, order_id, transaction_id);
    var all_info = { order_id: order_id, transaction_id: transaction_id };
    $.ajax({
        url: "/api/receipt-info",
        type: "GET",
        data: JSON.stringify(all_info),
        processData: false, // Important!
        contentType: false,
        dataType: "json",
        success: function (data) {
            console.log(data);
            // $(".category-list").empty();
            // $(".product-list").empty();
            // var total_count = 0;
            // var category_with_count = [];
            // $categories = data.categories;
            // $products = data.products;
            // $category_count = data.category_count;
            // $.each($categories, function (key, category) {
            //     // console.log(category.category_name);
            //     $.each($category_count, function (key, value) {
            //         // console.log(value.total);
            //         if (value.id == category.id) {
            //             if (value.total) {
            //                 total_count = value.total;
            //             }
            //             category_with_count.push({
            //                 id: category.id,
            //                 category_name: category.category_name,
            //                 total: total_count,
            //             });
            //         }
            //     });
            // });
            // $.each(category_with_count, function (key, category) {
            //     // console.log(category.category_name);
            //     $(".category-list").append(`<li
            //                 class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
            //                 ${category.category_name} <span class="badge badge-primary badge-pill">${category.total}</span> </li>`);
            // });
            // $.each($products, function (key, product) {
            //     // console.log(category.category_name);
            //     $(
            //         ".product-list"
            //     ).append(`<div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-3">
            //                 <div class="card"> <img class="card-img-top product-img mx-auto"
            //                         src="${product.img_path}">
            //                     <div class="card-body">
            //                         <h6 class="font-weight-bold pt-1">${product.product_name}</h6>
            //                         <div class="text-muted description">${product.description}</div>
            //                         <div class="d-flex align-items-center product"> <span class="fas fa-star"></span>
            //                             <span class="fas fa-star"></span> <span class="fas fa-star"></span> <span
            //                                 class="fas fa-star"></span> <span class="far fa-star"></span>
            //                         </div>
            //                         <div class="d-flex align-items-center justify-content-between pt-3">
            //                             <div class="d-flex flex-column">
            //                                 <div class="h6 font-weight-bold">$${product.sell_price}</div>
            //                             </div>
            //                             <button type="button" id="add-to-cart" class="btn btn-primary"
            //                             data-id="${product.id}"
            //                             data-name="${product.product_name}"
            //                             data-price="${product.sell_price}"
            //                             data-image="${product.img_path}"
            //                             >Add to cart</button>
            //                         </div>
            //                     </div>
            //                 </div>
            //             </div>`);
            // });
            // console.log(category_with_count);
        },
    });
});
