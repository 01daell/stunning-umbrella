@extends('layouts.marketing')

@section('content')
<section class="container" style="padding:60px 0;">
    <div class="card" style="max-width:520px; margin:0 auto;">
        <h2>Create your StudioKit account</h2>
        <form method="post" action="{{ route('register') }}" style="display:grid; gap:16px; margin-top:16px;">
            @csrf
            @if(request('invite'))
                <input type="hidden" name="invite_token" value="{{ request('invite') }}">
            @endif
            <label>
                Full name
                <input type="text" name="name" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Email
                <input type="email" name="email" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Password
                <input type="password" name="password" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Confirm password
                <input type="password" name="password_confirmation" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            @if(!request('invite'))
                <label>
                    Workspace name
                    <input type="text" name="workspace_name" required placeholder="Your brand or agency" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
                </label>
            @endif
            <button class="btn btn-primary" type="submit">Create account</button>
        </form>
    </div>
</section>
@endsection
