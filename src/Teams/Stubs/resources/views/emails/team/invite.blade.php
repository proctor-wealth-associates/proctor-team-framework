@component('mail::message')
# Team Invitation

You have been invited to join {{ $invite->team->name }}. <br>

Click here to join:

@component('mail::button', [ 'url' => route('team.invite.accept', $invite->token) ])
Join {{ $invite->team->name }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
