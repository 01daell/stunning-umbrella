@php
    $url = route('invites.accept', $invite->token);
@endphp

<p>You have been invited to join {{ $invite->workspace->name }} on StudioKit.</p>
<p>Role: {{ $invite->role }}</p>
<p><a href="{{ $url }}">Accept invite</a></p>
<p>This invite expires on {{ $invite->expires_at?->toDayDateTimeString() }}.</p>
