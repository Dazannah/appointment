<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkTypes extends Model {
    use HasFactory;

    public function price() {
        return $this->hasOne(Price::class, 'id');
    }
}
