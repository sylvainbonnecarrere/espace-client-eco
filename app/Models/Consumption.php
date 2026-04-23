<?php

namespace App\Models;

use Database\Factories\ConsumptionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['contract_id', 'month', 'value'])]
class Consumption extends Model
{
    /** @use HasFactory<ConsumptionFactory> */
    use HasFactory;

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}
