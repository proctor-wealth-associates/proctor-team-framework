
@component('components.shared.panel')
    @slot('header', 'Main information')
    @slot('actions')
        <a class="ui tiny compact basic button" href="{{ route('team.show', $team) }}">cancel</a>
    @endslot

    <form class="ui form" method="POST" action="{{ route('team.update', $team) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        @component('components.shared.form.field', [ 'name' => 'name' ])
            <input type="text" name="name" placeholder="Team Name" value="{{ old('name', $team->name) }}">
        @endcomponent

        <input class="ui fluid button" type="submit" value="Update team">
    </form>
@endcomponent
