@extends('layouts.base')
@section('body')
    <style>
        header {
            font-family: 'Titan One', cursive;
        }
    </style>
    {{-- <header>
        <!-- Background image -->
        <div class="p-5 text-center bg-image"
            style="
      background-image: url('{{ asset('images/test.jpg') }}');
      height: 600px;
    ">
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.1);">
                <div class="d-flex  justify-content-center align-items-center h-100">
                    <div class="text-white" >
                        <h1 class="mb-3" style="font-family: 'Titan One'; color:aquamarine">Pet-Pal:</h1>
                        <h4 class="mb-3" style="font-family: 'Titan One'">Get an Experienced Care for your Pet</h4>
                         <a class="btn btn-dark btn-lg" href="#!" role="button">Shop now</a>
                        <a class="btn btn-outline-warning btn-lg" href="#!" role="button">Schedule an Appointment</a>
                       
                    </div>
                </div>
            </div>
        </div>
        <!-- Background image -->
    </header> --}}
    <div class="container col-xxl-8 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="{{ asset('images/dog.png') }}" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes"
                    width="500" height="300" loading="lazy">
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold lh-1 mb-3">Your Pet Is Part Of Our Family</h1>
                <p class="lead text-secondary">Let us treat your pet like our own family with best service and special package.</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Shop now!</button>
                    <button type="button" class="btn btn-outline-warning btn-lg px-4">Schedule an Appointment</button>
                </div>
            </div>
        </div>
    </div>
    <div class="b-example-divider"></div>
    <div class="container marketing">
        <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 fw-normal">What Can We Do</h1>
            <p class="fs-5 text-muted">We look after your little family, we ensure that we will give the best treatment for your little family.</p>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <img src="{{ asset('images/services/pet-products.png') }}" class="rounded" width="140" height="140" alt="Vac">
                {{-- <svg class="bd-placeholder-img rounded-circle" width="140" height="140"
                    xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140"
                    preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#777" /><text x="50%" y="50%" fill="#777"
                        dy=".3em">140x140</text>
                </svg> --}}

                <h2>Pet Products</h2>
                <p>Treat your furbaby some delicious treats and cute bowls, collars and many more!.</p>
                <p><a class="btn btn-secondary" href="#">View details &raquo;</a></p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <img src="{{ asset('images/services/grooming.png') }}" class="rounded" width="140" height="140" alt="Vac">
                {{-- <svg class="bd-placeholder-img rounded-circle" width="140" height="140"
                    xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140"
                    preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#777" /><text x="50%" y="50%" fill="#777"
                        dy=".3em">140x140</text>
                </svg> --}}
                 

                <h2>Pet Grooming</h2>
                <p>Get your furbaby a cute haircut and also have her take a bath!</p>
                <p><a class="btn btn-secondary" href="#">View details &raquo;</a></p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                 <img src="{{ asset('images/services/veterinary.png') }}" class="rounded" width="140" height="140" alt="Vac">
                {{-- <svg class="bd-placeholder-img rounded-circle" width="140" height="140"
                    xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140"
                    preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#777" /><text x="50%" y="50%" fill="#777"
                        dy=".3em">140x140</text>
                </svg> --}}

                <h2>Veterinary</h2>
                <p>Have you furbaby checked and treated for diseases</p>
                <p><a class="btn btn-secondary" href="#">View details &raquo;</a></p>
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
    </div>
@endsection
