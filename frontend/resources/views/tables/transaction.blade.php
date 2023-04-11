@extends('dashboard')

@section('table-content')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>

    <div class="container mt-5"> {{-- Transaction table START --}}
        <div class="row">
            <h2 class="text-center"><strong>Transaction List</strong></h2>
        </div>
        {{-- Modal START --}}
        <div class="row">
            {{-- Modal Button START --}}
            {{-- <button type="button" class="btn btn-primary" id="create_transaction_modal_button"data-bs-toggle="modal"
                data-bs-target="#create_transaction_modal">
                Add New Transaction
            </button> --}}
            {{-- Modal Button END --}}
            <!-- Modal Create Transaction Body-->
            {{-- <div class="modal fade" id="create_transaction_modal" tabindex="-1" aria-labelledby="create_transaction_modal_label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="create_transaction_modal_label">Add New Transaction</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="create_transaction_form" action="#" method="#" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group" id="addTransactionForm">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="fname">Transaction Name</label>
                                            <input type="text" class="form-control" name="transaction_name" id="transaction_name"
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
                                        <label for="formFile" class="form-label">Transaction Picture</label>
                                        <input class="form-control" type="file" id="img_path" name="img_path"
                                            accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                                    id="create_transaction_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
            {{-- Modal Create Transaction Body END --}}

        </div>
        {{-- Modal Edit Transaction Body --}}
        <div class="row">
            <div class="modal fade" id="update_transaction_modal" tabindex="-1" aria-labelledby="update_transaction_modal_label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="update_transaction_modal_label">Update Transaction Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="update_transaction_form" action="#" method="#" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" class="form-control" name="transaction_id" id="edit-transaction_id">
                                <div class="form-group" id="update_customer_form">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="fname">Transaction Name</label>
                                            <input type="text" class="form-control" name="transaction_name"
                                                id="edit-transaction_name" required>
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
                                    id="update_transaction_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Edit Transaction Body END --}}
        {{-- Modal END --}}
        <div class="row mt-3">
            <div class="col-md-12">
                <table id="transaction_table" class="table table-striped table-btransactioned dt-responsive nowrap" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
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
                    <tbody id="transaction_table_body">
                    </tbody>

                </table>

            </div>
        </div>
    </div> {{-- Transaction table END --}}
    <script type="text/javascript" charset="utf8" src="{{ asset('js/transaction.js') }}"></script>
@endsection
