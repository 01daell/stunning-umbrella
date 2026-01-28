<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_kit_id',
        'type',
        'path',
        'mime',
        'size',
        'original_name',
    ];

    public function kit()
    {
        return $this->belongsTo(BrandKit::class, 'brand_kit_id');
    }
}
