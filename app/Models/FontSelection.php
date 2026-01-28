<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FontSelection extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_kit_id',
        'heading_font',
        'body_font',
        'heading_weights',
        'body_weights',
        'source',
    ];

    protected $casts = [
        'heading_weights' => 'array',
        'body_weights' => 'array',
    ];

    public function kit()
    {
        return $this->belongsTo(BrandKit::class, 'brand_kit_id');
    }
}
