<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltyFee extends Model {
    use HasFactory;

    protected $fillable = ['user_id', 'event_id', 'penalty_fee_status_id', 'penalty_fee_price_id'];

    public function penaltyFeeStatus() {
        return $this->hasOne(PenaltyFeeStatus::class, 'id');
    }

    public function penaltyFeePrice() {
        return $this->hasOne(PenaltyFeePrice::class, 'id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id');
    }

    public function event() {
        return $this->hasOne(Event::class, 'id');
    }
}
