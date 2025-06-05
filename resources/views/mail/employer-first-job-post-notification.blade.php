<x-mail::message>
Someone from **{{ $company }}** has posted a job for the first time on the platform.
See the details below:

_Title:_
# {{ $title }}

_Description:_
> {!! nl2br($description) !!}

<x-mail::button :url="$url">
View Job Post
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
