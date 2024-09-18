@extends('include.master')
@section('style-area')
    <style>
        .custom-breadcrumb {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .custom-breadcrumb-item {
            display: inline-block;
            /* padding: 0.75rem 1rem; */
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            /* background-color: #e9ecef; */
            /* border: 1px solid #ced4da; */
            border-radius: 0.25rem;
        }

        .custom-breadcrumb-item.active {
            /* background-color: #fff; */
            color: #212529;
        }

        .custom-breadcrumb-item::before {
            content: "/";
            display: inline-block;
            padding: 0 0.5rem;
            color: #ced4da;
        }

        .custom-breadcrumb-item:first-child::before {
            content: "";
        }
    </style>
@endsection
@section('content-area')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">List of Plans</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="custom-breadcrumb">
                                <li class="custom-breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="custom-breadcrumb-item active" aria-current="page">Plans</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Plans</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Add Plan</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-hover table-center mb-0">
                                    {{-- <table class="datatable table table-stripped"> --}}
                                    <thead>
                                        <tr class="text-center">
                                            <th>S.No</th>
                                            <th>Title</th>
                                            <th>Price</th>
                                            <th>Duration</th>
                                            <th>Plan type</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <tbody> --}}
                                            @foreach ($plans as $plan)
                                                <tr class="text-center">
                                                    <td>{{ $loop->iteration }}</td>
                                                    {{-- <td>{{ $notification->for }}</td> --}}
                                                    <td>{{ $plan->name }}</td>
                                                    <td>{{ $plan->price }}</td>
                                                    <td>{{ $plan->duration }}</td>
                                                    <td>{{ $plan->plan_type }}</td>
                                                    <td>
                                                        <div class="status-toggle">
                                                            <input type="checkbox" id="status_{{ $plan->id }}"
                                                                class="check status-switch"
                                                                data-notify-id="{{ $plan->id }}"
                                                                data-status="{{ $plan->is_active }}"
                                                                {{ $plan->is_active == 1 ? 'checked' : '' }} />
                                                            <label for="status_{{ $plan->id }}"
                                                                class="checktoggle">checkbox</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary"
                                                            onclick="editNotification({{ $plan->id }})">Edit</button>
                                                        <button class="btn btn-primary"
                                                            onclick="deleteNotification({{ $plan->id }})">Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addNotificationForm">
                    <div class="modal-body">
                        {{-- <div class="mb-3">
                            <label for="for" class="col-form-label">For:</label>
                            <input type="text" class="form-control" id="for" name="for">
                        </div> --}}
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" id="title" placeholder="Enter Name Of Plan" name="title">
                        </div>
                        <div class="row">
                            <!-- Price -->
                            <div class="col-md-6 mb-3">
                                <label for="price" class="col-form-label">Price:</label>
                                <input type="text" class="form-control" id="price" placeholder="Enter Price in Rupees" name="price" required>
                            </div>
                    
                            <!-- Duration -->
                            <div class="col-md-6 mb-3">
                                <label for="duration" class="col-form-label">Duration:</label>
                                <select class="form-select" id="duration" name="duration" required>
                                    <option disabled selected value="-1">Choose...</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Price -->
                            <div class="col-md-6 mb-3">
                                <label for="price" class="col-form-label">Trial Period Days:</label>
                                <input type="text" class="form-control" id="trial_period_days" placeholder="Enter Trial Period Days" name="price" required>
                            </div>
                    
                            <!-- Duration -->
                            <div class="col-md-6 mb-3">
                                <label for="duration" class="col-form-label">Plan Type:</label>
                                <select class="form-select" id="duration" name="plan_type" required>
                                    <option disabled selected value="-1">Choose...</option>
                                    <option value="free">Free</option>
                                    <option value="paid">Paid</option>
                                    {{-- <option value="yearly">Yearly</option> --}}
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="feature" class="col-form-label">Features:</label>
                            <div id="features-wrapper">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="feature[]" placeholder="Enter feature" required>
                                    <button type="button" class="btn btn-secondary" id="addMore">Add More</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Edit Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="notificationEditForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" id="title1" name="name">
                            <input type="text"  name="" id="notid" class="d-none">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="col-form-label">Price:</label>
                                <input type="text" class="form-control" id="price1" name="price">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="duration" class="col-form-label">Duration:</label>
                                <select class="form-select" id="duration1" name="duration">
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="trial_period_days" class="col-form-label">Trial Period Days:</label>
                                <input type="text" class="form-control" id="trial_period_days1" name="trial_period_days">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="plan_type" class="col-form-label">Plan Type:</label>
                                <select class="form-select" id="plan_type1" name="plan_type">
                                    <option value="free">Free</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="features" class="col-form-label">Features:</label>
                            <div id="features-wrapper1">
                                <!-- Feature fields will be appended here via JavaScript -->
                            </div>
                            <button type="button" class="btn btn-secondary" id="addMore1">Add More</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script-area')
    <script>
        $(document).ready(function() {
            $('#addNotificationForm').on('submit', function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('plans.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success(response.success);
                        location.reload();
                    },
                    error: function(error) {
                        toastr.error('Error occurred while adding notification.');
                    }
                });
            });

            window.editNotification = function(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('plans') }}/" + id + "/edit",
                    type: "GET",
                    success: function(data) {

                        console.log(data);
  // Populate the modal fields with the plan data
  $('#title1').val(data.name);
            $('#price1').val(data.price);
            $('#duration1').val(data.duration);
            $('#trial_period_days1').val(data.trial_period_days);
            $('#plan_type1').val(data.plan_type);
            $('#notid').val(data.id)

            // Populate features
            var featureWrapper = $('#features-wrapper1');
            featureWrapper.empty(); // Clear existing feature fields
             // Populate features if any
             if (Array.isArray(data.features) && data.features.length > 0) {
                data.features.forEach(function(feature, index) {
                    featureWrapper.append(`
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="feature[]" value="${feature}" required>
                            <button type="button" class="btn btn-danger removeFeature">Remove</button>
                        </div>
                    `);
                });
            } else {
                // If no features exist, show the "Add More" button for new feature input
                featureWrapper.append(`
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="feature[]" placeholder="Enter feature" required>
                        <button type="button" class="btn btn-danger removeFeature">Remove</button>
                    </div>
                `);
            }

            // Remove "Add More" button if editing existing features
            // if (data.features && data.features.length > 0) {
            //     $('#addMore1').hide();
            // } else {
            //     $('#addMore1').show();  // Show if no features are present (for new plan)
            // }



            // Show the modal
            $('#exampleModal2').modal('show');
                    },
                    error: function(error) {
                        toastr.error('Error occurred while fetching notification details.');
                    }
                });
            }

            $('#notificationEditForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#notid').val();
                console.log(id);
                
                // log()
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('plans') }}/" + id,
                    type: "PUT",
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success(response.success);
                        location.reload();
                    },
                    error: function(error) {
                        toastr.error('Error occurred while updating notification.');
                    }
                });
            });
            window.deleteNotification = function(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ url('plans') }}/" + id,
                            type: "DELETE",
                            success: function(response) {
                                toastr.success(response.success);
                                location.reload();
                            },
                            error: function(error) {
                                toastr.error('Error occurred while deleting notification.');
                            }
                        });
                    }
                });
            };
        });
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.status-switch').forEach(function(switchElement) {
                switchElement.addEventListener('click', function() {
                    var notifyId = this.getAttribute('data-notify-id');
                    var newStatus = this.checked ? 1 : -1;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to change the status!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, change it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            updateStatus(notifyId, newStatus);
                        } else {
                            this.checked = !this.checked;
                        }
                    });
                });
            });
        });

        function updateStatus(notifyId, status) {
            var url = "{{ route('update.plans.status', ['id' => ':id']) }}".replace(':id', notifyId);
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('User status updated successfully.');
                        location.reload();
                    } else {
                        toastr.error('Failed to update user status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while updating the status.');
                });
        }
    </script>
    <script>
        document.getElementById('addMore').addEventListener('click', function() {
            // Create a new div to wrap the input and delete button
            var newFeatureDiv = document.createElement('div');
            newFeatureDiv.className = 'input-group mb-2';
            
            // Create the new input field for the feature
            var newFeatureInput = document.createElement('input');
            newFeatureInput.type = 'text';
            newFeatureInput.name = 'feature[]';
            newFeatureInput.className = 'form-control';
            newFeatureInput.placeholder = 'Enter feature';
            newFeatureInput.required = true;
    
            // Create the "Remove" button
            var removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger';
            removeButton.textContent = 'Delete';
    
            // Add event listener to the "Remove" button to delete the feature
            removeButton.addEventListener('click', function() {
                newFeatureDiv.remove();
            });
    
            // Append the new input and delete button to the div
            newFeatureDiv.appendChild(newFeatureInput);
            newFeatureDiv.appendChild(removeButton);
    
            // Append the div to the wrapper
            document.getElementById('features-wrapper').appendChild(newFeatureDiv);
        });
    </script>
    <script>
        document.getElementById('addMore1').addEventListener('click', function() {
            // Create a new div to wrap the input and delete button
            var newFeatureDiv = document.createElement('div');
            newFeatureDiv.className = 'input-group mb-2';
            
            // Create the new input field for the feature
            var newFeatureInput = document.createElement('input');
            newFeatureInput.type = 'text';
            newFeatureInput.name = 'feature[]';
            newFeatureInput.className = 'form-control';
            newFeatureInput.placeholder = 'Enter feature';
            newFeatureInput.required = true;
    
            // Create the "Remove" button
            var removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger';
            removeButton.textContent = 'Remove';
    
            // Add event listener to the "Remove" button to delete the feature
            removeButton.addEventListener('click', function() {
                newFeatureDiv.remove();
            });
    
            // Append the new input and delete button to the div
            newFeatureDiv.appendChild(newFeatureInput);
            newFeatureDiv.appendChild(removeButton);
    
            // Append the div to the wrapper
            document.getElementById('features-wrapper1').appendChild(newFeatureDiv);
        });
    </script>

@endsection
