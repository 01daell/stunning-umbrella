@extends('layouts.app')

@section('content')
<h1>Profile settings</h1>
<div class="card" style="max-width:520px; margin-top:16px;">
    <form method="post" action="{{ route('app.settings.update') }}" style="display:grid; gap:12px;">
        @csrf
        @method('put')
        <label>
            Name
            <input type="text" name="name" value="{{ $user->name }}" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
        </label>
        <label>
            Email
            <input type="email" name="email" value="{{ $user->email }}" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
        </label>
        <label>
            New password
            <input type="password" name="password" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
        </label>
        <label>
            Confirm password
            <input type="password" name="password_confirmation" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
        </label>
        <button class="btn btn-primary" type="submit">Save changes</button>
    </form>
</div>
@endsection
