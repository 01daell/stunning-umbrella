@extends('layouts.app')

@section('content')
<h1>Workspace members</h1>
<p style="color:#64748b;">Manage team access for {{ $workspace->name }}.</p>

<div class="card" style="margin-top:16px;">
    <h3>Invite a member</h3>
    @if($canInvite)
        <form method="post" action="{{ route('app.workspace.invites.store') }}" style="display:flex; gap:12px; align-items:center; margin-top:12px;">
            @csrf
            <input type="email" name="email" placeholder="client@email.com" required style="flex:1; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            <select name="role" style="padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
                <option value="MEMBER">Member</option>
                <option value="ADMIN">Admin</option>
                <option value="OWNER">Owner</option>
            </select>
            <button class="btn btn-primary" type="submit">Send invite</button>
        </form>
    @else
        <p>Upgrade to Agency to invite clients.</p>
    @endif
</div>

<div class="card" style="margin-top:16px;">
    <h3>Workspace settings</h3>
    <form method="post" action="{{ route('app.workspace.settings.update') }}" enctype="multipart/form-data" style="display:grid; gap:12px; margin-top:12px;">
        @csrf
        @method('put')
        <label>
            Workspace name
            <input type="text" name="name" value="{{ $workspace->name }}" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
        </label>
        <label>
            White-label name (Agency+)
            <input type="text" name="white_label_name" value="{{ $workspace->white_label_name }}" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
        </label>
        <label>
            White-label logo
            <input type="file" name="white_label_logo">
        </label>
        <button class="btn btn-secondary" type="submit">Save workspace</button>
    </form>
</div>

<div class="card" style="margin-top:16px;">
    <h3>Create a new workspace</h3>
    <form method="post" action="{{ route('app.workspace.create') }}" style="display:flex; gap:12px; align-items:center; margin-top:12px;">
        @csrf
        <input type="text" name="name" placeholder="New client workspace" required style="flex:1; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
        <button class="btn btn-secondary" type="submit">Create workspace</button>
    </form>
    <p style="font-size:12px; color:#64748b; margin-top:8px;">Agency plans can manage multiple workspaces.</p>
</div>

<div style="margin-top:24px; display:grid; gap:8px;">
    @foreach($workspace->members as $member)
        <div class="card" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <strong>{{ $member->name }}</strong>
                <div style="color:#64748b; font-size:12px;">{{ $member->email }}</div>
            </div>
            <span class="tag">{{ $member->pivot->role }}</span>
        </div>
    @endforeach
</div>
@endsection
