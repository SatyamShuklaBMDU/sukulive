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
                        <h3 class="page-title">List of Users</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="custom-breadcrumb">
                                <li class="custom-breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="custom-breadcrumb-item active" aria-current="page">Users</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 ">
                    <div class="row mb" style="margin-bottom: 30px; margin-left: 5px;">
                        <form action="{{ route('filter-user') }}" method="post">
                            @csrf
                            <div class="row">
                                @include('include.date')
                                <div class="col-sm-1 mt-4" style="margin-left: 10px; margin-top: 0px;">
                                    <a class="btn text-white shadow-lg" href="{{ route('user.index') }}"
                                        style="background-color: #ff8196;box-shadow: 2px 10px 9px 0px #00000063 !important">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Register at</th>
                                                <th>Profile Photo</th>
                                                <th>Unique ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Gifts</th>
                                                <th>Account Status</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr class="text-center">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->created_at->format('d/m/y') }}</td>
                                                    <td>
                                                        @if (isset($user->profile_pic))
                                                            <h2 class="table-avatar">
                                                                <a href="{{ asset($user->profile_pic) }}"
                                                                    class="avatar avatar-sm me-2"><img
                                                                        class="avatar-img rounded-circle"
                                                                        src="{{ asset($user->profile_pic) }}"
                                                                        alt="User Image" /></a>
                                                            </h2>
                                                        @else
                                                            <h2 class="table-avatar">
                                                                <a href="{{ asset('assets/img/profiles/avatar-01.jpg') }}"
                                                                    class="avatar avatar-sm me-2" title="Dummy Image"><img
                                                                        class="avatar-img rounded-circle"
                                                                        src="{{ asset('assets/img/profiles/avatar-01.jpg') }}"
                                                                        alt="User Image" /></a>
                                                            </h2>
                                                        @endif
                                                    </td>
                                                    <td>{{ $user->customer_id }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone_number }}</td>
                                                    <td>
                                                        @if ($user->giftHistory->count() > 0)
                                                            <a href="{{ route('user.gift', encrypt($user->id)) }}"
                                                                class="btn btn-primary btn-sm" title="Gifts">
                                                                <i class="fas fa-gift"></i>{{ $user->giftHistory->count() }}
                                                            </a>
                                                        @else
                                                            <span class="badge badge-danger">No Gifts</span>
                                                        @endif
                                                    </td>
                                                    
                                                    <td>
                                                        <div class="status-toggle">
                                                            <input type="checkbox" id="status_{{ $user->id }}"
                                                                class="check status-switch"
                                                                data-user-id="{{ $user->id }}"
                                                                data-status="{{ $user->status }}"
                                                                {{ $user->status == 1 ? 'checked' : '' }} />
                                                            <label for="status_{{ $user->id }}"
                                                                class="checktoggle">checkbox</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('users.view', encrypt($user->id)) }}"
                                                            class="btn btn-warning btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
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
    @endsection
    @section('script-area')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.status-switch').forEach(function(switchElement) {
                    switchElement.addEventListener('click', function() {
                        var userId = this.getAttribute('data-user-id');
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
                                updateStatus(userId, newStatus);
                            } else {
                                this.checked = !this.checked;
                            }
                        });
                    });
                });
            });

            function updateStatus(userId, status) {
                var url = "{{ route('update.status', ['id' => ':id']) }}".replace(':id', userId);
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
