@extends('dashboard')

@section('table-content')
    <div class="container mt-5"> {{-- Customer table START --}}
        <div class="row">
            <h2 class="text-center"><strong>Customer List</strong></h2>
        </div>
        {{-- Modal START --}}
        <div class="row">
            {{-- Modal Button START --}}
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_customer_modal">
                Add New Customer
            </button>
            {{-- Modal Button END --}}
            <!-- Modal Create customer Body-->
            <div class="modal fade" id="create_customer_modal" tabindex="-1" aria-labelledby="create_customer_modal_label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="create_customer_modal_label">Add New Customer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="create_customer_form" action="#" method="#" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group" id="addCustomerForm">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="fname">First Name</label>
                                            <input type="text" class="form-control" name="fname" id="fname"
                                                required>
                                        </div>
                                        <div class="col-6">
                                            <label for="lname">Last Name</label>
                                            <input type="text" class="form-control" name="lname" id="lname"
                                                required>
                                        </div>
                                    </div>

                                    <label for="addressline">Address</label>
                                    <input type="text" class="form-control" name="addressline" id="addressline">

                                    <label for="lname">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" id="phone">

                                    <label for="lname">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" required>

                                    <label for="password">Password</label>
                                    <div class="input-group mb-3" id="show_hide_password1">
                                        <input type="password" class="form-control" name="password1" id="password1"
                                            aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                                                class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                    </div>
                                    <label for="lname">Confirm Password</label>
                                    <div class="input-group mb-3" id="show_hide_password2">
                                        <input type="password" class="form-control" name="password2" id="password2"
                                            aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                                                class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                    </div>

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
                                    id="create_customer_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Modal Create Customer Body END --}}

        </div>
        {{-- Modal Edit Customer Body --}}
        <div class="row">
            <div class="modal fade" id="update_customer_modal" tabindex="-1"
                aria-labelledby="update_customer_modal_label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="update_customer_modal_label">Update customer Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="update_customer_form" action="#" method="#" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" class="form-control" name="customer_id" id="edit-customer_id">
                                <div class="form-group" id="update_customer_form">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="fname">First Name</label>
                                            <input type="text" class="form-control" name="fname" id="edit-fname"
                                                required>
                                        </div>
                                        <div class="col-6">
                                            <label for="lname">Last Name</label>
                                            <input type="text" class="form-control" name="lname" id="edit-lname"
                                                required>
                                        </div>
                                    </div>

                                    <label for="addressline">Address</label>
                                    <input type="text" class="form-control" name="addressline" id="edit-addressline">

                                    <label for="lname">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" id="edit-phone">

                                    <label for="lname">Email</label>
                                    <input type="email" class="form-control" name="email" id="edit-email" required>

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
                                    id="update_customer_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Edit User Body END --}}
        {{-- Modal END --}}
        <div class="row mt-3">
            <div class="col-md-12">
                <table id="customer_table" class="table table-striped table-bordered dt-responsive nowrap"
                    cellspacing="0" style="table-layout:fixed;
                    width:100%;">
                    <thead>
                        <tr>
                            <th>Profile Picture</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th style="word-wrap: break-word">Address</th>
                            <th>Phone</th>
                            <th>Joined On</th>
                            <th colspan="2">Actions</th>
                            <th style="display:none;"></th>
                        </tr>
                    </thead>
                    <tbody id="customer_table_body">

                    </tbody>

                </table>

            </div>
        </div>
    </div> {{-- User table END --}}

    <script type="text/javascript" charset="utf8" src="{{ asset('js/customer.js') }}"></script>
@endsection
