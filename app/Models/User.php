<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

   // app/Models/User.php

// public function borrowedBooks()
// {
//     return $this->hasMany(BorrowedBook::class);
// }
public function borrows()
{
    return $this->hasMany(Borrow::class);
}

    // Mutator for profile image
    public function setProfileImageAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['profile_image'] = $value;
        }
    }

    // Accessor for profile image
    public function getProfileImageAttribute($value)
    {
        return $value ? asset('storage/' . $value) : asset('images/default-user.png');
    }


    public function wishlistItems()
     {
       return $this->hasMany(Wishlist::class);
     }
     
     public function borrowedBooks()
    {
        return $this->belongsToMany(Book::class, 'borrows')
            ->withPivot('borrowed_at', 'due_date', 'returned_at', 'fine')
            ->withTimestamps();
    }

    // Wishlist Relationship
    public function wishlist()
    {
        return $this->belongsToMany(Book::class, 'wishlists')->withTimestamps();
    }

    // Notifications Relationship
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

     public function hasRole($role)
     {
         return $this->hasRole($role); // Use the HasRoles trait's method
     }


}
