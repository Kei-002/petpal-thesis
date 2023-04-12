@extends('layouts.base')
@section('body')
    <style>
        body {
            background: rgb(80, 201, 195);
            background: linear-gradient(59deg, rgba(80, 201, 195, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }

        #signUpForm {
            max-width: 500px;
            background-color: #ffffff;
            margin: 40px auto;
            padding: 40px;
            box-shadow: 0px 6px 18px rgb(0 0 0 / 9%);
            border-radius: 12px;
        }

        #signUpForm .form-header {
            gap: 5px;
            text-align: center;
            font-size: .9em;
        }

        #signUpForm .form-header .stepIndicator {
            position: relative;
            flex: 1;
            padding-bottom: 30px;
        }

        #signUpForm .form-header .stepIndicator.active {
            font-weight: 600;
        }

        #signUpForm .form-header .stepIndicator.finish {
            font-weight: 600;
            color: #009688;
        }

        #signUpForm .form-header .stepIndicator::before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            z-index: 9;
            width: 20px;
            height: 20px;
            background-color: #d5efed;
            border-radius: 50%;
            border: 3px solid #ecf5f4;
        }

        #signUpForm .form-header .stepIndicator.active::before {
            background-color: #a7ede8;
            border: 3px solid #d5f9f6;
        }

        #signUpForm .form-header .stepIndicator.finish::before {
            background-color: #009688;
            border: 3px solid #b7e1dd;
        }

        #signUpForm .form-header .stepIndicator::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 8px;
            width: 100%;
            height: 3px;
            background-color: #f3f3f3;
        }

        #signUpForm .form-header .stepIndicator.active::after {
            background-color: #a7ede8;
        }

        #signUpForm .form-header .stepIndicator.finish::after {
            background-color: #009688;
        }

        #signUpForm .form-header .stepIndicator:last-child:after {
            display: none;
        }

        #signUpForm input {
            padding: 15px 20px;
            width: 100%;
            font-size: 1em;
            border: 1px solid #e3e3e3;
            border-radius: 5px;
        }

        #signUpForm input:focus {
            border: 1px solid #009688;
            outline: 0;
        }

        #signUpForm input.invalid {
            border: 1px solid #ffaba5;
        }

        #signUpForm .step {
            display: none;
        }

        #signUpForm .form-footer {
            overflow: auto;
            gap: 20px;
        }

        #signUpForm .form-footer button {
            background-color: #009688;
            border: 1px solid #009688 !important;
            color: #ffffff;
            border: none;
            padding: 13px 30px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            flex: 1;
            margin-top: 5px;
        }

        #signUpForm .form-footer button:hover {
            opacity: 0.8;
        }

        #signUpForm .form-footer #prevBtn {
            background-color: #fff;
            color: #009688;
        }

        .parent-div {
            display: flex;
            justify-content: center;
            align-items: center;
            /* height: 100vh; */
        }

        .file-upload {
            position: relative;
            width: 100px;
            height: 100px;
            border-style: solid;
            border-radius: 50%;
            overflow: hidden;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .file-upload input[type="file"] {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
        }

        .upload-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            opacity: 45%;
        }

        .img-center {
            margin: 0 auto;
        }
    </style>
    <div class="container">
        <form id="signUpForm" action="#!">
            <!-- start step indicators -->
            <div class="form-header d-flex mb-4">
                <span class="stepIndicator">Personal Details</span>
                <span class="stepIndicator">Pet Information</span>
                <span class="stepIndicator">Account Setup</span>
            </div>
            <!-- end step indicators -->
            <div class="step">
                <p class="text-center mb-4">Enter your information</p>

                {{-- <h5 class="text-center mb-1" for="file-input-user"><strong>Upload your image</strong></h5> --}}
                {{-- <div class="mb-3 parent-div">
                    <div class="file-upload">
                        <input type="file" id="file-input-user" name="file-input-user">
                        <label for="file-input">
                            <img src="{{ asset('images/icons/file-upload2.png') }}" alt="Upload File"
                                class="upload-icon img-center">
                        </label>
                    </div>
                </div> --}}
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            {{-- <label for="fname">First Name</label> --}}
                            <input type="text" placeholder="First Name" class="form-control" name="fname"
                                id="fname" required>
                            {{-- <p>eerors</p> --}}
                        </div>
                        <div class="col-6">
                            {{-- <label for="lname">Last Name</label> --}}
                            <input type="text" placeholder="Last Name" class="form-control" name="lname" id="lname"
                                required>
                        </div>
                    </div>
                    {{-- <input type="text" placeholder="Full name" class="full_name" id="full_name" oninput="this.className = ''" name="fullname"> --}}
                </div>
                <div class="mb-3">
                    <input type="text" placeholder="Mobile" id="phone" oninput="this.className = ''" name="phone">
                </div>
                <div class="mb-3">
                    <input type="text" placeholder="Address" id="address" oninput="this.className = ''" name="address">
                </div>
            </div>
            <!-- step one -->

            <!-- step two -->
            <div class="step">
                <p class="text-center mb-4">Add your beloved furbaby! <br> Don't worry! You can add more in your profile</p>
                {{-- <h5 class="text-center mb-1" for="file-input"><strong>Upload an Image</strong></h5> --}}
                {{-- <div class="mb-3 parent-div">
                    <div class="file-upload">
                        <input type="file" id="file-input" name="file-input">
                        <label for="file-input">
                            <img src="{{ asset('images/icons/file-upload2.png') }}" alt="Upload File"
                                class="upload-icon img-center">
                        </label>
                    </div>
                </div> --}}
                <div class="mb-3">
                    <input type="text" placeholder="Pet Name" id="pet-name" oninput="this.className = ''"
                        name="pet-name">
                </div>
                <div class="mb-3">
                    <input type="text" placeholder="Age" id="age" oninput="this.className = ''" name="age">
                </div>
            </div>

            <!-- step three -->
            <div class="step">
                <p class="text-center mb-4">Create your account</p>
                <div class="mb-3">
                    <input type="email" placeholder="Email Address" oninput="this.className = ''" name="email"
                        name="email">
                </div>
                <div class="mb-3">
                    <input type="password" placeholder="Password" oninput="this.className = ''" name="password"
                        name="password">
                </div>
                <div class="mb-3">
                    <input type="password" placeholder="Confirm Password" oninput="this.className = ''"
                        name="password_confirmation" name="password_confirmation">
                </div>
            </div>



            <!-- start previous / next buttons -->
            <div class="form-footer d-flex">
                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                {{-- <button type="submit" id="submitBtn">Submit</button> --}}
            </div>
            <!-- end previous / next buttons -->
        </form>
    </div>

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab
        // $("submitBtn").hide();

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("step");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("step");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= Number(x.length)) {

                // document.getElementById("signUpForm").submit();
                // console.log("submitted")
                if (document.getElementById("nextBtn").innerHTML == "Submit") {
                    console.log("submitted")
                    // $("#signUpForm").submit(function(e) {
                    // alert("Handler for .submit() called.");
                    console.log("submitted2")
                    // e.preventDefault();
                    var data = $("#signUpForm")[0];
                    console.log(data);
                    let formData = new FormData(data);
                    console.log(formData);
                    for (var pair of formData.entries()) {
                        console.log(pair[0] + "," + pair[1]);
                    }
                    $.ajax({
                        type: "POST",
                        // url: "http://localhost:8000/login",
                        url: "/register",
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            // console.log(data.data.token);
                            localStorage.setItem("token", response.data.token);
                            toastr.success("User successfully registered in!");
                            if (response.data.role != "customer") {
                                location.href = "/dashboard";
                                console.log(response.data.role);
                            } else {
                                location.href = "/";
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        },


                    });
                    return false;
                    // console.log()
                    // event.preventDefault();
                    // });
                }
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("step");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                console.log(y[i].value)
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("stepIndicator")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("stepIndicator");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }

        // const fileInput = document.getElementById('file-input');
        // const fileUpload = document.querySelector('.file-upload');

        // fileInput.addEventListener('change', function() {
        //     const file = this.files[0];
        //     const reader = new FileReader();

        //     reader.addEventListener('load', function() {
        //         fileUpload.style.backgroundImage = `url(${this.result})`
        //         // fileUpload.style.width = `100%`;
        //         // fileUpload.style.height = `10vw`;
        //     });

        //     reader.readAsDataURL(file);
        // });
    </script>
@endsection
