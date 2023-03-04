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
                        <form id="" action="#" method="#" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
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

                                    <label for="lname">Email</label>
                                    <input type="email" class="form-control" name="lname" id="lname" required>
                                    {{-- <label for="lname">Password</label>
                                    <input type="password" class="form-control" name="lname" id="lname" required>
                                    <label for="lname">Confirm Password</label>
                                    <input type="password" class="form-control" name="lname" id="lname" required> --}}
                                    <label for="lname">Password</label>
                                    <div class="input-group mb-3" id="show_hide_password1">
                                        <input type="text" class="form-control" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                                                class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                    </div>
                                    <label for="lname">Confirm Password</label>
                                    <div class="input-group mb-3" id="show_hide_password2">
                                        <input type="text" class="form-control" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                                                class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                                    id="customer_submit">Submit</button>
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
