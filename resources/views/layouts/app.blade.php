<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} App</title>
    <link rel="stylesheet" href="/assets/app.css">
</head>
<body>
    <header style="border-bottom:1px solid #e2e8f0; background:#fff;">
        <div class="container" style="padding:16px 0; display:flex; align-items:center; justify-content:space-between;">
            <a href="{{ route('app.dashboard') }}" style="font-weight:700; font-size:18px;">{{ config('app.name') }}</a>
            <form method="post" action="{{ route('app.workspace.switch') }}" style="display:flex; gap:12px; align-items:center;">
                @csrf
                <select name="workspace_id" onchange="this.form.submit()" style="padding:8px 12px; border-radius:10px; border:1px solid #e2e8f0;">
                    @foreach(auth()->user()->workspaces as $workspaceOption)
                        <option value="{{ $workspaceOption->id }}" @selected(session('workspace_id') == $workspaceOption->id)>{{ $workspaceOption->name }}</option>
                    @endforeach
                </select>
            </form>
            <nav style="display:flex; gap:16px; align-items:center;">
                <a href="{{ route('app.dashboard') }}">Dashboard</a>
                <a href="{{ route('app.workspace.members') }}">Members</a>
                <a href="{{ route('app.billing') }}">Billing</a>
                <a href="{{ route('app.settings') }}">Settings</a>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-secondary" type="submit">Log out</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="container" style="padding:32px 0;">
        @if(session('status'))
            <div class="card" style="background:#ecfeff; border-color:#67e8f9; margin-bottom:24px;">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
