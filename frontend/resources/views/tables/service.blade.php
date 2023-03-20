@extends('dashboard')

@section('table-content')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>

    <div class="container mt-5"> {{-- Service table START --}}
        <div class="row">
            <h2 class="text-center"><strong>Service List</strong></h2>
        </div>
        {{-- Modal START --}}
        <div class="row">
            {{-- Modal Button START --}}
            <button type="button" class="btn btn-primary" id="create_service_modal_button"data-bs-toggle="modal"
                data-bs-target="#create_service_modal">
                Add New Service
            </button>
            {{-- Modal Button END --}}
            <!-- Modal Create Service Body-->
            <div class="modal fade" id="create_service_modal" tabindex="-1" aria-labelledby="create_service_modal_label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="create_service_modal_label">Add New Service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="create_service_form" action="#" method="#" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group" id="addServiceForm">

                                    <label for="fname">Service Name</label>
                                    <input type="text" class="form-control" name="groom_name" id="groom_name" required>
                                    <label for="fname">Price</label>
                                    <input type="text" class="form-control" name="price" id="price" required>
                                    <label for="fname">Description</label>
                                    <textarea class="form-control" rows="3"  name="description" id="description" required></textarea>


                                    

                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Service Picture</label>
                                        <input class="form-control" type="file" id="img_path" name="img_path"
                                            accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                                    id="create_service_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Modal Create Service Body END --}}

        </div>
        {{-- Modal Edit Service Body --}}
        <div class="row">
            <div class="modal fade" id="update_service_modal" tabindex="-1" aria-labelledby="update_service_modal_label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="update_service_modal_label">Update Service Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="update_service_form" action="#" method="#" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" class="form-control" name="service_id" id="edit-service_id">
                                <div class="form-group" id="update_customer_form">

                                    <label for="fname">Service Name</label>
                                    <input type="text" class="form-control" name="groom_name" id="edit-groom_name" required>
                                    <label for="fname">Price</label>
                                    <input type="text" class="form-control" name="price" id="edit-price" required>
                                    <label for="fname">Description</label>
                                    <textarea class="form-control" rows="3"  name="description" id="edit-description" required></textarea>

                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Image</label>
                                        <input class="form-control" type="file" id="img_path" name="img_path"
                                            accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"
                                    id="update_service_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Edit Service Body END --}}
        {{-- Modal END --}}
        <div class="row mt-3">
            <div class="col-md-12">
                <table id="service_table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Service Image</th>
                            <th>Service Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th colspan="2">Actions</th>
                            <th style="display:none;"></th>
                        </tr>
                    </thead>
                    <tbody id="service_table_body">
                    </tbody>

                </table>

            </div>
        </div>
    </div> {{-- Service table END --}}

    <script type="text/javascript" charset="utf8" src="{{ asset('js/service.js') }}"></script>
@endsection
