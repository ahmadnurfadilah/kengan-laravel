<?php

namespace App\Models;

use LucasDotVin\Soulbscription\Models\Plan as SoulbscriptionPlan;

class Plan extends SoulbscriptionPlan
{
    protected $fillable = [
        'grace_days',
        'name',
        'periodicity_type',
        'periodicity',
        'price',
    ];
}
