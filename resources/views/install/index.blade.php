@extends('layouts.marketing')

@section('content')
<section class="container" style="padding:60px 0;">
    <div class="card" style="max-width:640px; margin:0 auto;">
        <h2>Install StudioKit</h2>
        <p style="color:#64748b;">Complete the setup wizard to configure the database and first admin.</p>
        <div style="margin:16px 0;">
            <h4>Environment checks</h4>
            <ul>
                @foreach($checks as $ext => $passed)
                    <li>{{ $ext }}: {{ $passed ? 'OK' : 'Missing' }}</li>
                @endforeach
            </ul>
        </div>
        <form method="post" action="{{ route('install.store') }}" style="display:grid; gap:12px;">
            @csrf
            <label>
                App URL
                <input type="url" name="app_url" required placeholder="https://yourdomain.com" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Database Host
                <input type="text" name="db_host" required value="localhost" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Database Name
                <input type="text" name="db_database" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Database User
                <input type="text" name="db_username" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Database Password
                <input type="password" name="db_password" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Admin name
                <input type="text" name="admin_name" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Admin email
                <input type="email" name="admin_email" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Admin password
                <input type="password" name="admin_password" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Workspace name
                <input type="text" name="workspace_name" required placeholder="StudioKit" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <button class="btn btn-primary" type="submit">Install</button>
        </form>
    </div>
</section>
@endsection
