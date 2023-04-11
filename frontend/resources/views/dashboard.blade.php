@extends('layouts.base')
@section('body')
    <div class="container-fluid overflow-hidden"> {{-- Container START --}}
        <div class="row flex-nowrap"> {{-- Row Class START --}}
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark"> {{-- Sidebar START --}}
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/"
                        class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none mt-3">
                        <span class="fs-5 d-none d-sm-inline">Admin Panel</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li> 
                            <a href="{{url('dashboard')}}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-speedometer2"></i> <span
                                    class="ms-1 d-none d-sm-inline">Dashboard</span></a>
                        </li>
                        {{-- <li>
                            <a href="{{url('product-list')}}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-calendar-week"></i> <span
                                    class="ms-1 d-none d-sm-inline">Appointments</span> </a>
                        </li> --}}
                        <li>
                            <a href="{{url('order-list')}}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
                        </li>
                        <li>
                            <a href="{{url('product-list')}}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Products</span></a>
                        </li>
                        <li>
                            <a href="{{url('service-list')}}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-box2-heart"></i> <span class="ms-1 d-none d-sm-inline">Grooming
                                    Services</span> </a>
                        </li>
                        <li>
                            <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Accounts</span> </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                               
                                <li>
                                    <a href="{{url('customer-list')}}" class="nav-link px-0"> <span
                                            class="d-none d-sm-inline">Customers</span></a>
                                </li>
                                @if(Auth::user()->is_admin)
                                 <li class="w-100">
                                    <a href="{{url('user-list')}}" class="nav-link px-0"> <span class="d-none d-sm-inline">User
                                            Accounts</span></a>
                                </li>
                                <li>
                                    <a href="{{url('employee-list')}}" class="nav-link px-0"> <span
                                            class="d-none d-sm-inline">Employees</span></a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        <li>
                            <a href="{{url('pet-list')}}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-box2-heart"></i> <span class="ms-1 d-none d-sm-inline">Pets</span> </a>
                        </li>
                        <li>
                            <a href="{{url('transaction-list')}}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-clipboard-pulse"></i> <span
                                    class="ms-1 d-none d-sm-inline">Transactions</span> </a>
                        </li>
                    </ul>
                    <hr>
                </div>

            </div> {{-- Sidebar END --}}
            <div class="col"> {{-- Content START --}}

               @yield('table-content')

            </div> {{-- Content END --}}
        </div> {{-- Row Class END --}}
    </div>{{-- Container START --}}

    

@endsection
