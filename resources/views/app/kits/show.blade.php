@extends('layouts.app')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h1>{{ $kit->name }}</h1>
        <p style="color:#64748b;">{{ $kit->tagline }}</p>
    </div>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('app.kits.export', $kit) }}" class="btn btn-secondary">Export PDF</a>
        <a href="{{ route('app.kits.share', $kit) }}" class="btn btn-secondary">Share</a>
        <form method="post" action="{{ route('app.kits.destroy', $kit) }}" onsubmit="return confirm('Delete this kit?')">
            @csrf
            @method('delete')
            <button class="btn btn-secondary" type="submit">Delete</button>
        </form>
    </div>
</div>

<div class="card" style="margin-top:24px;">
    <h2>Overview</h2>
    <form method="post" action="{{ route('app.kits.update', $kit) }}" style="display:grid; gap:12px; margin-top:12px;">
        @csrf
        @method('put')
        <label>
            Name
            <input type="text" name="name" value="{{ $kit->name }}" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
        </label>
        <label>
            Tagline
            <input type="text" name="tagline" value="{{ $kit->tagline }}" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
        </label>
        <label>
            Description
            <textarea name="description" rows="3" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">{{ $kit->description }}</textarea>
        </label>
        <label>
            Voice keywords (comma or line separated)
            <textarea name="voice_keywords_text" rows="2" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">{{ implode(', ', $kit->voice_keywords ?? []) }}</textarea>
        </label>
        <label>
            Usage: Do
            <textarea name="usage_do_text" rows="2" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">{{ implode(\"\\n\", $kit->usage_do ?? []) }}</textarea>
        </label>
        <label>
            Usage: Don't
            <textarea name="usage_dont_text" rows="2" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">{{ implode(\"\\n\", $kit->usage_dont ?? []) }}</textarea>
        </label>
        <button class="btn btn-primary" type="submit">Save overview</button>
    </form>
</div>

<div style="display:grid; gap:24px; margin-top:24px;">
    <div class="card">
        <h2>Logos</h2>
        <form method="post" action="{{ route('app.kits.assets.store', $kit) }}" enctype="multipart/form-data" style="display:flex; gap:12px; align-items:center; margin-top:12px;">
            @csrf
            <select name="type" style="padding:8px; border:1px solid #e2e8f0; border-radius:10px;">
                <option value="PRIMARY_LOGO">Primary</option>
                <option value="ICON">Icon</option>
                <option value="MONO">Mono</option>
                <option value="OTHER">Other</option>
            </select>
            <input type="file" name="asset" required>
            <button class="btn btn-secondary" type="submit">Upload</button>
        </form>
        <div style="display:grid; gap:12px; margin-top:16px;">
            @foreach($kit->assets as $asset)
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span>{{ $asset->original_name }} ({{ $asset->type }})</span>
                    <form method="post" action="{{ route('app.kits.assets.destroy', [$kit, $asset]) }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-secondary" type="submit">Remove</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card">
        <h2>Colors</h2>
        <form method="post" action="{{ route('app.kits.colors.store', $kit) }}" style="display:flex; gap:12px; align-items:center; margin-top:12px;">
            @csrf
            <input type="text" name="name" placeholder="Primary" required style="padding:8px; border:1px solid #e2e8f0; border-radius:10px;">
            <input type="text" name="hex" placeholder="#4F46E5" required style="padding:8px; border:1px solid #e2e8f0; border-radius:10px;">
            <button class="btn btn-secondary" type="submit">Add</button>
        </form>
        <div style="display:grid; gap:8px; margin-top:16px;">
            @foreach($kit->colors as $color)
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span>{{ $color->name }} - {{ $color->hex }}</span>
                    <form method="post" action="{{ route('app.kits.colors.destroy', [$kit, $color]) }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-secondary" type="submit">Remove</button>
                    </form>
                </div>
            @endforeach
        </div>
        @if(count($contrasts))
            <div style="margin-top:16px;">
                <h3>Contrast helper</h3>
                <div style="display:grid; gap:6px;">
                    @foreach($contrasts as $contrast)
                        <div>{{ $contrast['pair'] }} — {{ $contrast['ratio'] }} {{ $contrast['passes'] ? 'AA' : 'Fail' }}</div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="card">
        <h2>Typography</h2>
        <form method="post" action="{{ route('app.kits.fonts.update', $kit) }}" style="display:grid; gap:12px; margin-top:12px;">
            @csrf
            @method('put')
            <label>
                Heading font
                <input type="text" name="heading_font" value="{{ $kit->fontSelection->heading_font ?? '' }}" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <label>
                Body font
                <input type="text" name="body_font" value="{{ $kit->fontSelection->body_font ?? '' }}" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px;">
            </label>
            <input type="hidden" name="source" value="Google Fonts">
            <button class="btn btn-secondary" type="submit">Save fonts</button>
        </form>
    </div>

    <div class="card">
        <h2>Templates</h2>
        <form method="post" action="{{ route('app.kits.templates', $kit) }}">
            @csrf
            <button class="btn btn-secondary" type="submit">Generate templates</button>
        </form>
        <div style="margin-top:12px; display:grid; gap:8px;">
            @foreach($kit->templates as $template)
                <div>{{ $template->type }} - {{ $template->path }}</div>
            @endforeach
        </div>
    </div>
</div>
@endsection
