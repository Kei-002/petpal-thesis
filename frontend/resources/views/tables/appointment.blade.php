@extends('dashboard')

@section('table-content')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>

    <div class="container mt-5"> {{-- Appointment table START --}}
        <div class="row">
            <h2 class="text-center"><strong>Appointment List</strong></h2>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <table id="appointment_table" class="table table-striped table-bappointmented dt-responsive nowrap" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Apointment ID</th>
                            <th>Customer Name</th>
                            <th>Appoinment Date</th>
                            <th>Appointment Status</th>
                            {{-- <th>Total Purchase</th> --}}
                            {{-- <th>Purchase Date</th> --}}
                            <th>Date Initiated</th>
                            {{-- <th>Receipt</th> --}}
                            <th colspan="2">Actions</th>
                            <th style="display:none;"></th>
                        </tr>
                    </thead>
                    <tbody id="appointment_table_body">
                    </tbody>

                </table>

            </div>
        </div>
    </div> {{-- Appointment table END --}}
    <script type="text/javascript" charset="utf8" src="{{ asset('js/appointment.js') }}"></script>
@endsection
