@extends('layouts.marketing')

@section('content')
<section style="padding:80px 0; background:linear-gradient(180deg,#eef2ff 0%, #ffffff 60%);">
    <div class="container" style="text-align:center;">
        <span class="badge">StudioKit SaaS</span>
        <h1 style="font-size:40px; margin:16px 0;">Pricing that scales with your brand</h1>
        <p style="font-size:18px; color:#475569; max-width:720px; margin:0 auto 24px;">
            Start free. Upgrade when you’re ready to export, share, and manage multiple client kits.
        </p>
        <p style="color:#64748b; max-width:760px; margin:0 auto 32px;">
            StudioKit helps you build a clean, consistent brand kit—logos, colors, typography, and templates—in minutes.
        </p>
        <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap;">
            <a href="{{ route('register') }}" class="btn btn-primary">Get Started Free</a>
            <a href="{{ route('pricing') }}" class="btn btn-secondary">View Plans</a>
        </div>
    </div>
</section>

<section class="container" style="padding:60px 0; display:grid; gap:24px; grid-template-columns:repeat(auto-fit,minmax(240px,1fr));">
    <div class="card">
        <h3>Brand kit builder</h3>
        <p style="color:#64748b;">Organize logos, colors, typography, voice, and usage notes in one client-ready workspace.</p>
    </div>
    <div class="card">
        <h3>Export-ready assets</h3>
        <p style="color:#64748b;">Generate PDF brand guides, social templates, and favicon packs from your saved assets.</p>
    </div>
    <div class="card">
        <h3>Agency workspaces</h3>
        <p style="color:#64748b;">Invite clients, manage multiple kits, and deliver white-labeled PDFs on Agency plans.</p>
    </div>
</section>

<section style="padding:60px 0; background:#0f172a; color:#fff;">
    <div class="container" style="display:flex; flex-direction:column; gap:16px; align-items:flex-start;">
        <h2>Ship brand kits faster with StudioKit.</h2>
        <p style="color:#cbd5f5; max-width:640px;">Move from assets to approvals without endless PDF revisions. Upgrade anytime and keep your kits organized.</p>
        <a href="{{ route('pricing') }}" class="btn btn-primary">Compare plans</a>
    </div>
</section>
@endsection
