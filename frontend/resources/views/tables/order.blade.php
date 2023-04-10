@extends('dashboard')

@section('table-content')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>

    <div class="container mt-5"> {{-- Order table START --}}
        <div class="row">
            <h2 class="text-center"><strong>Order List</strong></h2>
        </div>
        {{-- Modal START --}}
        <div class="row">
            {{-- Modal Button START --}}
            {{-- <button type="button" class="btn btn-primary" id="create_order_modal_button"data-bs-toggle="modal"
                data-bs-target="#create_order_modal">
                Add New Order
            </button> --}}
            {{-- Modal Button END --}}
            <!-- Modal Create Order Body-->
            {{-- <div class="modal fade" id="create_order_modal" tabindex="-1" aria-labelledby="create_order_modal_label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="create_order_modal_label">Add New Order</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="create_order_form" action="#" method="#" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group" id="addOrderForm">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="fname">Order Name</label>
                                            <input type="text" class="form-control" name="order_name" id="order_name"
                                                required>
                                        </div>
                                        <div class="col-6">
                                            <label for="lname">Age</label>
                                            <input type="text" class="form-control" name="age" id="age"
                                                required>
                                        </div>
                                    </div>

                                    <label for="owner">Owner</label>
                                    <select class="form-select owner-select" aria-label="role-select" name="owner"
                                        id="owner">
                                    </select>

                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Order Picture</label>
                                        <input class="form-control" type="file" id="img_path" name="img_path"
                                            accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                                    id="create_order_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
            {{-- Modal Create Order Body END --}}

        </div>
        {{-- Modal Edit Order Body --}}
        <div class="row">
            <div class="modal fade" id="update_order_modal" tabindex="-1" aria-labelledby="update_order_modal_label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="update_order_modal_label">Update Order Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="update_order_form" action="#" method="#" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" class="form-control" name="order_id" id="edit-order_id">
                                <div class="form-group" id="update_customer_form">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="fname">Order Name</label>
                                            <input type="text" class="form-control" name="order_name"
                                                id="edit-order_name" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="lname">Age</label>
                                            <input type="text" class="form-control" name="age" id="edit-age"
                                                required>
                                        </div>
                                    </div>

                                    <label for="role">Owner</label>
                                    <select class="form-select edit-owner-select" aria-label="role-select" name="owner"
                                        id="edit-owner">
                                    </select>

                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Image</label>
                                        <input class="form-control" type="file" id="img_path" name="img_path"
                                            accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                                    id="update_order_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Edit Order Body END --}}
        {{-- Modal END --}}
        <div class="row mt-3">
            <div class="col-md-12">
                <table id="order_table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Owner</th>
                            <th>Address</th>
                            <th>Payment Status</th>
                            <th>Total Purchase</th>
                            {{-- <th>Purchase Date</th> --}}
                            <th>Purchase Date</th>
                            {{-- <th>Receipt</th> --}}
                            <th colspan="2">Actions</th>
                            <th style="display:none;"></th>
                        </tr>
                    </thead>
                    <tbody id="order_table_body">
                    </tbody>

                </table>

            </div>
        </div>
    </div> {{-- Order table END --}}
    <script>
        $.ajax({
            url: "/api/all-orders",
            type: "GET",
            processData: false, // Important!
            contentType: false,
            dataType: "json",
            beforeSend: function(xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + localStorage.getItem("token")
                );
            },
            success: function(json) {
                console.log(json)
                //   let z = Object.assign(json.transactions, json.receipts);
                //   $.extend(json.transactions, json.receipts);
                // var transactions = json.transactions
                // var receipts = json.receipts
                // // jsonArray1.concat(jsonArray2)
                // var jsonArrayTest = transactions.concat(receipts);
                // console.log(jsonArrayTest);
                // return z;



                // Testing
                // arrayList = [], obj_c_processed = [];
                // var g = json.transactions
                // var c = json.receipts
                // for (var i in g) {
                //     var obj = {
                //         id: g[i].id,
                //         payment_status: g[i].payment_status,
                //         transactionlines: g[i].transactionlines,
                //         created_at: g[i].created_at
                //     };

                //     for (var j in c) {
                //         if (g[i].id == c[j].item_id) {
                //             obj.payment_status = c[j].payment_status;
                //             obj_c_processed[c[j].id] = true;
                //         }
                //     }

                //     // obj.circle = obj.circle || 'no';
                //     arrayList.push(obj);
                // }

                // for (var j in c) {
                //     if (typeof obj_c_processed[c[j].id] == 'undefined') {
                //         arrayList.push({
                //             id: c[j].id,
                //             item_id: c[j].item_id,
                //             customer_name: c[j].fname + " " +c[j].lname,
                //             payment_status: c[j].payment_status,
                //             created_at: c[j].created_at
                //         });
                //     }
                // }

                // console.log(arrayList);

                    arrayList = [], obj_c_processed = [];
                var g = json.orders;
                var c = json.receipts;
                for (var i in g) {
                    var obj = {
                        id: g[i].id,
                        customer_name: g[i].customer_name,
                        address: g[i].address,
                        total_purchase: g[i].total_purchase,
                        payment_status: g[i].payment_status,
                        orderlines: g[i].orderlines,
                        created_at: g[i].created_at,
                        receipt_path: g[i].receipt_path,
                        receipt_id: g[i].receipt_id,
                    };

                    for (var j in c) {
                        if (g[i].id == c[j].item_id) {
                            obj.payment_status = c[j].payment_status;
                            obj.receipt_path = c[j].receipt_path;
                            obj.address = c[j].addressline;
                            obj.total_purchase = c[j].total_purchase;
                            obj.receipt_id = c[j].id;
                            obj.customer_name = c[j].fname + " " + c[j].lname;
                            obj_c_processed[c[j].id] = true;
                        }
                    }

                    // obj.circle = obj.circle || 'no';
                    arrayList.push(obj);
                }

                for (var j in c) {
                    if (typeof obj_c_processed[c[j].id] == "undefined") {
                        arrayList.push({
                            id: c[j].id,
                            item_id: c[j].item_id,
                            customer_name: c[j].fname + " " + c[j].lname,
                            payment_status: c[j].payment_status,
                            address: c[j].addressline,
                            receipt_path: c[j].receipt_path,
                            created_at: c[j].created_at,
                        });
                    }
                }

                console.log(arrayList, c);
            },
        });
    </script>
    <script type="text/javascript" charset="utf8" src="{{ asset('js/order.js') }}"></script>
@endsection
