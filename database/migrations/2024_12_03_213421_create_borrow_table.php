<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who borrowed
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Borrowed book
            $table->datetime('borrowed_at');  // Timestamp for when the book was borrowed
            $table->datetime('due_date');    // Timestamp for the due date
            $table->datetime('returned_at')->nullable();  // Nullable timestamp for return
            $table->decimal('fine', 8, 2)->default(0);    // Fine for late returns
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_records');
    }
};
