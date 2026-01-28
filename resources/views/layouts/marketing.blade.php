<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Brand kits for teams</title>
    <link rel="stylesheet" href="/assets/app.css">
</head>
<body>
    <header class="container" style="padding:24px 0; display:flex; align-items:center; justify-content:space-between;">
        <a href="{{ route('landing') }}" style="font-weight:700; font-size:20px;">{{ config('app.name') }}</a>
        <nav style="display:flex; gap:16px; align-items:center;">
            <a href="{{ route('pricing') }}">Pricing</a>
            <a href="{{ route('faq') }}">FAQ</a>
            @auth
                <a href="{{ route('app.dashboard') }}" class="btn btn-primary">Go to app</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-secondary">Log in</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Get Started Free</a>
            @endauth
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer style="margin-top:80px; padding:40px 0; border-top:1px solid #e2e8f0;">
        <div class="container" style="display:flex; flex-direction:column; gap:12px;">
            <strong>{{ config('app.name') }}</strong>
            <span style="color:#64748b;">Branding kits that scale with your clients.</span>
            <div style="display:flex; gap:16px; font-size:14px;">
                <a href="{{ route('pricing') }}">Pricing</a>
                <a href="{{ route('faq') }}">FAQ</a>
            </div>
        </div>
    </footer>
</body>
</html>
