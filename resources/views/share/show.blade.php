@extends('layouts.marketing')

@section('content')
<section class="container" style="padding:60px 0;">
    <div class="card">
        <h1>{{ $kit->name }}</h1>
        <p style="color:#64748b;">{{ $kit->tagline }}</p>
        <div style="margin-top:16px;">
            <h3>Colors</h3>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                @foreach($kit->colors as $color)
                    <div class="tag">{{ $color->name }} {{ $color->hex }}</div>
                @endforeach
            </div>
        </div>
        <div style="margin-top:16px;">
            <h3>Fonts</h3>
            <p>{{ $kit->fontSelection?->heading_font }} / {{ $kit->fontSelection?->body_font }}</p>
        </div>
        @if($canZip)
            <div style="margin-top:20px;">
                <a href="{{ route('share.zip', $link->token) }}" class="btn btn-primary">Download ZIP</a>
            </div>
        @else
            <p style="margin-top:20px; color:#64748b;">ZIP downloads are available on Pro+ plans.</p>
        @endif
    </div>
</section>
@endsection
