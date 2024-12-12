<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'message', 'type', 'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Types of notifications
    const TYPE_BOOK_BORROWED = 'book_borrowed';
    const TYPE_BOOK_RETURNED = 'book_returned';
    const TYPE_FINE_ISSUED = 'fine_issued';
}
