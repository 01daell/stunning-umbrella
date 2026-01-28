@extends('layouts.marketing')

@section('content')
<section class="container" style="padding:60px 0;">
    <div class="card" style="max-width:420px; margin:0 auto;">
        <h2>Set a new password</h2>
        <form method="post" action="{{ route('password.store') }}" style="display:grid; gap:16px; margin-top:16px;">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <label>
                Email
                <input type="email" name="email" value="{{ $request->email }}" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                New password
                <input type="password" name="password" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Confirm password
                <input type="password" name="password_confirmation" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <button class="btn btn-primary" type="submit">Reset password</button>
        </form>
    </div>
</section>
@endsection
