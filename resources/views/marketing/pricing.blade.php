@extends('layouts.marketing')

@section('content')
<section style="padding:72px 0; text-align:center;">
    <div class="container">
        <h1 style="font-size:36px; margin-bottom:12px;">Your brand, packaged beautifully.</h1>
        <p style="color:#475569; font-size:18px; max-width:720px; margin:0 auto;">
            Create professional branding kits with export-ready assets for clients, teams, and contractors.
        </p>
    </div>
</section>

<section class="container" style="display:grid; gap:24px; grid-template-columns:repeat(auto-fit,minmax(220px,1fr));">
    <div class="card">
        <h3>StudioKit Free</h3>
        <p style="font-size:24px; font-weight:700;">$0<span style="font-size:14px;">/mo</span></p>
        <ul style="color:#475569; padding-left:18px;">
            <li>1 brand kit</li>
            <li>Watermarked PDF export</li>
            <li>Template previews</li>
        </ul>
        <a href="{{ route('register') }}" class="btn btn-secondary" style="margin-top:16px;">Get Started Free</a>
        <p style="font-size:12px; color:#64748b;">No credit card required.</p>
    </div>
    <div class="card">
        <h3>StudioKit Starter</h3>
        <p style="font-size:24px; font-weight:700;">$9<span style="font-size:14px;">/mo</span></p>
        <ul style="color:#475569; padding-left:18px;">
            <li>Up to 3 brand kits</li>
            <li>Watermark-free PDF</li>
            <li>Social + favicon + email templates</li>
        </ul>
        <a href="{{ route('register') }}" class="btn btn-primary" style="margin-top:16px;">Start Starter</a>
        <p style="font-size:12px; color:#64748b;">Best for solo businesses.</p>
    </div>
    <div class="card" style="border:2px solid #4f46e5;">
        <span class="badge">Most Popular</span>
        <h3>StudioKit Pro</h3>
        <p style="font-size:24px; font-weight:700;">$29<span style="font-size:14px;">/mo</span></p>
        <ul style="color:#475569; padding-left:18px;">
            <li>Unlimited kits</li>
            <li>Share links + ZIP export</li>
            <li>Saved presets + export history</li>
        </ul>
        <a href="{{ route('register') }}" class="btn btn-primary" style="margin-top:16px;">Go Pro</a>
    </div>
    <div class="card">
        <span class="badge">For Agencies</span>
        <h3>StudioKit Agency</h3>
        <p style="font-size:24px; font-weight:700;">$99<span style="font-size:14px;">/mo</span></p>
        <ul style="color:#475569; padding-left:18px;">
            <li>Multi-client workspaces</li>
            <li>Team roles + client invites</li>
            <li>White-label PDF exports</li>
        </ul>
        <a href="{{ route('register') }}" class="btn btn-primary" style="margin-top:16px;">Start Agency</a>
        <p style="font-size:12px; color:#64748b;">Priority support label.</p>
    </div>
    <div class="card">
        <h3>StudioKit Enterprise</h3>
        <p style="font-size:24px; font-weight:700;">Custom</p>
        <ul style="color:#475569; padding-left:18px;">
            <li>SSO + custom domains</li>
            <li>API access + bulk user management</li>
            <li>SLA-backed support</li>
        </ul>
        <a href="mailto:sales@studiokit.local" class="btn btn-secondary" style="margin-top:16px;">Contact Sales</a>
    </div>
</section>

<section class="container" style="padding:60px 0;">
    <div class="card">
        <h2>Plan comparison</h2>
        <p style="color:#64748b;">Cancel anytime. Upgrade or downgrade in seconds. Secure payments powered by Stripe.</p>
        <table>
            <thead>
                <tr>
                    <th>Brand Kit Builder</th>
                    <th>Free</th>
                    <th>Starter</th>
                    <th>Pro</th>
                    <th>Agency</th>
                    <th>Enterprise</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Kit count</td>
                    <td>1</td>
                    <td>3</td>
                    <td>Unlimited</td>
                    <td>Unlimited</td>
                    <td>Unlimited</td>
                </tr>
                <tr>
                    <td>Logos, palettes, fonts, voice notes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td>Template previews</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
            </tbody>
        </table>

        <table style="margin-top:24px;">
            <thead>
                <tr>
                    <th>Templates</th>
                    <th>Free</th>
                    <th>Starter</th>
                    <th>Pro</th>
                    <th>Agency</th>
                    <th>Enterprise</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Social profile + banner</td>
                    <td>Profile only</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td>Favicon + email signature</td>
                    <td>No</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td>Saved presets</td>
                    <td>No</td>
                    <td>No</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
            </tbody>
        </table>

        <table style="margin-top:24px;">
            <thead>
                <tr>
                    <th>Sharing & Exports</th>
                    <th>Free</th>
                    <th>Starter</th>
                    <th>Pro</th>
                    <th>Agency</th>
                    <th>Enterprise</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PDF export</td>
                    <td>Watermarked</td>
                    <td>Clean</td>
                    <td>Clean</td>
                    <td>White-label</td>
                    <td>White-label</td>
                </tr>
                <tr>
                    <td>Share links</td>
                    <td>No</td>
                    <td>No</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td>ZIP export package</td>
                    <td>No</td>
                    <td>No</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
            </tbody>
        </table>

        <table style="margin-top:24px;">
            <thead>
                <tr>
                    <th>Workspace & Teams</th>
                    <th>Free</th>
                    <th>Starter</th>
                    <th>Pro</th>
                    <th>Agency</th>
                    <th>Enterprise</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Multi-client workspaces</td>
                    <td>No</td>
                    <td>No</td>
                    <td>No</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td>Team roles + invites</td>
                    <td>No</td>
                    <td>No</td>
                    <td>No</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
            </tbody>
        </table>

        <table style="margin-top:24px;">
            <thead>
                <tr>
                    <th>Security & Scale</th>
                    <th>Free</th>
                    <th>Starter</th>
                    <th>Pro</th>
                    <th>Agency</th>
                    <th>Enterprise</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>SSO, custom domains, API access, SLA</td>
                    <td>—</td>
                    <td>—</td>
                    <td>—</td>
                    <td>—</td>
                    <td>Included</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection
