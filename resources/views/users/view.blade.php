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
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
        }

        .custom-breadcrumb-item.active {
            color: #212529;
            font-weight: bold;
        }

        .custom-breadcrumb-item::before {
            content: " / ";
            color: #6c757d;
            padding: 0 0.3rem;
        }

        .custom-breadcrumb-item:first-child::before {
            content: "";
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }
    </style>
@endsection

@section('content-area')
    <div class="page-wrapper">
        <div class="content container-fluid">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">User Details</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="custom-breadcrumb">
                                <li class="custom-breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="custom-breadcrumb-item active" aria-current="page">User Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Profile Section -->
            <div class="container">
                <div class="card shadow-lg">
                    <div class="card-body">
                        
                        <!-- User Profile -->
                        <div class="row align-items-center mb-4">
                            <div class="col-md-6 d-flex align-items-center">
                                <img src="{{ asset($customer->profile_pic ?? 'default-profile.png') }}" class="profile-img me-3" alt="Profile">
                                <div>
                                    <h4 class="mb-1">{{ $customer->name }}</h4>
                                    <p class="text-muted mb-0">{{ $customer->email }}</p>
                                    <p class="text-muted">{{ $customer->phone_number }}</p>
                                </div>

                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    <h3>Total Followers: {{ $customer->followables->count() }}</h3>
                                    
                                   
                                       
                                </div>
                                
                                
                            </div>
                        </div>
            
                        <hr>
            
                        <!-- Customer Details Table -->
                        <h5>Customer Information</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Customer ID</th>
                                        <td>{{ $customer->customer_id }}</td>
                                        <th>Balance</th>
                                        <td>{{ optional($customer->wallet)->balance ?? '0.00' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Gold Coin</th>
                                        <td>{{ optional($customer->goldCoinWallet)->total_gold_coin ?? '0' }}</td>
                                        <th>Used Gold Coin</th>
                                        <td>{{ optional($customer->goldCoinWallet)->used_gold_coin ?? '0' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Available Gold Coin</th>
                                        <td>{{ optional($customer->goldCoinWallet)->available_gold_coin ?? '0' }}</td>
                                        <th>Plan ID</th>
                                        <td>{{ optional($customer->subscription)->plan_id ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Subscription Start</th>
                                        <td>{{ optional($customer->subscription)->started_at ?? 'N/A' }}</td>
                                        <th>Subscription Expiry</th>
                                        <td>{{ optional($customer->subscription)->expires_at ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Subscription Status</th>
                                        <td colspan="3">
                                            <span class="badge {{ optional($customer->subscription)->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ optional($customer->subscription)->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
            
                        <!-- Live Video Calls -->
                        <h5 class="mt-4">Live Video Call Details</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Live ID</th>
                                        <td>{{ optional($customer->liveVideoCall)->live_id ?? 'N/A' }}</td>
                                        <th>Live User Name</th>
                                        <td>{{ optional($customer->liveVideoCall)->user_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Live Status</th>
                                        <td>{{ optional($customer->liveVideoCall)->live_status ?? 'N/A' }}</td>
                                        <th>Live Date</th>
                                        <td>{{ optional($customer->liveVideoCall)->live_date ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
            
                        <!-- Live Video Call Joiners -->
                        <h5 class="mt-4">Live Video Call Joiner Details</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Joiner ID</th>
                                        <td>{{ optional($customer->liveVideoCallJoiner)->live_id ?? 'N/A' }}</td>
                                        <th>Joiner Name</th>
                                        <td>{{ optional($customer->liveVideoCallJoiner)->user_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Join Status</th>
                                        <td>{{ optional($customer->liveVideoCallJoiner)->join_status ?? 'N/A' }}</td>
                                        <th>Join Date</th>
                                        <td>{{ optional($customer->liveVideoCallJoiner)->join_date ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Uploaded Media -->
                        <h5 class="mt-4">Uploaded Media</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Model Type</th>
                                        <th>Model ID</th>
                                        <th>UUID</th>
                                        <th>Collection</th>
                                        <th>Name</th>
                                        <th>File</th>
                                        <th>MIME Type</th>
                                        <th>Size (KB)</th>
                                        <th>Created At</th>
                                        <th>Preview</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($media as $item)
                                        <tr>
                                            <td>{{ $item['id'] }}</td>
                                            <td>{{ $item['model_type'] }}</td>
                                            <td>{{ $item['model_id'] }}</td>
                                            <td>{{ $item['uuid'] }}</td>
                                            <td>{{ $item['collection_name'] }}</td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ $item['file_name'] }}</td>
                                            <td>{{ $item['mime_type'] }}</td>
                                            <td>{{ number_format($item['size'] / 1024, 2) }} KB</td>
                                            <td>{{ $item['created_at'] }}</td>
                                            <td>
                                                @if (strpos($item['mime_type'], 'image') === 0)
                                                    <img src="{{ $item['url'] }}" width="50" height="50" class="rounded">
                                                @elseif (strpos($item['mime_type'], 'video') === 0)
                                                    <video width="100" controls>
                                                        <source src="{{ $item['url'] }}" type="{{ $item['mime_type'] }}">
                                                    </video>
                                                @else
                                                    <a href="{{ $item['url'] }}" target="_blank">Download</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <h5 class="mt-4">Transaction History</h5>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Amount</th>
                <th>Transaction Type</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customer->wallet->transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ ucfirst($transaction->transaction_type) }}</td>
                    <td>
                        <span class="badge {{ $transaction->status == 'success' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No transactions found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

                    </div>
                </div>
            </div>            
        </div>
    </div>
@endsection
