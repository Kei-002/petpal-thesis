@extends('layouts.base')
@section('body')
    <style>
        body {
            background-color: #FFEBEE
        }

        #body-consult .card {
            width: 400px;
            background-color: #fff;
            border: none;
            border-radius: 12px
        }

        #body-consult label.radio {
            cursor: pointer;
            width: 100%
        }

        #body-consult label.radio input {
            position: absolute;
            top: 0;
            left: 0;
            visibility: hidden;
            pointer-events: none
        }

        #body-consult label.radio span {
            padding: 7px 14px;
            border: 2px solid #eee;
            display: inline-block;
            color: #039be5;
            border-radius: 10px;
            width: 100%;
            height: 48px;
            line-height: 27px
        }

        #body-consult label.radio input:checked+span {
            border-color: #039BE5;
            background-color: #81D4FA;
            color: #fff;
            border-radius: 9px;
            height: 48px;
            line-height: 27px
        }

        #body-consult .form-control {
            margin-top: 10px;
            height: 48px;
            border: 2px solid #eee;
            border-radius: 10px
        }

        #body-consult .form-control:focus {
            box-shadow: none;
            border: 2px solid #039BE5
        }

        #body-consult .agree-text {
            font-size: 12px
        }

        #body-consult .terms {
            font-size: 12px;
            text-decoration: none;
            color: #039BE5
        }

        #body-consult .confirm-button {
            height: 50px;
            border-radius: 10px
        }
    </style>
    <div id="appointment">
        <div class="container mt-5 mb-5 d-flex justify-content-center" id="body-consult">
            <div class="card px-1 py-4">
                <div class="card-body">
                    <form id="consultation_form" action="#" method="#" enctype="multipart/form-data">
                        <h6 class="card-title mb-3">This appointment is for</h6>
                        <div class="d-flex flex-row" id="pet-radio" name="pet-radio">
                            {{-- <label class="radio mr-1"> 
                        <input type="radio" name="add" value="anz" checked> <span> <i class="fa fa-user"></i> Anz CMK </span> </label> --}}
                            {{-- <label class="radio"> 
                        <input type="radio" name="add" value="add"> <span> <i class="fa fa-plus-circle"></i> Add</span> </label>  --}}
                        </div>
                        <h6 class="information mt-4">Please provide following information for the consultation</h6>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="startDate">Appointment Date</label>
                                    <div class="input-group">
                                        <input id="startDate" name="startDate" class="form-control" type="date"
                                            placeholder="Appointment Date" />
                                        {{-- <span id="startDateSelected"></span> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <textarea id="description" name="description" rows="5" class="form-control" type="text"
                                            placeholder="Describe condition of pet" style="height: auto;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class=" d-flex flex-column text-center px-5 mt-3 mb-3"> <small class="agree-text">By Booking this
                        appointment you agree to the</small> <a href="#" class="terms">Terms & Conditions</a> </div> --}}
                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block confirm-button">Confirm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="thank-you">
        <div class="vh-100 d-flex justify-content-center align-items-center">
            <div>
                <div class="mb-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                        fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                </div>
                <div class="text-center">
                    <h1>Thank You !</h1>
                    <p>We received your appointment request;
                        we'll be in touch shortly! </p>
                    <button class="btn btn-success" id="another-appoint">Schedule Another Appointment</button>
                    <a href="{{url('/')}}"class="btn btn-primary">Back Home</a>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            var d = new Date();
            let startDate = document.getElementById('startDate')
            d.setDate(d.getDate() + 3);
            startDate.valueAsDate = d;

        })

        startDate.addEventListener('change', (e) => {
            let startDateVal = e.target.value
            console.log(startDateVal);
            // document.getElementById('startDateSelected').innerText = startDateVal
        })
    </script>

    <script src="{{ asset('js/consultation.js') }}"></script>
@endsection
