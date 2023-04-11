@extends('layouts.base')
@section('body')
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center" id="service-list">
                <div class="col mb-5">
                    <!-- Spinner-->
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <!-- Services goes here -->

                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $html = "";

            // @auth
            // $.ajax({
            //     url: "/api/get-owned-pets",
            //     type: "GET",
            //     processData: false, // Important!
            //     contentType: false,
            //     dataType: "json",
            //     beforeSend: function(xhr) {
            //         xhr.setRequestHeader(
            //             "Authorization",
            //             "Bearer " + localStorage.getItem("token")
            //         );
            //     },
            //     success: function(data) {
            //         // console.log(data);
            //         // console.log(data.pets);
            //         $html += ` <select class="form-select pet-select"  aria-label="role-select" name="pet" style="width:7rem;"
        //             id="pet-select">`
            //         if (data.pets != null) {
            //             // $edit_owner_list = $("#edit-owner");
            //             $.each(data.pets, function(key, value) {
            //                 console.log(value);
            //                 $html +=
            //                     `<option value="${value.id}">${value.pet_name}</option>`
            //                 // $pet_list.push(value);
            //             });
            //             $html += "</select>"
            //             // $("#add-to-cart").attr("disabled",false);

            //             console.log($html)
            //         } else {
            //             console.log("No Pets");
            //         }
            //         // $("#pet").attr("hidden", false);
            //     },
            // });
            // @endauth

            $.ajax({
                url: "/api/get-all-services",
                type: "GET",
                processData: false, // Important!
                contentType: false,
                dataType: "json",

                success: function(response) {
                    var services = response.services;
                    console.log(services);
                    // $(".category-list").empty();
                    $("#service-list").empty();


                    //  $.each($pet_list, function (key, pet) {
                    //     console.log(pet, "test loop");
                    //     //  $(`#service-list #pet-select-${service.id}`).append(`<option value="${pet.id}">${pet.pet_name}</option>`)
                    //     // // $pet_list.append(
                    //     // //     `<option value="${pet.id}">${pet.pet_name}</option>`
                    //     // // );
                    //     // $(` #service-list #pet-select-${service.id}`).attr("hidden", false);
                    // });
                    $.each(services, function(key, service) {
                        // console.log(category.category_name);
                        $("#service-list").append(`
                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" style=" width: 100%;
                                                                height: 10vw;
                                                                object-fit: cover;"
                                src="${service.img_path}" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder">${service.groom_name}</h5>
                                        <!-- Product reviews-->
                                        <div class="d-flex justify-content-center small text-warning mb-2">
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                        </div>
                                        <!-- Product price-->
                                        ${service.price}
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4  pt-0 border-top-0 bg-transparent">
                                    <div class="text-center d-flex justify-content-center" id="product-actions">
                                        ${$html}
                                        <button type="button" id="add-to-cart" class="btn btn-outline-dark mx-1"
                                            data-id="${service.id}" 
                                            data-name="${service.groom_name}"
                                            data-price="${service.price}"
                                            data-image="${service.img_path}"">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>`);


                        // $('#select_id').append($('<option>', {
                        //     value: 1,
                        //     text: 'One'
                        // }));
                        // $.each($pet_list, function (key, pet) {
                        //     console.log(pet, "test loop");
                        //     //  $(`#service-list #pet-select-${service.id}`).append(`<option value="${pet.id}">${pet.pet_name}</option>`)
                        //     // // $pet_list.append(
                        //     // //     `<option value="${pet.id}">${pet.pet_name}</option>`
                        //     // // );
                        //     // $(` #service-list #pet-select-${service.id}`).attr("hidden", false);
                        // });

                    });
                    // console.log("testoo");

                },
            });

        });
    </script>

    <script src="{{ asset('js/service-display.js') }}"></script>
@endsection
