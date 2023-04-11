@extends('layouts.base')
@section('body')
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <style>
        .img-center {
            margin: 0 auto;
        }

        body {
            background: -webkit-linear-gradient(left, #3931af, #00c6ff);
        }

        .emp-profile {
            padding: 3%;
            margin-top: 3%;
            margin-bottom: 3%;
            border-radius: 0.5rem;
            background: #fff;
        }

        .profile-img {
            text-align: center;
        }

        .profile-img img {
            width: 70%;
            height: 100%;
        }

        .profile-img .file {
            position: relative;
            overflow: hidden;
            margin-top: -20%;
            width: 70%;
            border: none;
            border-radius: 0;
            font-size: 15px;
            background: #212529b8;
        }

        .profile-img .file input {
            position: absolute;
            opacity: 0;
            right: 0;
            top: 0;
        }

        .profile-head h5 {
            color: #333;
        }

        .profile-head h6 {
            color: #0062cc;
        }

        .profile-edit-btn {
            border: none;
            border-radius: 1.5rem;
            width: 70%;
            padding: 2%;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
        }

        .proile-rating {
            font-size: 12px;
            color: #818182;
            margin-top: 5%;
        }

        .proile-rating span {
            color: #495057;
            font-size: 15px;
            font-weight: 600;
        }

        .profile-head .nav-tabs {
            margin-bottom: 5%;
        }

        .profile-head .nav-tabs .nav-link {
            font-weight: 600;
            border: none;
        }

        .profile-head .nav-tabs .nav-link.active {
            border: none;
            border-bottom: 2px solid #0062cc;
        }

        .profile-work {
            padding: 14%;
            margin-top: -15%;
        }

        .profile-work p {
            font-size: 12px;
            color: #818182;
            font-weight: 600;
            margin-top: 10%;
        }

        .profile-work a {
            text-decoration: none;
            color: #495057;
            font-weight: 600;
            font-size: 14px;
        }

        .profile-work ul {
            list-style: none;
        }

        .profile-tab label {
            font-weight: 600;
        }

        .profile-tab p {
            font-weight: 600;
            color: #0062cc;
        }
    </style>

    {{-- @if (session('status'))
                <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif --}}

    {{-- <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
                <div class="card p-4">
                        <div class=" image d-flex flex-column justify-content-center align-items-center"> <button class="btnnn btn-secondary"> <img src="{{ $customer->img_path }}" height="100" width="100" /></button>
                        <div class="d-flex flex-row justify-content-center align-items-center gap-2"> <span class="number">Account : {{ $customer->customer_name }}</span></div>
                        <div class="d-flex flex-row justify-content-center align-items-center gap-2"> <span class="number">Phone : {{ $customer->phone }}</span></div>
                        <div class="d-flex flex-row justify-content-center align-items-center mt-3"> <span class="number">Email : {{ Auth::user()->email }}</span></div>
                        <div class=" px-2 rounded mt-4 date "> <span class="join">Joined {{ Auth::user()->created_at }}</span> </div>
                        <br>
                        <a href="{{ route('editProfile', $customer->id) }}" class="btn btn-info float-right" style="margin-top: 10px;">Edit</a>
                        <a href="{{ route('welcome') }}" class="btn btn-dark float-right" style="margin-top: 10px;">Back</a>
                    </div>
                </div>
            </div> --}}

    <div class="container emp-profile">
        {{-- <form method="post" action="{{ route('editProfile', $customer->id) }}"> --}}
        <div class="row">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="#" alt="" class="rounded-3"id="user_image" />
                        {{-- <div class="file btn btn-lg btn-primary">
                                    Change Photo
                                    <input type="file" name="file"/>
                                </div> --}}
                    </div>
                </div>
                <div class="col-md-6" style="margin-top: 6%;">
                    <div class="profile-head">
                        <h3>
                            {{ Auth::user()->name }}
                        </h3>
                        <br>
                        <br>

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">About</a>
                            </li>
                            @if (Auth::user()->role == 'customer')
                                <li class="nav-item ">
                                    <a class="nav-link active" id="pet-tab" data-toggle="tab" href="#petTab"
                                        role="tab" aria-controls="petTab" aria-selected="false">Pets</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 6%;">
                    {{-- <a href="{{ route('editProfile', $customer->id) }}" class="profile-edit-btn" name="btnAddMore"></a> --}}
                    <div id="edit-btn-div">
                        {{-- <button type="button" class="btn btn-outline-secondary float-right rounded-pill" id="edit-profile-btn"
                            style="margin-top: 10px;">Edit Profile</button> --}}
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary float-right rounded-pill mt-1"
                            id="create_pet_modal_button"data-bs-toggle="modal" data-bs-target="#create_pet_modal">
                            Add pet
                        </button>
                    </div>

                    {{-- <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/> --}}
                </div>
            </div>
            <div>
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Name: </label>
                                <p id="customer_name">{{ Auth::user()->name }}</p>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Email: </label>
                                <p id="email">{{ Auth::user()->email }}</p>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <label>Phone: </label>
                                <p id="phone"></p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Address: </label>
                                <p id="address"></p>
                            </div>

                        </div>
                    </div>
                    {{-- Pet Tab Contents --}}
                    <div class="tab-pane fade show active" id="petTab" role="tabpanel" aria-labelledby="pet-tab">
                        <div class="row mt-3">
                            <div class="row mt-3 align-items-stretch" id="pet-row">
                                {{-- Pet Cards go gere --}}
                            </div>
                        </div>

                    </div>


                    {{-- <div class="tab-pane fade" id="testTab" role="tabpanel" aria-labelledby="test-tab">
                        <div class="row mt-3 align-items-stretch" id="pet-row">


                        </div>
                    </div> --}}
                    {{-- @endif --}}


                </div>
            </div>
        </div>

    </div>

    {{-- Modal START --}}
    <div class="row">
        <!-- Modal Create Pet Body-->
        <div class="modal fade" id="create_pet_modal" tabindex="-1" aria-labelledby="create_pet_modal_label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="create_pet_modal_label">Add New Pet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="create_pet_form" action="#" method="#" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group" id="addPetForm">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="fname">Pet Name</label>
                                        <input type="text" class="form-control" name="pet_name" id="pet_name" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="lname">Age</label>
                                        <input type="text" class="form-control" name="age" id="age"
                                            required>
                                    </div>
                                </div>

                                {{-- <label for="owner">Owner</label>
                                <select class="form-select owner-select" aria-label="role-select" name="owner"
                                    id="owner">
                                </select> --}}

                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Pet Picture</label>
                                    <input class="form-control" type="file" id="img_path" name="img_path"
                                        accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                                id="create_pet_button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Modal Create Pet Body END --}}

    </div>
    {{-- Modal Edit Pet Body --}}
    <div class="row">
        <div class="modal fade" id="update_pet_modal" tabindex="-1" aria-labelledby="update_pet_modal_label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="update_pet_modal_label">Update Pet Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="update_pet_form" action="#" method="#" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" name="pet_id" id="edit-pet_id">
                            <div class="form-group" id="update_pet_form">
                                <div class="row">
                                    <img src="" style="width: 150px" class="rounded-circle img-center"
                                        alt="Pet Placeholder Image" id="img_saved" name="img_saved">
                                    <input class="form-control" type="hidden" id="old_img" name="old_img">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="fname">Pet Name</label>
                                        <input type="text" class="form-control" name="pet_name" id="edit-pet_name"
                                            required>
                                    </div>
                                    <div class="col-6">
                                        <label for="lname">Age</label>
                                        <input type="text" class="form-control" name="age" id="edit-age"
                                            required>
                                    </div>
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
                                id="update_pet_button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Edit Pet Body END --}}
    {{-- Modal END --}}
    {{-- </form>            --}}
    </div>

    {{-- Modal Edit User Body --}}
    <div class="row">
        <div class="modal fade" id="update_user_modal" tabindex="-1" aria-labelledby="update_user_modal_label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="update_user_modal_label">Update User Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="update_user_form" action="#" method="#" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" name="user_id" id="edit-user_id">
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

                                <label for="addressline">Adress</label>
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
                                id="update_user_button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Edit User Body END --}}

    <script src="{{ asset('js/profile.js') }}"></script>
@endsection
