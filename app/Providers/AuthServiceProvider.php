<?php

namespace App\Providers;

use App\Models\BrandKit;
use App\Models\Workspace;
use App\Policies\BrandKitPolicy;
use App\Policies\WorkspacePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Workspace::class => WorkspacePolicy::class,
        BrandKit::class => BrandKitPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
