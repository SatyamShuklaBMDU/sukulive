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
                        <h3 class="page-title">List of Notifications</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="custom-breadcrumb">
                                <li class="custom-breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="custom-breadcrumb-item active" aria-current="page">Notification</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Notifications</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Add Notification</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-hover table-center mb-0">
                                    {{-- <table class="datatable table table-stripped"> --}}
                                    <thead>
                                        <tr class="text-center">
                                            <th>S.No</th>
                                            <th>For</th>
                                            <th>Title</th>
                                            <th>Message</th>
                                            <th>Account Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($notifications as $notification)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $notification->for }}</td>
                                                <td>{{ $notification->title }}</td>
                                                <td>{{ $notification->message }}</td>
                                                <td>
                                                    <div class="status-toggle">
                                                        <input type="checkbox" id="status_{{ $notification->id }}"
                                                            class="check status-switch"
                                                            data-notify-id="{{ $notification->id }}"
                                                            data-status="{{ $notification->status }}"
                                                            {{ $notification->status == 1 ? 'checked' : '' }} />
                                                        <label for="status_{{ $notification->id }}"
                                                            class="checktoggle">checkbox</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary"
                                                        onclick="editNotification({{ $notification->id }})">Edit</button>
                                                    <button class="btn btn-primary"
                                                        onclick="deleteNotification({{ $notification->id }})">Delete</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addNotificationForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="for" class="col-form-label">For:</label>
                            <input type="text" class="form-control" id="for" name="for">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Ttile:</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text" name="message"></textarea>
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
                    <h5 class="modal-title" id="exampleModalLabel2">Edit Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="notificationEditForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="notid">
                        <div class="mb-3">
                            <label for="for" class="col-form-label">For:</label>
                            <input type="text" class="form-control" id="editfor" name="for">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Ttile:</label>
                            <input type="text" class="form-control" id="edittitle" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="editmessage" name="message"></textarea>
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
                    url: "{{ route('notifications.store') }}",
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
                    url: "{{ url('notifications') }}/" + id + "/edit",
                    type: "GET",
                    success: function(data) {
                        $('#notificationEditForm #editfor').val(data.for);
                        $('#notificationEditForm #edittitle').val(data.title);
                        $('#notificationEditForm #editmessage').val(data.message);
                        $('#notificationEditForm #notid').val(data.id);
                        $('#exampleModal2').modal('show');

                        // $('#notificationEditForm').attr('action', "{{ url('notifications') }}/" + id);
                    },
                    error: function(error) {
                        toastr.error('Error occurred while fetching notification details.');
                    }
                });
            }

            $('#notificationEditForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#notid').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('notifications') }}/" + id,
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
                            url: "{{ url('notifications') }}/" + id,
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
            var url = "{{ route('update.notification.status', ['id' => ':id']) }}".replace(':id', notifyId);
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
@endsection
