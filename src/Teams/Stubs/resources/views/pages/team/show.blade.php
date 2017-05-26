@extends('layouts.app')

@section('content')
    <div class="ui container centered stackable grid">

        <div class="four wide column">
            @include('components.team.card')
        </div>

        <div class="twelve wide column">
            @include('pages.team.show.members')
            @include('pages.team.show.pending-invites')
            @include('pages.team.show.new-invite')
        </div>

    </div>
@endsection