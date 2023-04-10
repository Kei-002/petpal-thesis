@extends('layouts.base')
@section('body')
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <style>
        /* * {
                    margin: 0;
                    padding: 0;
                }

                body {
                    background-color: #d6e1eb;
                    margin-top: 10%;
                }

                .card {
                    width: 350px;
                    background-color: #efefef;
                    border: none;
                    cursor: pointer;
                    transition: all 0.5s
                }

                .btnnn {
                    height: 130px;
                    width: 130px;
                }

                .image img {
                    transition: all 0.5s
                }

                .card:hover .image img {
                    transform: scale(1.3)
                }

                .name {
                    font-size: 22px;
                    font-weight: bold
                }

                .number {
                    font-size: 15 px;
                    font-weight: bold
                }

                .text span {
                    font-size: 13px;
                    color: #545454;
                    font-weight: 500
                }

                .join {
                    font-size: 14px;
                    color: #a0a0a0;
                    font-weight: bold
                }

                .date {
                    background-color: #ccc
                } */

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
                        <img src="#" alt="" id="user_image"/>
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
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">About</a>
                            </li>
                            @if (Auth::user()->role == 'customer')
                            <li class="nav-item">
                                <a class="nav-link" id="pet-tab" data-toggle="tab" href="#petTab" role="tab"
                                    aria-controls="petTab" aria-selected="false">Pets</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 6%;">
                    {{-- <a href="{{ route('editProfile', $customer->id) }}" class="profile-edit-btn" name="btnAddMore"></a> --}}
                    <div>
                        {{-- <a href="{{ route('editProfile', $customer->id) }}" class="btn btn-outline-secondary float-right rounded-pill" style="margin-top: 10px;">Edit Profile</a> --}}

                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-danger float-right rounded-pill mt-1"
                            data-bs-toggle="modal" data-bs-target="#petModal">
                            Add pet
                        </button>
                    </div>

                    {{-- <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/> --}}
                </div>
            </div>
            <div>
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                    <div class="tab-pane fade" id="petTab" role="tabpanel" aria-labelledby="pet-tab">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <table id="pet_table" class="table table-striped table-bordered dt-responsive nowrap"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Pet Image</th>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Joined On</th>
                                            <th colspan="2">Actions</th>
                                            <th style="display:none;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="pet_table_body">
                                    </tbody>

                                </table>

                            </div>
                        </div>
                        {{-- <div class="row">
                                                <div class="col-md-6">
                                                    <label>Experience</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>Expert</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Hourly Rate</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>10$/hr</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Total Projects</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>230</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>English Level</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>Expert</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Availability</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>6 months</p>
                                                </div>
                                            </div>
                                    --}}
                        {{-- @if (Auth::user()->role == 'customer') --}}

                    </div>
                    {{-- @endif --}}
                </div>
            </div>
        </div>

    </div>
    {{-- </form>            --}}
    </div>

    <script src="{{ asset('js/profile.js') }}"></script>
@endsection
