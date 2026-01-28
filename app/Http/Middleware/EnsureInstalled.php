<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureInstalled
{
    public function handle(Request $request, Closure $next): Response
    {
        $installed = config('app.key') && User::query()->exists();

        if (!$installed) {
            return redirect()->route('install.index');
        }

        return $next($request);
    }
}
