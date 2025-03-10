<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Media;
use App\Models\Story;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;

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
        ])->find($id);
        if (!$customer) {
            return redirect()->back()->with('error', 'User not found!');
        }
        $followers = $customer->followers()->get();
        $followings = $customer->followings()->get();
        $postcount = $customer->media()->where('collection_name', 'posts')->count();
        $stories = Story::where('customers_id', $customer->id)
            ->where('expires_at', '>', now())
            ->orderByDesc('created_at')
            ->get();
        $wallet = $customer->wallet;
        $wallet_balance = $wallet->balance ?? 0;
        $total_credits = Transaction::where('wallet_id', $wallet->id)->where('transaction_type', 'credit')->sum('amount');
        $total_debits = Transaction::where('wallet_id', $wallet->id)->where('transaction_type', 'debit')->sum('amount');
        $available_balance = $wallet_balance;
        $used_balance = $total_debits;
        $transactions = Transaction::where('wallet_id', $wallet->id)
            ->select('amount', 'transaction_type', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        $media = $customer->getMedia('posts')->map(function ($media) {
            $mediaMain = Media::findOrFail($media->id);
            $url = url('/');
            $path = "storage/{$media->id}/{$media->file_name}";
            $mediaUrl = asset($path);
            return [
                'id'                 => $media->id,
                'model_type'         => $media->model_type,
                'model_id'           => $media->model_id,
                'uuid'               => $media->uuid,
                'collection_name'    => $media->collection_name,
                'name'               => $media->name,
                'file_name'          => $media->file_name,
                'mime_type'          => $media->mime_type,
                'disk'               => $media->disk,
                'conversions_disk'   => $media->conversions_disk,
                'size'               => $media->size,
                'manipulations'      => json_encode($media->manipulations),
                'custom_properties'  => json_encode($media->custom_properties),
                'generated_conversions' => json_encode($media->generated_conversions),
                'responsive_images'  => json_encode($media->responsive_images),
                'order_column'       => $media->order_column,
                'created_at'         => $media->created_at->format('Y-m-d H:i:s'),
                'updated_at'         => $media->updated_at->format('Y-m-d H:i:s'),
                'url'                => $url . $mediaUrl,
                'likes_count'        => $mediaMain->likers()->count(),
                'comments'           => $mediaMain->comments

            ];
        });
        return view('users.view', compact('customer', 'media', 'followers', 'followings', 'postcount', 'stories', 'wallet_balance', 'available_balance', 'used_balance', 'transactions','total_credits'));
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
