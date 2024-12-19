<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftHistory extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    public function receiver()
    {
        return $this->belongsTo(Customer::class, 'receiver_id');
    }

    public function sender()
    {
        return $this->belongsTo(Customer::class, 'sender_id');
    }
}
