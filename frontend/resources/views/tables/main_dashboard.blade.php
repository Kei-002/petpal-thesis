@extends('dashboard')

@section('table-content')
    <style>
        .dashboard-cards {
            margin-top: 50px;
        }

        .counter-box {
            display: block;
            background: #f6f6f6;
            padding: 40px 20px 37px;
            text-align: center;
            border-radius: 10px;

        }

        .counter-box p {
            margin: 5px 0 0;
            padding: 0;
            color: #909090;
            font-size: 18px;
            font-weight: 500
        }

        .counter-box i {
            font-size: 60px;
            margin: 0 0 15px;
            color: #d2d2d2
        }

        .counter {
            display: block;
            font-size: 32px;
            font-weight: 700;
            color: #666;
            line-height: 28px
        }

        .counter-box.colored {
            background: #3acf87;
        }

        .counter-box.colored p,
        .counter-box.colored i,
        .counter-box.colored .counter {
            color: #fff
        }

        .counter-box.blue {
            background: #0d6efd;
        }

        .counter-box.blue p,
        .counter-box.blue i,
        .counter-box.blue .counter {
            color: white
        }

        .counter-box.indigo {
            background: #6610f2;
        }

        .counter-box.indigo p,
        .counter-box.indigo i,
        .counter-box.indigo .counter {
            color: white
        }


        .counter-box.red {
            background: #dc3545;
        }

        .counter-box.red p,
        .counter-box.red i,
        .counter-box.red .counter {
            color: white
        }
    </style>
    <div class="container float-right mt-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#announcementModal">
            Make Announcement
        </button>

        <!-- Modal -->
        <div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="create_announcement_form" action="#" method="#" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="announcementModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="title">Announcement Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>

                            <label for="content">Content</label>
                            <textarea type="text" class="form-control" name="content" id="content" required> </textarea>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="create_announcement_button" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container dashboard-cards">

        <div class="row">

            <div class="four col-md-3">
                <div class="counter-box indigo">
                    <i class="fa-solid fa-user-group"></i>
                    <span class="counter" id="total-customers">
                        {{-- loading spinner --}}
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </span>
                    <p>Registered Customers</p>
                </div>
            </div>
            <div class="four col-md-3">
                <div class="counter-box colored">
                    <i class="fa fa-calendar-check"></i>
                    <span class="counter" id="total-appointments">{{-- loading spinner --}}
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </span>
                    <p>Total Appointments</p>
                </div>
            </div>

            <div class="four col-md-3">
                <div class="counter-box colored">
                    <i class="fa  fa-shopping-cart"></i>
                    <span class="counter" id="total-orders">{{-- loading spinner --}}
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </span>
                    <p>Total Orders</p>
                </div>
            </div>
            <div class="four col-md-3">
                <div class="counter-box colored">
                    <i class="fa fa-soap"></i>
                    <span class="counter" id="total-transactions">{{-- loading spinner --}}
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </span>
                    <p>Total Service Transactions</p>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="four col-md-3">
                <div class="counter-box blue">
                    <i class="fa fa-dog"></i>
                    <span class="counter" id="total-pets">{{-- loading spinner --}}
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </span>
                    <p>Total Pets</p>
                </div>
            </div>
            <div class="four col-md-3">
                <div class="counter-box red">
                    <i class="fa-solid fa-calendar-week"></i>
                    <span class="counter" id="total-pending-apointments">{{-- loading spinner --}}
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </span>
                    <p>Pending Appointments</p>
                </div>
            </div>
            <div class="four col-md-3">
                <div class="counter-box red">
                    <i class="fa fa-cart-arrow-down"></i>
                    <span class="counter" id="total-pending-orders">{{-- loading spinner --}}
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </span>
                    <p>Pending Order Payments</p>
                </div>
            </div>
            <div class="four col-md-3">
                <div class="counter-box red">
                    <i class="fa fa-hands-wash"></i>
                    <span class="counter" id="total-pending-transactions">{{-- loading spinner --}}
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </span>
                    <p>Pending Service Payments</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-5 ps-2 d-flex justify-content-evenly">
            <div class="border border-primary rounded m-1" style="top:60px; left:20px; width:500px;">
                <h5 class="mt-3"><strong> Customer Registered Per Month</strong></h5>
                <canvas id="customer-per-month"></canvas>
            </div>
            <div class=" border border-primary rounded m-1" style="top:60px; left:20px; width:500px;">
                <h5 class="mt-3"><strong> Orders Sales</strong></h5>
                <canvas id="orders-per-month"></canvas>
            </div>
        </div>
    </div>

    <script type="text/javascript" charset="utf8" src="{{ asset('js/dashboard-info.js') }}"></script>
@endsection
