@component('mail::message')
# Introduction

Hello {{ $memberName }}

A member of our society as requested you to become his gurantor.
Please note if you dont respond in 24hrs it will be assumed you have 
obliged to the Request

@component('mail::button', ['url' => ''])
Button Accept
@endcomponent

@component('mail::button', ['url' => ''])
Button Reject
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
