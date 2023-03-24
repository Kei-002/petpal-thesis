$(document).ready(function () {
    // Toastr Options
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

    var date_options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
    };

    // Fill datatable
    $("#product_table").DataTable({
        processing: true,
        info: true,
        stateSave: true,
        ajax: {
            url: "/api/product",
            dataSrc: "",
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + localStorage.getItem("token")
                );
            },
            // success: function (data) {
            //     console.log(data);
            // },
        },
        order: [0, "dec"],
        // data: data,
        columns: [
            {
                data: null,
                render: function (data, type, JsonResultRow, row) {
                    return (
                        '<img src="' +
                        data.img_path +
                        '" class="rounded-circle"height="100px" width="100px">'
                    );
                },
            },
            { data: "product_name" },
            {
                data: null,
                render: function (data, type, row) {
                    console.log(data.category.category_name);
                    return data.category.category_name;
                },
            },
            { data: "cost_price" },
            { data: "sell_price" },
            { data: "description" },
            // { data: "created_at" },

            // Format created_at to {weekday}, {year}, {month}, {day}, {hour}, {minute}
            // {
            //     data: null,
            //     render: function (data, type, row) {
            //         var d = new Date(data.created_at);
            //         return d.toLocaleDateString("en-US", date_options);
            //     },
            // },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        "<a href=#'' class='product_edit' id='product_edit' data-id=" +
                        data.id +
                        "><i class='fa-solid fa-pen' aria-hidden='true' style='font-size:24px' ></i></a>"
                    );
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        "<a href='#' class='product_delete' id='product_delete' data-id=" +
                        data.id +
                        "><i class='fa-solid fa-trash-can' aria-hidden='true' style='font-size:24px; color:red;'></a></i>"
                    );
                },
            },
        ],
    });

    // Clear modal when close
    $("#create_product_modal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });
    $("#update_product_modal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });

    // Load customer to select options input
    $.ajax({
        url: "/api/category",
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
            $category_list = $("#category");
            $edit_category_list = $("#edit-category");
            $.each(data, function (key, value) {
                // console.log(key, value);
                $category_list.append(
                    `<option value="${value.id}">${value.category_name}</option>`
                );
                $edit_category_list.append(
                    `<option value="${value.id}">${value.category_name}</option>`
                );
            });
        },
    });

    // Set select option to select2
    // $(".owner-select").select2();
    $(".category-select").select2({
        dropdownParent: $("#create_product_modal"),
        placeholder: "Select product category",
        theme: "bootstrap-5",
    });

    $(".edit-category-select").select2({
        dropdownParent: $("#update_product_modal"),
        placeholder: "Select product category",
        theme: "bootstrap-5",
    });

    // Product Submit
    $("#create_product_button").on("click", function (e) {
        e.preventDefault();
        var data = $("#create_product_form")[0];
        console.log(data);
        let formData = new FormData(data);
        console.log(formData);
        for (var pair of formData.entries()) {
            console.log(pair[0] + "," + pair[1]);
        }

        // var data = $("#createform").serialize();
        // console.log(data);
        $.ajax({
            type: "POST",
            url: "/api/product",
            data: formData,
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
            },

            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#create_product_modal").modal("hide");
                toastr.success(data.message);
                // var $tableData = $("#productTable").DataTable();
                $("#product_table").DataTable().ajax.reload();
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    // Product Delete
    $("#product_table #product_table_body").on(
        "click",
        "a.product_delete",
        function (e) {
            e.preventDefault();
            var table = $("#product_table").DataTable();
            var id = $(this).data("id");
            var $row = $(this).closest("tr");

            console.log(id);

            bootbox.confirm({
                message: "Do You Want To Delete This Product?",
                buttons: {
                    confirm: {
                        label: "Yes",
                        className: "btn-success",
                    },
                    cancel: {
                        label: "No",
                        className: "btn-danger",
                    },
                },
                callback: function (result) {
                    console.log(result);
                    if (result)
                        $.ajax({
                            type: "DELETE",
                            url: "/api/product/" + id,
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),

                                // Authorization:
                                //     "Bearer " + localStorage.getItem("token"),
                            },
                            beforeSend: function (xhr) {
                                xhr.setRequestHeader(
                                    "Authorization",
                                    "Bearer " + localStorage.getItem("token")
                                );
                            },

                            dataType: "json",
                            contentType: "application/json",
                            success: function (data) {
                                console.log(data);
                                // bootbox.alert('success');
                                $row.fadeOut(2000, function () {
                                    table.row($row).remove().draw(false);
                                });
                                toastr.success(data.message);
                            },
                            error: function (error) {
                                console.log(error);
                            },
                        });
                },
            });
        }
    );

    // Product Edit
    $("#product_table #product_table_body").on(
        "click",
        "a.product_edit",
        function (e) {
            e.preventDefault();
            //
            var id = $(this).data("id");
            // var id = $(e.relatedTarget).attr("id");
            console.log(id);

            $.ajax({
                type: "GET",
                enctype: "multipart/form-data",
                processData: false, // Important!
                contentType: false,
                cache: false,
                url: "/api/product/" + id + "/edit",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                beforeSend: function (xhr) {
                    xhr.setRequestHeader(
                        "Authorization",
                        "Bearer " + localStorage.getItem("token")
                    );
                },
                dataType: "json",
                success: function (data) {
                    $("#update_product_modal").modal("show");
                    $product = data.product;
                    console.log($product);
                    $("#edit-product_id").val($product.id);
                    $("#edit-product_name").val($product.product_name);
                    $("#edit-cost_price").val($product.cost_price);
                    $("#edit-sell_price").val($product.sell_price);
                    $("#edit-description").val($product.description);
                    // Set current owner in select option
                    $(".edit-category-select")
                        .val($product.category_id)
                        .trigger("change");
                },
                error: function (error) {
                    console.log("error");
                },
            });
        }
    );

    // Product Update
    $("#update_product_button").on("click", function (e) {
        e.preventDefault();
        var id = $("#edit-product_id").val();
        console.log(id);
        var data = $("#update_product_form")[0];
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
            url: "/api/product-update/" + id,
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
                // console.log(data.img_path);
                $("#update_product_modal").modal("hide");
                $("#product_table").DataTable().ajax.reload();
                console.log("data", data);
                // console.log("message", data.message);
                // console.log("request", data.request);
                toastr.success(data.message);
            },
            error: function (error) {
                console.log("error", error);
            },
        });
    });
}); //Document Ready END
