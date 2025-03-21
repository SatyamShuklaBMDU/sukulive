<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Media;
use App\Models\Story;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = Customer::latest()->get();
        return view('users.index', compact('users'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $user = Customer::findOrFail($id);
            $user->status = $request->input('status');
            $user->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    }

    public function viewSingleUser($id)
    {
        $customer = Customer::with([
            'wallet.transactions',
            'goldCoinWallet',
            'liveVideCall',
            'liveVideoCallJoiner',
            'subscription',
            'likes'
        ])->find(decrypt($id));

        if (!$customer) {
            return redirect()->back()->with('error', 'User not found!');
        }
        $followers = DB::table('followables')
            ->join('customers', 'followables.user_id', '=', 'customers.id')
            ->where('followables.followable_id', $customer->id)
            ->where('followables.followable_type', 'App\Models\Customer')
            ->select('customers.id', 'customers.name', 'customers.profile_pic', 'customers.phone_number')
            ->get()
            ->map(function ($follower) {
                return [
                    'id' => $follower->id,
                    'name' => $follower->name,
                    'phone' => $follower->phone_number,
                ];
            });
        $followings = $customer->followings()
            ->get()
            ->map(function ($following) {
                $followedUser = Customer::find($following->followable_id);
                return $followedUser ? [
                    'id' => $followedUser->id,
                    'name' => $followedUser->name,
                    'phone' => $followedUser->phone_number,
                ] : null;
            });
        $postcount = $customer->media()->where('collection_name', 'posts')->count() ?? 0;

        $stories = Story::where('customers_id', $customer->id)
            ->where('expires_at', '>', now())
            ->orderByDesc('created_at')
            ->get() ?? collect([]);

        $wallet = $customer->wallet;
        $wallet_balance = $wallet?->balance ?? 0;
        $total_credits = Transaction::where('wallet_id', $wallet?->id)->where('transaction_type', 'credit')->sum('amount') ?? 0;
        $total_debits = Transaction::where('wallet_id', $wallet?->id)->where('transaction_type', 'debit')->sum('amount') ?? 0;

        $available_balance = $wallet_balance;
        $used_balance = $total_debits;

        $goldWallet = $customer->goldCoins;
        $goldData = [
            'total_gold' => $goldWallet?->total_gold_coin ?? 0,
            'used_gold' => $goldWallet?->used_gold_coin ?? 0,
            'available_gold' => $goldWallet?->available_gold_coin ?? 0,
        ];

        $diamonds = $customer->diamonds;
        $diamondData = [
            'total_diamond' => $diamonds?->total_diamonds ?? 0,
            'used_diamond' => $diamonds?->used_diamonds ?? 0,
            'available_diamond' => $diamonds?->available_diamonds ?? 0,
        ];

        $transactions = Transaction::where('wallet_id', $wallet?->id)
            ->select('amount', 'transaction_type', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get() ?? collect([]);

        $media = $customer->getMedia('posts')->map(function ($media) {
            $mediaMain = Media::find($media->id);
            $url = url('/');
            $path = "storage/{$media->id}/{$media->file_name}";
            $mediaUrl = asset($path);
            return [
                'id' => $media->id,
                'model_type' => $media->model_type,
                'model_id' => $media->model_id,
                'uuid' => $media->uuid,
                'collection_name' => $media->collection_name,
                'name' => $media->name,
                'created_at' => $media->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $media->updated_at->format('Y-m-d H:i:s'),
                'url' => $url . $mediaUrl,
                'likes_count' => $mediaMain?->likers()->count() ?? 0,
                'comments' => $mediaMain?->comments ?? collect([])
            ];
        });
        return view('users.view', compact(
            'customer',
            'media',
            'followers',
            'followings',
            'postcount',
            'stories',
            'wallet_balance',
            'available_balance',
            'used_balance',
            'transactions',
            'total_credits',
            'goldData',
            'diamondData'
        ));
    }

    public function filterData(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $startDate = $request->start;
        $endDate = $request->end;
        $users = Customer::whereBetween('created_at', [$startDate, $endDate])->latest()->get();
        return view("users.index", ['start' => $startDate, 'end' => $endDate], compact("users"));
    }
}
