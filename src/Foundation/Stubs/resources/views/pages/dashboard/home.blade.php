@extends('layouts.app')

@section('content')
    <div class="ui container centered stackable grid">
        <div class="ten wide column">
            @component('components.shared.panel')
                @slot('header', 'Header')
                Panel content
            @endcomponent

            @component('components.shared.panel')
                @slot('header', 'Header with actions')
                @slot('actions') 
                    <button class="ui tiny compact basic button">edit</button>
                    <button class="ui tiny compact basic icon button"><i class="trash icon"></i></button>
                @endslot
                Panel content
            @endcomponent
        </div>
    </div>
@endsection
