@extends('include.master')

@section('style-area')
    <style>
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-img-container {
            position: relative;
            display: inline-block;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ddd;
        }

        .has-story {
            border: 3px solid #FF4500;
            padding: 3px;
            cursor: pointer;
        }

        .profile-stats {
            display: flex;
            gap: 20px;
        }

        .tab-content {
            margin-top: 20px;
        }

        .story-modal img {
            width: 100%;
            max-width: 500px;
            height: auto;
            border-radius: 10px;
        }

        .post-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }

        .post-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        .post-item img:hover {
            transform: scale(1.05);
        }

        /* Custom Modal */
        .modal-content {
            border-radius: 10px;
            overflow: hidden;
        }

        .modal-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .modal-body img {
            width: 100%;
            max-width: 500px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .modal-body .likes-comments {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 500px;
            margin-top: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 16px;
        }

        .modal-body .comments {
            margin-top: 15px;
            width: 100%;
            max-width: 500px;
            text-align: left;
        }

        .modal-body .comments ul {
            list-style: none;
            padding: 0;
            max-height: 200px;
            overflow-y: auto;
        }

        .modal-body .comments li {
            background: #f1f1f1;
            padding: 8px;
            margin: 5px 0;
            border-radius: 5px;
        }

        .post-item img,
        .post-item video {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        .post-item video {
            background: #000;
        }
    </style>
@endsection

@section('content-area')
    <div class="page-wrapper">
        <div class="container mt-4">
            <div class="card shadow-sm p-4">
                <div class="profile-header">
                    <div class="profile-img-container" data-bs-toggle="modal" data-bs-target="#storyModal">
                        <img src="{{ asset($customer->profile_pic ?? 'assets/img/profiles/avatar-01.jpg') }}"
                            class="profile-img {{ count($stories) > 0 ? 'has-story' : '' }}" alt="Profile">
                    </div>
                    <div>
                        <h3>{{ $customer->name }}</h3>
                        <p class="text-muted">{{ $customer->email }}</p>
                        <div class="profile-stats">
                            <strong>{{ $followers->count() }} Followers</strong>
                            <strong>{{ $followings->count() }} Following</strong>
                            <strong>{{ $postcount }} Posts</strong>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Story Modal -->
            @if (count($stories) > 0)
                <div class="modal fade" id="storyModal" tabindex="-1" aria-labelledby="storyModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div id="storyCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($stories as $index => $story)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                @php
                                                    $mediaPath = asset($story->media_path);
                                                @endphp
                                                @if (!empty($story->caption))
                                                    <div
                                                        class="story-caption position-absolute top-0 start-50 translate-middle-x text-white p-2 bg-dark rounded">
                                                        {{ $story->caption }}
                                                    </div>
                                                @endif
                                                @if (Str::endsWith($story->media_path, ['.mp4', '.mov', '.avi']))
                                                    <video autoplay muted loop playsinline class="img-fluid">
                                                        <source src="{{ $mediaPath }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else
                                                    <img src="{{ $mediaPath }}" class="img-fluid" alt="Story">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#storyCarousel"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#storyCarousel"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Tabs -->
            <ul class="nav nav-tabs mt-3" id="profileTabs">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#posts">Posts</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#followers">Followers</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#following">Following</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#wallet">Wallet</a></li>
            </ul>

            <div class="tab-content">
                <!-- Posts Tab -->
                <div id="posts" class="tab-pane fade show active">
                    <div class="post-gallery mt-3">
                        @foreach ($media as $post)
                            <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal{{ $post['id'] }}">
                                @php
                                    $fileExtension = pathinfo($post['url'], PATHINFO_EXTENSION);
                                    $isVideo = in_array($fileExtension, ['mp4', 'mov', 'avi']);
                                @endphp
                                @if ($isVideo)
                                    <video class="video-thumbnail" src="{{ $post['url'] }}"
                                        poster="https://img.freepik.com/premium-photo/laptop-mockup-movie-camera-video-editing-cuts-footage-sound-music-via-computer-cartoon-cute-smooth-pink-background-motion-vlog-movie-clapper-board-3d-render-illustration_598821-1134.jpg?w=1480"
                                        muted></video>
                                @else
                                    <img src="{{ $post['url'] }}" alt="Post">
                                @endif
                            </div>

                            <!-- Post Modal -->
                            <div class="modal fade" id="postModal{{ $post['id'] }}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Post Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if ($isVideo)
                                                <video controls autoplay>
                                                    <source src="{{ $post['url'] }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                <img src="{{ $post['url'] }}" alt="Post">
                                            @endif
                                            <!-- Likes and Comments -->
                                            <div class="likes-comments">
                                                <strong>❤️ {{ $post['likes_count'] }} Likes</strong>
                                                <strong>💬 {{ count($post['comments']) }} Comments</strong>
                                            </div>

                                            <!-- Comments Section -->
                                            <div class="comments">
                                                <h6>Comments</h6>
                                                <ul>
                                                    @foreach ($post['comments'] as $comment)
                                                        <li><strong>{{ App\Models\Customer::findOrFail($comment['user_id'])->name }}:</strong>
                                                            {{ $comment['comment'] }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Followers Tab -->
                <div id="followers" class="tab-pane fade">
                    <ul>
                        @foreach ($followers as $follower)
                            <li>{{ $follower->name }} ({{ $follower->email }})</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Following Tab -->
                <div id="following" class="tab-pane fade">
                    <ul>
                        @foreach ($followings as $following)
                            <li>{{ $following->name }} ({{ $following->email }})</li>
                        @endforeach
                    </ul>
                </div>

                {{-- Wallet Tab --}}
                <div id="wallet" class="tab-pane fade">
                    <div class="card shadow-sm mt-3 p-4">
                        <h4 class="mb-3">💰 Wallet Overview</h4>
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="wallet-box bg-primary text-white p-3 rounded">
                                    <h6>Total Balance</h6>
                                    <h3>₹{{ number_format($total_credits, 2) }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="wallet-box bg-success text-white p-3 rounded">
                                    <h6>Available Balance</h6>
                                    <h3>₹{{ number_format($available_balance, 2) }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="wallet-box bg-danger text-white p-3 rounded">
                                    <h6>Used Balance</h6>
                                    <h3>₹{{ number_format($used_balance, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction History -->
                    <div class="card shadow-sm mt-3 p-4">
                        <h4>📜 Transaction History</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>
                                                @if ($transaction->transaction_type == 'credit')
                                                    <span class="badge bg-success">+ Credit</span>
                                                @elseif($transaction->transaction_type == 'debit')
                                                    <span class="badge bg-danger">- Debit</span>
                                                @else
                                                    <span class="badge bg-secondary">Failed</span>
                                                @endif
                                            </td>
                                            <td>₹{{ number_format($transaction->amount, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->setTimezone('Asia/Kolkata')->format('d M, Y h:i A') }}
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
@endsection
