<?php

namespace App\Entity;

use App\Entity\User;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = ['file'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
