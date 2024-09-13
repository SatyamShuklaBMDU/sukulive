<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Customer extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $guarded = [];

    public static function generateUniqueCode()
    {
        do {
            $uniqueNo = 'SUKU' . '' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('customer_id', $uniqueNo)->exists());
        return $uniqueNo;
    }
}
