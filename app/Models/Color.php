<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_kit_id',
        'name',
        'hex',
        'sort_order',
        'locked',
    ];

    protected $casts = [
        'locked' => 'boolean',
    ];

    public function kit()
    {
        return $this->belongsTo(BrandKit::class, 'brand_kit_id');
    }
}
