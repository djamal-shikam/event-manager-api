<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'title', 
        'description', 
        'dateEvent', 
        'location', 
        'maxParticipants'
    ];

    public function participants()
    {
        return $this->belongsToMany(Participant::class);
    }
}
