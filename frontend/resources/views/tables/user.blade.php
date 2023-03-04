@extends('dashboard')

@section('table-content')
    <div class="container mt-5"> {{-- User table START --}}
        <div class="row">
            <h2 class="text-center"><strong>User List</strong></h2>
        </div>
        {{-- Modal START --}}
        <div class="row">
            {{-- Modal Button START --}}
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add New User
            </button>
            {{-- Modal Button END --}}
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        {{-- <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div> --}}

                        <form id="form_update_customer" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row m-3">
                                    <div class="col-6">
                                        <label for="fname">First Name</label>
                                        <input type="text" class="form-control" name="fname" id="fname" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="lname">Last Name</label>
                                        <input type="text" class="form-control" name="lname" id="lname" required>
                                    </div>
                                </div>

                                <div class="row m-4">

                                    <label for="update_email_customer" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="update_email_customer"
                                        id="update_email_customer" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="row m-4">
                                    <label for="update_addr_customer" class="form-label">Address</label>
                                    <input type="text" class="form-control" name="update_address_customer"
                                        id="update_address_customer" value="{{ old('addr') }}" required>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>


                                <hr>
                                <div class="row g-6">

                                    <div class="col-12">
                                        <label for="update_img_customer" class="form-label">image</label>
                                        <input type="file" class="form-control-file" id="update_img_customer"
                                            name="update_img_customer" multiple accept="image/*" />
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                                    id="upd_customer_btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        {{-- Modal END --}}
        <div class="row mt-3">
            <div class="col-md-12">
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Extn.</th>
                            <th>Start date</th>
                            <th>Salary</th>
                            <th></th>
                        </tr>
                    </thead>

                </table>

            </div>
        </div>
    </div> {{-- User table END --}}

    <script type="text/javascript" charset="utf8" src="{{ asset('js/user.js') }}"></script>
@endsection
