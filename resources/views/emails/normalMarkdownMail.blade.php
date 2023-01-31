@component('mail::message')
# Introduction
Dear {{$reciever}},

{{$content}}

{{-- @component('mail::button', ['url' => ''])
Buy Fresh
@endcomponent --}}

Thanks,<br>
{{$sender}}<br>
{{ config('app.name') }}
@endcomponent
