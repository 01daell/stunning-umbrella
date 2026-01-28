@extends('layouts.app')

@section('content')
<h1>Billing</h1>
<p style="color:#64748b;">Manage your subscription and upgrades.</p>

<div class="card" style="margin-top:16px;">
    <h3>Current plan: {{ ucfirst($plan) }}</h3>
    <p>Status: {{ $status }}</p>
    @if($workspace->subscription)
        <form method="post" action="{{ route('app.billing.portal') }}">
            @csrf
            <button class="btn btn-secondary" type="submit">Open Stripe portal</button>
        </form>
    @endif
</div>

<div style="display:grid; gap:16px; margin-top:24px;">
    <div class="card">
        <h3>Starter</h3>
        <p>$9 / month</p>
        <form method="post" action="{{ route('app.billing.checkout', 'starter') }}">
            @csrf
            <button class="btn btn-primary" type="submit">Start Starter</button>
        </form>
    </div>
    <div class="card">
        <h3>Pro</h3>
        <p>$29 / month</p>
        <form method="post" action="{{ route('app.billing.checkout', 'pro') }}">
            @csrf
            <button class="btn btn-primary" type="submit">Go Pro</button>
        </form>
    </div>
    <div class="card">
        <h3>Agency</h3>
        <p>$99 / month</p>
        <form method="post" action="{{ route('app.billing.checkout', 'agency') }}">
            @csrf
            <button class="btn btn-primary" type="submit">Start Agency</button>
        </form>
    </div>
</div>
@endsection
