<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #0f172a; }
        h1, h2 { color: #1e1b4b; }
        .section { margin-bottom: 24px; }
        .watermark { position: fixed; top: 40%; left: 30%; font-size: 48px; color: rgba(79,70,229,0.15); transform: rotate(-30deg); }
    </style>
</head>
<body>
    @if($watermark)
        <div class="watermark">StudioKit</div>
    @endif

    @if($whiteLabel && $whiteLabel['name'])
        <h1>{{ $whiteLabel['name'] }} Brand Guide</h1>
    @else
        <h1>{{ $kit->name }} Brand Guide</h1>
    @endif

    <div class="section">
        <h2>Overview</h2>
        <p>{{ $kit->description }}</p>
    </div>

    <div class="section">
        <h2>Logos</h2>
        <ul>
            @foreach($kit->assets as $asset)
                <li>{{ $asset->original_name }} ({{ $asset->type }})</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <h2>Colors</h2>
        <ul>
            @foreach($kit->colors as $color)
                <li>{{ $color->name }} - {{ $color->hex }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <h2>Typography</h2>
        <p>Heading: {{ $kit->fontSelection?->heading_font }}</p>
        <p>Body: {{ $kit->fontSelection?->body_font }}</p>
    </div>

    <div class="section">
        <h2>Usage notes</h2>
        <strong>Do</strong>
        <ul>
            @foreach(($kit->usage_do ?? []) as $note)
                <li>{{ $note }}</li>
            @endforeach
        </ul>
        <strong>Don't</strong>
        <ul>
            @foreach(($kit->usage_dont ?? []) as $note)
                <li>{{ $note }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <h2>Templates</h2>
        <ul>
            @foreach($kit->templates as $template)
                <li>{{ $template->type }}</li>
            @endforeach
        </ul>
    </div>
</body>
</html>
