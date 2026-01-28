@extends('layouts.marketing')

@section('content')
<section class="container" style="padding:60px 0;">
    <div class="card" style="max-width:420px; margin:0 auto;">
        <h2>Reset your password</h2>
        <form method="post" action="{{ route('password.email') }}" style="display:grid; gap:16px; margin-top:16px;">
            @csrf
            <label>
                Email
                <input type="email" name="email" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <button class="btn btn-primary" type="submit">Send reset link</button>
        </form>
    </div>
</section>
@endsection
