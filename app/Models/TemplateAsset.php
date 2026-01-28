<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_kit_id',
        'type',
        'path',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function kit()
    {
        return $this->belongsTo(BrandKit::class, 'brand_kit_id');
    }
}
