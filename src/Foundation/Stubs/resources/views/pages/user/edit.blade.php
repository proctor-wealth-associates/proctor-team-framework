@extends('layouts.app')

@section('content')
    <div class="ui container centered stackable grid">

        @if (session('success'))
            <div class="sixteen wide column">
                <div class="ui success message">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="six wide column">
            <div class="ui segment">
                <div class="ui centered header">
                    Profile picture
                </div>
                <img class="ui small circular centered image" src="{{ $user->photo_url }}">
                @include('pages.user.edit.form-avatar')
            </div>
        </div>

        <div class="ten wide column">
            <div class="ui segment">
                <div class="ui header">
                    Main information
                </div>
                @include('pages.user.edit.form-information')
            </div>

            <div class="ui segment">
                <div class="ui header">
                    Security
                </div>
                @include('pages.user.edit.form-password')
            </div>

            @include('pages.user.edit.modal-delete')
            <button class="ui fluid negative button" data-toggle="modal" data-target="#deleteModal">
                Delete my account
            </button>
        </div>
    </div>
@endsection
