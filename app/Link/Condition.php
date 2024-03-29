<?php

namespace App\Link;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $guarded = [];

    protected $casts = ['values' => 'array'];

    public function alternativeLink()
    {
        return $this->belongsTo(AlternativeLink::class);
    }

    public function conditionType()
    {
        return $this->belongsTo(ConditionType::class);
    }
}
