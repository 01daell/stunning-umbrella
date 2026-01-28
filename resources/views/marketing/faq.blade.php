@extends('layouts.marketing')

@section('content')
<section style="padding:72px 0;">
    <div class="container">
        <h1 style="font-size:32px;">Frequently asked questions</h1>
        <div style="display:grid; gap:16px; margin-top:24px;">
            <div class="card">
                <h3>Can I start for free?</h3>
                <p style="color:#475569;">Yes. The Free plan includes one kit with watermarked PDF exports and template previews.</p>
            </div>
            <div class="card">
                <h3>What happens if I downgrade?</h3>
                <p style="color:#475569;">Your existing kits remain, but you’ll be limited to the plan’s kit count and export features moving forward.</p>
            </div>
            <div class="card">
                <h3>Do you offer annual billing?</h3>
                <p style="color:#475569;">Annual billing is coming soon. Monthly subscriptions are available today.</p>
            </div>
            <div class="card">
                <h3>Can I use StudioKit for client work?</h3>
                <p style="color:#475569;">Yes. Agencies can manage multiple clients and send white-labeled brand guides.</p>
            </div>
            <div class="card">
                <h3>Can my clients access the kits?</h3>
                <p style="color:#475569;">Pro and above plans enable share links, while Agency plans include client invites.</p>
            </div>
            <div class="card">
                <h3>Is my data secure?</h3>
                <p style="color:#475569;">StudioKit uses Stripe for billing and standard Laravel security protections for data access.</p>
            </div>
        </div>
    </div>
</section>

<section style="padding:40px 0 80px; background:#f8fafc;">
    <div class="container">
        <h2>Add-ons</h2>
        <div style="display:grid; gap:16px; margin-top:16px; grid-template-columns:repeat(auto-fit,minmax(220px,1fr));">
            <div class="card">Extra workspace seats</div>
            <div class="card">White-label custom domain</div>
            <div class="card">Done-for-you Brand Kit Setup</div>
            <div class="card">Logo cleanup / vectorization</div>
        </div>
    </div>
</section>
@endsection
