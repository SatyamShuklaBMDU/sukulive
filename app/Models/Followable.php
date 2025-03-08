<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followable extends Model
{
    use HasFactory;

    protected $table = 'followables';

    protected $fillable = [
        'user_id',
        'followable_id',
        'followable_type',
        'accepted_at'
    ];
}
