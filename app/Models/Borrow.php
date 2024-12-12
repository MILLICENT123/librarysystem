<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'book_id', 
        'borrowed_at', 
        'due_date', 
        'returned_at', 
        'fine'
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];
    
    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Check if the borrow is overdue
    public function isOverdue()
    {
        return !$this->returned_at && $this->due_date < now();
    }

    // Calculate fine based on overdue days
    public function calculateFine()
    {
        if ($this->isOverdue()) {
            return now()->diffInDays($this->due_date) * 1.00; // $1 fine per overdue day
        }
        return 0;
    }

    // Update fine if overdue
    public function updateFine()
    {
        $this->fine = $this->calculateFine();
        $this->save();
    }
}
