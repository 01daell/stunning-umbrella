@extends('layouts.app')

@section('content')
<h1>Share links</h1>
<p style="color:#64748b;">Create read-only links for {{ $kit->name }}.</p>

@if($canShare)
    <form method="post" action="{{ route('app.kits.share.store', $kit) }}" style="margin:16px 0;">
        @csrf
        <button class="btn btn-primary" type="submit">Create share link</button>
    </form>
@else
    <div class="card">Upgrade to Pro to enable share links.</div>
@endif

<div style="display:grid; gap:12px; margin-top:12px;">
    @foreach($kit->shareLinks as $link)
        <div class="card" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div>{{ route('share.show', $link->token) }}</div>
                <div style="color:#64748b; font-size:12px;">{{ $link->isActive() ? 'Active' : 'Revoked' }}</div>
            </div>
            @if($link->isActive())
                <form method="post" action="{{ route('app.kits.share.revoke', [$kit, $link]) }}">
                    @csrf
                    @method('put')
                    <button class="btn btn-secondary" type="submit">Revoke</button>
                </form>
            @endif
        </div>
    @endforeach
</div>
@endsection
