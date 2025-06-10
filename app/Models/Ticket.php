<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;  // Fixed the typo here

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'user_id',
    ];

    // Renamed 'use' method to 'user' to avoid PHP reserved word
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    // Relationship with File (One to Many)
    public function files()
    {
        return $this->hasMany(File::class);
    }

    // Many-to-many relationship with Category
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Many-to-many relationship with Label
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
