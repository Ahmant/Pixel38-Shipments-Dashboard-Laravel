@component('mail::message')
# {{ config('app.name') }} Email Verification

Email verification code

<div class="w-full">
    <span class="m-auto block w-max button button-primary">
        {{ $code }}
    </span>
</div>

@if ($lifetime)
@php
$hours = $lifetime / 3600;
@endphp
The code will be expired in {{ $hours > 1 ? $hours .' hours' : $hours .' hour' }}
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
