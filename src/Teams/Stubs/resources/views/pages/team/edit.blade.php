@extends('layouts.app')

@section('content')
    <div class="ui container centered stackable grid">

        <div class="four wide column">
            <div class="ui card">
                <div class="image">
                    <img src="{{ $team->photo_url }}">
                </div>
                <div class="content">
                    <form class="ui form" method="POST" action="{{ route('team.update', $team) }}" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        @component('components.shared.form.field', [ 'name' => 'avatar' ])
                            <input-file name="avatar"></input-file>
                        @endcomponent

                        <input class="ui fluid button" type="submit" value="Update team photo">
                    </form>
                </div>
            </div>
        </div>

        <div class="twelve wide column">
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
        </div>
    </div>
@endsection