<?php

namespace App\Entity;

use App\Entity\User;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = ['file', 'favorited', 'duration', 'preview', 'type'];

    protected $hidden = ['file', 'preview'];

    protected $appends = ['url', 'preview_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute()
    {
        return '/storage/stories/' . $this->file;
    }

    public function getPreviewUrlAttribute()
    {
        return '/storage/stories/' . $this->preview;
    }

    public function viewers()
    {
        return $this->belongsToMany(User::class);
    }
}
