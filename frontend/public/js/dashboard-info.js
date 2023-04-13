$(document).ready(() => {
    const customer_per_month = document.getElementById("customer-per-month");
    const orders_per_month = document.getElementById("orders-per-month");

    $.ajax({
        url: "/api/get-counter-info",
        type: "GET",
        processData: false, // Important!
        contentType: false,
        dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Authorization",
                "Bearer " + localStorage.getItem("token")
            );
        },
        success: function (response) {
            console.log(response.data);

            $data = response.data;
            $("#total-customers").text($data.customer_total);
            $("#total-pets").text($data.pet_total);
            $("#total-orders").text($data.order_total);
            $("#total-transactions").text($data.transaction_total);
            $("#total-appointments").text($data.appointment_total);
            $("#total-pending-apointments").text(
                $data.appointment_pending_total
            );
            $("#total-pending-orders").text($data.order_pending_total);
            $("#total-pending-transactions").text(
                $data.transaction_pending_total
            );
        },
    });

    // Chart Serction
    $.ajax({
        url: "/api/get-chart-info",
        type: "GET",
        processData: false, // Important!
        contentType: false,
        dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Authorization",
                "Bearer " + localStorage.getItem("token")
            );
        },
        success: function (response) {
            console.log(response.customer_per_month);

            // Customer Per Month Chart
            $cpm_data = [];
            $cpm_labels = [];

            $.each(response.customer_per_month, function (key, data) {
                $cpm_data.unshift(data.info);
                $cpm_labels.unshift(data.months);
            });

            // console.log($data, $labels);
            new Chart(customer_per_month, {
                type: "bar",
                data: {
                    labels: $cpm_labels,
                    datasets: [
                        {
                            label: "# of Customers",
                            data: $cpm_data,
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                    // responsive: true,
                    // maintainAspectRatio: false,
                },
            });

            // Sales Per Month Chart
            $opm_data = [];
            $opm_labels = [];

            $.each(response.order_per_month, function (key, data) {
                $opm_data.unshift(data.info);
                $opm_labels.unshift(data.months);
            });

            // console.log($data, $labels);
            new Chart(orders_per_month, {
                type: "line",
                data: {
                    labels: $opm_labels,
                    datasets: [
                        {
                            label: "# of Customers",
                            data: $opm_data,
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                // forces step size to be 50 units
                                stepSize: 1,
                            },
                        },
                        // ticks: {
                        //     // forces step size to be 50 units
                        //     stepSize: 1,
                        // },
                    },
                    // responsive: true,
                    // maintainAspectRatio: false,
                },
            });
        },
    });

    $("#create_announcement_button").on("click", function (e) {
        e.preventDefault();
        var data = $("#create_announcement_form")[0];
        console.log(data);
        let formData = new FormData(data);
        console.log(formData);
        for (var pair of formData.entries()) {
            console.log(pair[0] + "," + pair[1]);
        }

        // var data = $("#createform").serialize();
        // console.log(data);
        $.ajax({
            type: "POST",
            url: "/api/make-announcement",
            data: formData,
            contentType: false,
            processData: false,

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    "Authorization",
                    "Bearer " + localStorage.getItem("token")
                );
            },

            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#announcementModal").modal("hide");
                toastr.success(data.message);
                // var $tableData = $("#userTable").DataTable();
                // $("#customer_table").DataTable().ajax.reload();
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

});
