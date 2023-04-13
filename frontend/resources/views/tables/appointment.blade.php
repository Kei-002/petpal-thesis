@extends('dashboard')

@section('table-content')
    <style>
        .select2 {
            width: 100% !important;
        }

        .fc-event {
            cursor: pointer;
        }
    </style>
    <div class="container my-2 d-flex justify-content-between">
        <div class="">
            <button type="button" id="appointment-list-btn" class="btn btn-info"><i
                    class="me-3 bi bi-chevron-double-left"></i>Appointment List</button>
        </div>
        <div class="">
            <button type="button" id="calendar-btn" class="btn btn-success">View Calendar<i
                    class="ms-3 bi bi-calendar-event-fill "></i></button>
        </div>
    </div>

    <div class="container mt-5" id="table-container"> {{-- Appointment table START --}}
        <div class="row">
            <h2 class="text-center"><strong>Appointment List</strong></h2>


        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <table id="appointment_table" class="table table-striped table-bappointmented dt-responsive nowrap"
                    cellspacing="0" width="100%">
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


    <div class="container mt-5" id="calendar-container">
        <div id='calendar'></div>
    </div>


    {{-- Modal Edit Appointment Body --}}
    <div class="row">
        <div class="modal fade" id="update_appointment_modal" tabindex="-1"
            aria-labelledby="update_appointment_modal_label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="update_appointment_modal_label">Update Appointment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="update_appointment_form" action="#" method="#" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" name="appointment_id" id="edit-appointment_id">
                            <div class="form-group" id="update_appointment_form">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="fname">First Name</label>
                                        <input type="text" class="form-control" name="fname" id="edit-fname" disabled>
                                    </div>
                                    <div class="col-6">
                                        <label for="lname">Last Name</label>
                                        <input type="text" class="form-control" name="lname" id="edit-lname" disabled>
                                    </div>
                                </div>
                            </div>
                            <label for="fname">Appointment Date</label>
                            <input type="date" class="form-control" name="appointment_date" id="edit-appointment_date">
                            <label for="fname">Appointment Status</label>
                            {{-- <input type="text" class="form-control" name="appointment_status" id="edit-appointment_status"
                                disabled> --}}
                            <select class="form-select"name="appointment_status" id="edit-appointment_status">
                                <option value="Confirmed">Confirmed</option>
                                <option value="Appointment Placed">Appointment Placed</option>
                                <option value="Reschedule">Reschedule</option>
                                <option value="Cancelled">Cancel</option>
                            </select>
                            <label for="fname">Description</label>
                            <textarea type="text" class="form-control" name="description" id="edit-description"> </textarea>
                        </div>

                        <div class="modal-footer">
                            {{-- <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                                id="update_appointment_button">Submit</button> --}}
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success btn-confirm" data-bs-dismiss="modal">Confirm
                                Appointment</button>
                            <button type="button" class="btn btn-primary btn-update" data-bs-dismiss="modal"
                                id="update_appointment_button">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Edit Appointment Body END --}}
    <script>
        $(document).ready(function() {

            $("#calendar-btn").hide()
            $("#table-container").hide()
            $("#update_appointment_modal").on("hidden.bs.modal", function() {
                $(this).find("form").trigger("reset");
            });
            // Load Calendar with events
            $.ajax({
                url: "/api/calendar-info",
                type: "GET",
                processData: false, // Important!
                contentType: false,
                dataType: "json",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader(
                        "Authorization",
                        "Bearer " + localStorage.getItem("token")
                    );
                },
                success: function(data) {
                    $appointments = []
                    $.map(data, function(val, i) {
                        var color
                        // if (val.appointment_status === "Confirmed") {
                        //     var color = "#01949A"
                        //     // console.log(colors.confirmed)
                        // }

                        switch (val.appointment_status) {
                            case "Confirmed":
                                color = "#01949A"
                                break;
                            case "Cancelled":
                                // code block
                                color = "#FF2E2E"
                                break;
                            case "Reschedule":
                                color = "#0096FF"
                                break;
                            default:
                                color = "#FFC300"

                        }
                        var obj = {
                            id: i,
                            title: val.customer.fname + " " + val.customer.lname,
                            start: val.appointment_date,
                            color: color,
                            details: val
                        };
                        $appointments.push(obj);
                    });
                    console.log($appointments)
                    // document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('calendar');
                    var date = new Date();
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        initialDate: date,
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        events: $appointments,
                        eventClick: function(info) {
                            info.jsEvent.preventDefault(); // don't let the browser navigate

                            $infos = info.event.extendedProps.details;

                            $("#edit-appointment_id").val($infos.id);
                            $("#edit-fname").val($infos.customer.fname);
                            $("#edit-lname").val($infos.customer.lname);
                            $("#edit-appointment_date").val($infos.appointment_date);
                            $("#edit-appointment_status").val($infos.appointment_status)
                                .change();
                            $("#edit-description").val($infos.description);

                            console.log($infos);

                            $('#update_appointment_modal').modal('show');
                            console.log(info.event.extendedProps.details)



                            // if (info.event.title) {
                            //     console.log(info.event.details)
                            // }

                        }
                    });

                    calendar.render();
                    // });


                },
            });

            $("#appointment-list-btn").on("click", (e) => {
                e.preventDefault();


                $("#calendar-container").hide("slide")
                $("#table-container").show("slide")
                $("#appointment-list-btn").hide()
                $("#calendar-btn").show()
            })

            $("#calendar-btn").on("click", (e) => {
                e.preventDefault();
                // var calendarEl = document.getElementById('calendar');
                // var this_calendar = new FullCalendar.Calendar(calendarEl)
                // this_calendar.rerenderEvents()

                $("#calendar-container").show()
                $("#table-container").hide("slide")

                $("#appointment-list-btn").show()
                $("#calendar-btn").hide()
            })

            $("#edit-appointment_date").on("change", (e) => {
                e.preventDefault();
                $("#edit-appointment_status").val("Reschedule").change();
            })

            $(".btn-update").on("click", function(e) {
                e.preventDefault();
                var id = $("#edit-appointment_id").val();
                console.log(id);
                var data = $("#update_appointment_form")[0];
                console.log(data);

                let formData = new FormData(data);
                for (var pair of formData.entries()) {
                    console.log(pair[0] + "," + pair[1]);
                }
                $.ajax({
                    type: "POST",
                    // cache: false,
                    contentType: false,
                    processData: false,
                    url: "/api/update-appointment",
                    data: formData,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader(
                            "Authorization",
                            "Bearer " + localStorage.getItem("token")
                        );
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#update_appointment_form").modal("hide");

                        // $("#customer_table").DataTable().ajax.reload();
                        console.log("data", data);
                        toastr.success(data.message);
                        location.reload()
                    },
                    error: function(error) {
                        console.log("error", error);
                        // toastr.error(error);
                    },
                });
            });

            $(".btn-confirm").on("click", function(e) {
                e.preventDefault();
                var id = $("#edit-appointment_id").val();
                console.log(id);
                $.ajax({
                    type: "POST",
                    // cache: false,
                    contentType: false,
                    processData: false,
                    url: "/api/appointment-confirm/" + id,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader(
                            "Authorization",
                            "Bearer " + localStorage.getItem("token")
                        );
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#appointment_table").DataTable().ajax.reload();
                        console.log("data", data);
                        // console.log("message", data.message);
                        // console.log("request", data.request);
                        
                        toastr.success(data.message);
                        location.reload();
                    },
                    error: function(error) {
                        console.log("error", error);
                        // toastr.error(error);
                    },
                });
            });
        })
    </script>



    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                initialDate: '2023-03-07',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [{
                        title: 'All Day Event',
                        start: '2023-03-01'
                    },
                    {
                        title: 'Long Event',
                        start: '2023-03-07',
                        end: '2023-03-10'
                    },
                    {
                        groupId: '999',
                        title: 'Repeating Event',
                        start: '2023-03-09T16:00:00'
                    },
                    {
                        groupId: '999',
                        title: 'Repeating Event',
                        start: '2023-03-16T16:00:00'
                    },
                    {
                        title: 'Conference',
                        start: '2023-03-11',
                        end: '2023-03-13'
                    },
                    {
                        title: 'Meeting',
                        start: '2023-03-12T10:30:00',
                        end: '2023-03-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2023-03-12T12:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2023-03-12T14:30:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2023-03-13T07:00:00'
                    },
                    {
                        title: 'Click for Google',
                        url: 'http://google.com/',
                        start: '2023-03-28'
                    }
                ]
            });

            calendar.render();
        });
    </script> --}}
    <script type="text/javascript" charset="utf8" src="{{ asset('js/appointment.js') }}"></script>
@endsection
