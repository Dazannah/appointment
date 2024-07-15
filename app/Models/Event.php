<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model {
    use HasFactory;
    //use Searchable;

    protected $fillable = ['start', 'end', 'title', 'user_id'];

    public function toSearchableArray() {
        return [
            'start' => $this->start,
            'end' => $this->bodendy,
            'user_id' => $this->user_id,
        ];
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
