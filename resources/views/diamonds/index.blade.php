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
                        <h3 class="page-title">List of Diamonds</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="custom-breadcrumb">
                                <li class="custom-breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="custom-breadcrumb-item active" aria-current="page">Diamonds</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Diamonds</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Add Diamonds</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-hover table-center mb-0">
                                    {{-- <table class="datatable table table-stripped"> --}}
                                    <thead>
                                        <tr class="text-center">
                                            <th>S.No</th>
                                            <th>Diamonds</th>
                                            <th>MRP</th>
                                            <th>Selling Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <tbody> --}}
                                            @foreach ($diamonds as $diamond)
                                                <tr class="text-center">
                                                    <td>{{ $loop->iteration }}</td>
                                                    {{-- <td>{{ $notification->for }}</td> --}}
                                                    <td>{{ $diamond->diamonds }}</td>
                                                    <td>{{ $diamond->mrp }}</td>
                                                    <td>{{ $diamond->selling_price }}</td>
                                                    <td>
                                                        <div class="status-toggle">
                                                            <input type="checkbox" id="status_{{ $diamond->id }}"
                                                                class="check status-switch"
                                                                data-notify-id="{{ $diamond->id }}"
                                                                data-status="{{ $diamond->is_active }}"
                                                                {{ $diamond->is_active == 1 ? 'checked' : '' }} />
                                                            <label for="status_{{ $diamond->id }}"
                                                                class="checktoggle">checkbox</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary"
                                                            onclick="editNotification({{ $diamond->id }})">Edit</button>
                                                        <button class="btn btn-primary"
                                                            onclick="deleteNotification({{ $diamond->id }})">Delete</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Diamonds</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addNotificationForm">
                    <div class="modal-body">
                        {{-- <div class="mb-3">
                            <label for="for" class="col-form-label">For:</label>
                            <input type="text" class="form-control" id="for" name="for">
                        </div> --}}
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Diamonds:</label>
                            <input type="text" class="form-control" id="title" placeholder="Enter Number Of Diamonds" name="diamonds">
                        </div>
                        <div class="row">
                            <!-- Price -->
                            <div class="col-md-6 mb-3">
                                <label for="price" class="col-form-label">MRP:</label>
                                <input type="text" class="form-control" id="price" placeholder="Enter MRP in Rupees" name="mrp" required>
                            </div>
                    
                            <!-- Duration -->
                            <div class="col-md-6 mb-3">
                                <label for="duration" class="col-form-label">Price:</label>
                                <input type="text" class="form-control" id="price" placeholder="Enter Price in Rupees" name="selling_price" required>
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
                    <h5 class="modal-title" id="exampleModalLabel2">Edit Diamonds</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="notificationEditForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Diamonds:</label>
                            <input type="text" class="form-control" id="diamond" name="diamonds">
                            <input type="text"  name="" id="notid" class="d-none">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="col-form-label">MRP:</label>
                                <input type="text" class="form-control" id="mrp" name="mrp">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="duration" class="col-form-label">Selling Price:</label>
                                <input type="text" class="form-control" id="sp" name="selling_price">
                               
                            </div>
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
                    url: "{{ route('diamonds.store') }}",
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
                    url: "{{ url('diamonds') }}/" + id + "/edit",
                    type: "GET",
                    success: function(data) {

                        // console.log(data);
  // Populate the modal fields with the plan data
  $('#diamond').val(data.diamonds);
            $('#mrp').val(data.mrp);
            $('#sp').val(data.selling_price);
            $('#notid').val(data.id)

            // Populate features
          
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
                    url: "{{ url('diamonds') }}/" + id,
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
                            url: "{{ url('diamonds') }}/" + id,
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
            var url = "{{ route('update.blog.cat.status', ['id' => ':id']) }}".replace(':id', notifyId);
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
                        toastr.success('Diamond status updated successfully.');
                        location.reload();
                    } else {
                        toastr.error('Failed to update diamond status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while updating the status.');
                });
        }
    </script>
    

@endsection
