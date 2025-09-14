<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'payable_id',
        'payable_type',
        'amount',
        'currency',
        'chain_id',
        'sender_address',
        'treasure_address',
        'transaction_hash',
        'status',
        'verified_by',
        'meta',
        'due_at',
        'paid_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'due_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payable()
    {
        return $this->morphTo();
    }

    public function setExpired()
    {
        $this->attributes['status'] = 'expired';
        self::save();
    }

    public function setFailed()
    {
        $this->attributes['status'] = 'failed';
        self::save();
    }

    public function setCanceled()
    {
        $this->attributes['status'] = 'canceled';
        self::save();
    }

    public function setSuccess($verifiedBy = null)
    {
        $this->attributes['status'] = 'success';
        $this->verified_by = $verifiedBy;
        if ($this->paid_at == null) {
            $this->attributes['paid_at'] = now();
        }
        self::save();

        if ($this->payable_type == 'plan') {
            $plan = Plan::withTrashed()->find($this->payable_id);
            $this->user->subscribeTo($plan);
        }
    }
}
