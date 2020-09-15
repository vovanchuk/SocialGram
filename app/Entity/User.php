<?php

namespace App\Entity;

use App\Entity\Post;
use App\Entity\Story;
use Carbon\Carbon;
use DomainException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Entity\User
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property int $role
 * @property string $password
 * @property string|null $title
 * @property string|null $description
 * @property string|null $url
 * @property string $image
 * @property string $lastActivity
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $avatar
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'lastActivity', 'title', 'url', 'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['avatar'];

    public function liked()
    {
        return $this->belongsToMany(Post::class, 'likes_posts');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class)->orderBy('created_at', 'desc');
    }

    public function activeStories()
    {
        return $this->hasMany(Story::class)->where('created_at', '>', Carbon::now()->subHours(24)->toDateTimeString())->orderBy('created_at', 'desc');
    }

    public function favoritedStories()
    {
        return $this->hasMany(Story::class)->where('favorited', '=', 1)->orderBy('created_at', 'desc');
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'desc');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAvatarAttribute()
    {
        return '/storage/profiles/' . $this->image;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following', 'follower');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower', 'following');
    }

    //TODO: EXCLUDE TO CONTAINER:
    public function isFollowing(User $user) : bool
    {
        return $this->followings()->where('following', $user->id)->exists();
    }


    public function addToFollowing(User $user)
    {
        if(Auth::id() === $user->id) {
            throw new DomainException('You cannot follow yourself');
        }
        if($this->isFollowing($user)){
            throw new DomainException('You already following this profile');
        }
        $this->followings()->attach($user);
    }

    public function removeFromFollowing(User $user)
    {
        if(Auth::id() === $user->id) {
            throw new DomainException('You cannot unfollow yourself');
        }
        if(!$this->isFollowing($user)){
            throw new DomainException('You already unfollowed this profile');
        }
        $this->followings()->detach($user);
    }
}
