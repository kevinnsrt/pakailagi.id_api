<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Wishlist;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    public function carts()
    {
        return $this->hasMany(Cart::class, 'id', 'uid');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'id', 'uid');
    }

    protected $fillable = [
        'id',
        'name',
        'number',
        'latitude',
        'longitude',
        'role',
        'profile_picture',
        'email',
        'password',
        'fcm_token',
    ];

    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['profile_picture_url'];

    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture
            ? asset('storage/' . $this->profile_picture)
            : null;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
