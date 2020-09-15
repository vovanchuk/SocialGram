<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['user_id', 'post_id', 'text'];

    protected $casts = ['post_id' => 'integer', 'user_id' => 'integer'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
