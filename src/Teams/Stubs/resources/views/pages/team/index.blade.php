@extends('layouts.app')

@section('content')
    <div class="ui container centered stackable grid">
        <div class="ten wide column">

            <h4 class="ui top attached block level header">
                <span class="expand">My teams</span>
                <a class="ui tiny compact basic button" href="{{ route('team.create') }}">create</a>
            </h4>
            
            @if ($teams->isEmpty())
                @include('pages.team.index.no-team')
            @else
                @include('pages.team.index.team-list')
            @endif
        </div>
    </div>
@endsection
