@extends('dashboard')

@section('table-content')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>

    <div class="container mt-5"> {{-- Product table START --}}
        <div class="row">
            <h2 class="text-center"><strong>Product List</strong></h2>
        </div>
        {{-- Modal START --}}
        <div class="row">
            {{-- Modal Button START --}}
            <button type="button" class="btn btn-primary" id="create_product_modal_button"data-bs-toggle="modal"
                data-bs-target="#create_product_modal">
                Add New Product
            </button>
            {{-- Modal Button END --}}
            <!-- Modal Create Product Body-->
            <div class="modal fade" id="create_product_modal" tabindex="-1" aria-labelledby="create_product_modal_label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="create_product_modal_label">Add New Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="create_product_form" action="#" method="#" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group" id="addProductForm">

                                     <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" id="product_name" required>
                                    <label for="category">Product Category</label>
                                    <select class="form-select category-select" aria-label="role-select" name="category"
                                        id="category">
                                    </select>
                                    <label for="fname">Cost Price</label>
                                    <input type="text" class="form-control" name="cost_price" id="cost_price" required>
                                    <label for="fname">Sell Price</label>
                                    <input type="text" class="form-control" name="sell_price" id="sell_price" required>
                                    <label for="fname">Description</label>
                                    <textarea class="form-control" rows="3"  name="description" id="description" required></textarea>
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
                                    id="create_product_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Modal Create Product Body END --}}

        </div>
        {{-- Modal Edit Product Body --}}
        <div class="row">
            <div class="modal fade" id="update_product_modal" tabindex="-1" aria-labelledby="update_product_modal_label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="update_product_modal_label">Update Product Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="update_product_form" action="#" method="#" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" class="form-control" name="product_id" id="edit-product_id">
                                <div class="form-group" id="update_customer_form">

                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" id="edit-product_name" required>
                                    <label for="category">Product Category</label>
                                    <select class="form-select edit-category-select" aria-label="role-select" name="category"
                                        id="edit-category">
                                    </select>
                                    <label for="fname">Cost Price</label>
                                    <input type="text" class="form-control" name="cost_price" id="edit-cost_price" required>
                                    <label for="fname">Sell Price</label>
                                    <input type="text" class="form-control" name="sell_price" id="edit-sell_price" required>
                                    <label for="fname">Description</label>
                                    <textarea class="form-control" rows="3"  name="description" id="edit-description" required></textarea>
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
                                    id="update_product_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Edit Product Body END --}}
        {{-- Modal END --}}
        <div class="row mt-3">
            <div class="col-md-12">
                <table id="product_table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Cost Price</th>
                            <th>Sell Price</th>
                            <th>Description</th>
                            <th colspan="2">Actions</th>
                            <th style="display:none;"></th>
                        </tr>
                    </thead>
                    <tbody id="product_table_body">
                    </tbody>

                </table>

            </div>
        </div>
    </div> {{-- Service table END --}}

    <script type="text/javascript" charset="utf8" src="{{ asset('js/product.js') }}"></script>
@endsection
