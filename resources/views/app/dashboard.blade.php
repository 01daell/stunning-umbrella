@extends('layouts.app')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <div>
        <h1>Brand kits</h1>
        <p style="color:#64748b;">Manage kits for {{ $workspace->name }}.</p>
    </div>
    @if($canCreateKit)
        <a class="btn btn-primary" href="{{ route('app.kits.create') }}">New kit</a>
    @else
        <a class="btn btn-secondary" href="{{ route('app.billing') }}">Upgrade to add kits</a>
    @endif
</div>

<form method="get" style="display:flex; gap:12px; margin-bottom:16px;">
    <input type="text" name="search" placeholder="Search kits" value="{{ request('search') }}" style="flex:1; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
    <select name="sort" style="padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
        <option value="recent" @selected(request('sort') !== 'name')>Newest</option>
        <option value="name" @selected(request('sort') === 'name')>Name</option>
    </select>
    <button class="btn btn-secondary" type="submit">Filter</button>
</form>

@if($kits->count())
    <div style="display:grid; gap:16px;">
        @foreach($kits as $kit)
            <div class="card" style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <strong>{{ $kit->name }}</strong>
                    <p style="color:#64748b; margin-top:4px;">{{ $kit->tagline }}</p>
                </div>
                <a class="btn btn-secondary" href="{{ route('app.kits.show', $kit) }}">Open</a>
            </div>
        @endforeach
    </div>

    <div style="margin-top:16px;">{{ $kits->links() }}</div>
@else
    <div class="card">
        <p>No kits yet. Start by creating your first brand kit.</p>
    </div>
@endif
@endsection
