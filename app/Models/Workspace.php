<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'white_label_name',
        'white_label_logo_path',
        'created_by',
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, 'workspace_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function kits()
    {
        return $this->hasMany(BrandKit::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function invites()
    {
        return $this->hasMany(Invite::class);
    }
}
