@extends('layouts.app')

@section('content')
    <div class="ui container centered stackable grid">
        <div class="ten wide column">
            @component('components.shared.panel')
                @slot('header', 'Create a new team')

                <form class="ui form" method="POST" action="{{ route('team.store') }}">
                    {!! csrf_field() !!}

                    @component('components.shared.form.field', [ 'name' => 'name' ])
                        <input type="text" name="name" placeholder="Team Name" value="{{ old('name') }}">
                    @endcomponent

                    <input class="ui fluid button" type="submit" value="Create team">
                </form>
            @endcomponent
        </div>
    </div>
@endsection
