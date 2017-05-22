@extends('layouts.app')

@section('content')
    <div class="ui container centered stackable grid">
        <div class="ten wide column">
            @include('components.user.card')
        </div>
    </div>
@endsection
