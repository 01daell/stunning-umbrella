@extends('layouts.marketing')

@section('content')
<section class="container" style="padding:60px 0;">
    <div class="card" style="max-width:460px; margin:0 auto;">
        <h2>Welcome back</h2>
        <form method="post" action="{{ route('login') }}" style="display:grid; gap:16px; margin-top:16px;">
            @csrf
            <label>
                Email
                <input type="email" name="email" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Password
                <input type="password" name="password" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label style="display:flex; gap:8px; align-items:center;">
                <input type="checkbox" name="remember"> Remember me
            </label>
            <button class="btn btn-primary" type="submit">Sign in</button>
            <a href="{{ route('password.request') }}" style="font-size:14px; color:#4f46e5;">Forgot password?</a>
        </form>
    </div>
</section>
@endsection
