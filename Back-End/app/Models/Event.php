<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cover', 
        'banner', 
        'map',   
        'date',
        'user_id',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }
}
