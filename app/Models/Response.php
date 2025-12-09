<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    
    protected $guarded = ['id']; // Izinkan mass assignment
    protected $fillable = ['visitor_name', 'choice', 'goodbye_attempts', 'ip_address', 'user_agent'];
    
    // Casting untuk tipe data
    protected $casts = [
        'goodbye_attempts' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}