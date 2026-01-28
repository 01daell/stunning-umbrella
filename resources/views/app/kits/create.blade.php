@extends('layouts.app')

@section('content')
<div class="card" style="max-width:720px; margin:0 auto;">
    <h2>Create a new brand kit</h2>
    <form method="post" action="{{ route('app.kits.store') }}" style="display:grid; gap:16px; margin-top:16px;">
        @csrf
        <label>
            Kit name
            <input type="text" name="name" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
        </label>
        <label>
            Tagline
            <input type="text" name="tagline" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
        </label>
        <label>
            Description
            <textarea name="description" rows="3" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;"></textarea>
        </label>
        <button class="btn btn-primary" type="submit">Create kit</button>
    </form>
</div>
@endsection
