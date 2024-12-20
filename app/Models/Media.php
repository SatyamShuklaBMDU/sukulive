<?php

namespace App\Models;

use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Like;
use Overtrue\LaravelLike\Traits\Likeable;

class Media extends BaseMedia
{
    use Likeable, HasComments;

    protected $table = 'media';

    public function likes()
    {
        return $this->hasMany(Like::class,'likeable_id');
    }
}
