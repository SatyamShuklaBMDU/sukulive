<?php

namespace App\Http\Controllers\API;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Media;
use App\Models\Story;
use App\Models\Wallet;
use BeyondCode\Comments\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public $path = 'https://sukulive.com/';

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:customers,phone_number',
            'email' => 'required|string|unique:customers,email',
            'password' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'validation fails.', 'error' => $validator->messages()], 422);
        }
        $customer = Customer::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'customer_id' => Customer::generateUniqueCode(),
            'password' => Hash::make($request->password),
        ]);
        $wallet = Wallet::create([
            'customer_id' => $customer->id,
            'balance' => 0.00,
        ]);
        // $customer->wallet()->associate($wallet);
        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully',
            'data' => $customer,
        ], Response::HTTP_CREATED);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|numeric',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }
        $user = Customer::where('phone_number', $request->phone_number)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'User phone number and password do not match.'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login Successfully',
            'token' => $token,
        ], 200);
    }

    public function Logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json(['status' => true, 'message' => 'Logged Out Successfully'], 200);
    }

    public function update(Request $request)
    {
        $login = Auth::user();
        $customer = Customer::findOrFail($login->id);
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:customers,email,' . $customer->id,
            'profile_pic' => 'sometimes|image|mimes:png,jpg,jpeg',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'validation fails.', 'error' => $validator->messages()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $fileUrl = '';
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $fileUrl = FileHelper::storeFile($file, 'Customer/' . $customer->customer_id, $fileName);
        }
        $data = [
            'name' => $request->name ? $request->name : $customer->name,
            'email' => $request->email ? $request->email : $customer->email,
            'profile_pic' => $request->hasFile('profile_pic') ? $fileUrl : $customer->profile_pic,
        ];
        $customer->update($data);
        return response()->json(['status' => true, 'message' => 'Customer Details Updated Successfully', 'data' => $customer], 200);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|exists:customers,phone_number',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'validation fails.', 'error' => $validator->messages()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = Customer::where('phone_number', $request->phone)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['status' => true, 'message' => 'Password Reset Successfully'], Response::HTTP_OK);
    }

    public function getAllUser()
    {
        $customers = Customer::where('id', '!=', Auth::user()->id)->where('status', true)->latest()->get();
        $customers->each(function ($customer) {
            $customer->profile_pic = $customer->profile_pic ? $this->path . $customer->profile_pic : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png';
        });
        return response()->json([
            'status' => true,
            'data' => $customers,
        ], 200);
    }

    public function getProfileData()
    {
        $login = Auth::user();
        $user = Customer::findOrFail($login->id);
        $followingCount = $user->followings()->count();
        $followersCount = DB::table('followables')
            ->where('followable_id', $user->id)
            ->where('followable_type', 'App\Models\Customer')
            ->count();
        $totalPostsCount = $user->media()->where('collection_name', 'posts')->count();
        $totalPosts = $user->getMedia('posts')->map(function ($media) use ($user) {
            $postpath = "storage/{$media->id}/{$media->file_name}";
            return [
                'id' => $media->id,
                'file_name' => $media->file_name,
                'uuid' => $media->uuid,
                'original_url' => $this->path . $postpath,
                'like_count' => Media::find($media->id)->likes()->count(),
                'comment_count' => Comment::where('commentable_id', $media->id)->count(),
                'is_like' => Media::find($media->id)->isLikedBy($user),
            ];
        });
        $stories = Story::where('customers_id', $login->id)
            ->where('expires_at', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
        $storiesList = $stories->map(function ($story) {
            $extension = pathinfo($story->media_path, PATHINFO_EXTENSION);
            $type = match (strtolower($extension)) {
                'jpg', 'jpeg', 'png' => 'image',
                'mp4', 'mov', 'avi' => 'video',
                default => 'unknown',
            };
            $story->type = $type;
            return $story->only([
                'id',
                'customers_id',
                'media_path',
                'caption',
                'expires_at',
                'created_at',
                'updated_at',
                'type'
            ]);
        });
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'profile_pic' => $user->profile_pic ? $this->path . $user->profile_pic : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'total_followers' => $followersCount,
            'total_following' => $followingCount,
            'post_count' => $totalPostsCount,
            'total_posts' => $totalPosts,
            'stories' => $storiesList,
        ];
        return response()->json($data, Response::HTTP_OK);
    }

    public function getProfileById($id)
    {
        $login = Auth::user();
        $loginUser = Customer::findOrFail($login->id);
        $user = Customer::findOrFail($id);
        $followingCount = $user->followings()->count();
        $followersCount = DB::table('followables')
            ->where('followable_id', $user->id)
            ->where('followable_type', 'App\Models\Customer')
            ->count();
        $totalPostsCount = $user->media()->where('collection_name', 'posts')->count();
        $totalPosts = $user->getMedia('posts')->map(function ($media) use ($loginUser) {
            $postpath = "storage/{$media->id}/{$media->file_name}";
            return [
                'id' => $media->id,
                'file_name' => $media->file_name,
                'uuid' => $media->uuid,
                'original_url' => $this->path . $postpath,
                'like_count' => Media::find($media->id)->likes()->count(),
                'comment_count' => Comment::where('commentable_id', $media->id)->count(),
                'is_like' => Media::find($media->id)->isLikedBy($loginUser),
            ];
        });
        $stories = Story::where('customers_id', $id)
            ->where('expires_at', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
        $storiesList = $stories->map(function ($story) {
            $extension = pathinfo($story->media_path, PATHINFO_EXTENSION);
            $type = match (strtolower($extension)) {
                'jpg', 'jpeg', 'png' => 'image',
                'mp4', 'mov', 'avi' => 'video',
                default => 'unknown',
            };
            $story->type = $type;
            return $story->only([
                'id',
                'customers_id',
                'media_path',
                'caption',
                'expires_at',
                'created_at',
                'updated_at',
                'type'
            ]);
        });
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'profile_pic' => $user->profile_pic ? $this->path . $user->profile_pic : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'total_followers' => $followersCount,
            'total_following' => $followingCount,
            'post_count' => $totalPostsCount,
            'total_posts' => $totalPosts,
            'stories' => $storiesList,
            'is_following' => $loginUser->isFollowing($user),
            'is_followed_by' => $user->isFollowedBy($loginUser),
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    public function followerfollowing($id)
    {
        $login = Auth::user();
        $loginUser = Customer::findOrFail($login->id);
        $user = Customer::findOrFail($id);
        $followers = DB::table('followables')
            ->join('customers', 'followables.user_id', '=', 'customers.id')
            ->where('followables.followable_id', $user->id)
            ->where('followables.followable_type', 'App\Models\Customer')
            ->select('customers.id', 'customers.name', 'customers.profile_pic')
            ->paginate(20)
            ->through(function ($follower) use ($loginUser) {
                return [
                    'id' => $follower->id,
                    'name' => $follower->name,
                    'profile_pic' => $follower->profile_pic ? $this->path . $follower->profile_pic : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
                    'is_following' => $loginUser->isFollowing(Customer::find($follower->id)),
                ];
            });

        $followings = $user->followings()
            ->paginate(20)
            ->through(function ($following) use ($loginUser) {
                $followedUser = Customer::find($following->followable_id);
                return $followedUser ? [
                    'id' => $followedUser->id,
                    'name' => $followedUser->name,
                    'profile_pic' => $followedUser->profile_pic ? $this->path . $followedUser->profile_pic : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
                    'is_following' => $loginUser->isFollowing(Customer::find($followedUser->id)),
                ] : null;
            });

        $data = [
            'followers' => $followers,
            'followings' => $followings,
        ];

        return response()->json($data, Response::HTTP_OK);
    }
}
