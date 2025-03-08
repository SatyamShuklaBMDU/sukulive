<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelFollow\Traits\Follower;
use Overtrue\LaravelLike\Traits\Liker;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Customer extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasApiTokens, Follower, Followable, InteractsWithMedia, Liker;

    protected $guarded = [];

    public static function generateUniqueCode()
    {
        do {
            $uniqueNo = 'SUKU' . '' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('customer_id', $uniqueNo)->exists());
        return $uniqueNo;
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'customer_id', 'id');
    }

    public function diamonds()
    {
        return $this->hasOne(CustomerDiamonds::class,'customer_id', 'id');
    }

    public function goldCoins()
    {
        return $this->hasOne(GoldCoinWallet::class, 'customer_id', 'id');
    }

    public function goldCoinWallet()
    {
        return $this->hasOne(GoldCoinWallet::class, 'customer_id');
    }

    public function liveVideCall()
    {
        return $this->hasMany(LiveVideCall::class, 'user_id', 'id');
    }

 
    public function liveVideoCallJoiner()
    {
        return $this->hasMany(LiveVideoCallJoiner::class, 'user_id', 'id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'customer_id', 'id');
    }

    public function transactions()
    {
    return $this->hasMany(Transaction::class);
    }  
    
}
