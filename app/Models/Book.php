<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'author', 'image', 'copies_available', 'status', 'description',
    ];

    protected $casts = [
        'copies_available' => 'integer',
    ];

    protected $attributes = [
        'copies_available' => 1, // Default value for copies
    ];

    public function setImageAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['image'] = $value;
        }
    }

    public function categories()
{
    return $this->belongsToMany(Category::class, 'book_category');
}


    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class);
    // }

    public function getImageAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    public function borrowedByUsers()
    {
        return $this->belongsToMany(User::class, 'borrows')
            ->withPivot('borrowed_at', 'due_date', 'returned_at', 'fine')
            ->withTimestamps();
    }

    public function wishlistedByUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }
    
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    public function wishlistedBy()
    {
        return $this->hasMany(Wishlist::class);
    }
}
