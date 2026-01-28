<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ShareLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_kit_id',
        'token',
        'revoked_at',
    ];

    protected $casts = [
        'revoked_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function (ShareLink $link) {
            if (!$link->token) {
                $link->token = Str::random(40);
            }
        });
    }

    public function kit()
    {
        return $this->belongsTo(BrandKit::class, 'brand_kit_id');
    }

    public function isActive(): bool
    {
        return $this->revoked_at === null;
    }
}
