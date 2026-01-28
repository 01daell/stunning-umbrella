<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandKit extends Model
{
    use HasFactory;

    protected $fillable = [
        'workspace_id',
        'name',
        'tagline',
        'description',
        'voice_keywords',
        'usage_do',
        'usage_dont',
    ];

    protected $casts = [
        'voice_keywords' => 'array',
        'usage_do' => 'array',
        'usage_dont' => 'array',
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function assets()
    {
        return $this->hasMany(BrandAsset::class);
    }

    public function colors()
    {
        return $this->hasMany(Color::class)->orderBy('sort_order');
    }

    public function fontSelection()
    {
        return $this->hasOne(FontSelection::class);
    }

    public function templates()
    {
        return $this->hasMany(TemplateAsset::class);
    }

    public function shareLinks()
    {
        return $this->hasMany(ShareLink::class);
    }
}
