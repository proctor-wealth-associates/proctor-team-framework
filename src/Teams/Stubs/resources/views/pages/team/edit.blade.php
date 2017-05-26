@extends('layouts.app')

@section('content')
    <div class="ui container centered stackable grid">

        <div class="four wide column">
            @include('pages.team.edit.avatar')
        </div>

        <div class="twelve wide column">
            @include('pages.team.edit.information')

            @include('pages.team.edit.modal-delete')
            <button class="ui fluid negative button" data-toggle="modal" data-target="#deleteModal">
                Delete {{ $team->name }}
            </button>
        </div>

    </div>
@endsection