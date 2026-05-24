<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;
    protected $fillable = ['reg_number', 'brand', 'model', 'owner_id'];
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }
    public function photos(): HasMany
    {
        return $this->hasMany(CarPhoto::class);
    }
}
