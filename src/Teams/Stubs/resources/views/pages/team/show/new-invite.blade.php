
@can('sendInvite', $team)
    @component('components.shared.panel')
        @slot('header', 'Invite new members')

        <form class="ui form" method="POST" action="{{ route('team.invite', $team) }}">
            {{ csrf_field() }}

            @component('components.shared.form.field', [ 'name' => 'email' ])
                <input type="email" name="email" placeholder="E-mail address" value="{{ old('email') }}">
            @endcomponent

            <input class="ui fluid button" type="submit" value="Invite to Team">
        </form>
    @endcomponent
@endcan
