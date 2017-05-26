@extends('layouts.app')

@section('content')
    <div class="ui container centered stackable grid">
        <div class="ten wide column">

             {{-- Header --}}
            <h4 class="ui top attached block level header">
                <span class="expand">My teams</span>
                <a class="ui tiny compact basic button" href="{{ route('team.create') }}">create</a>
            </h4>
            
            @if (! $teams->isEmpty())

                {{-- Teams content --}}
                <table class="ui bottom attached table">
                    <tbody>
                        @foreach($teams as $team)
                            <tr
                                @if (Auth::user()->isCurrentTeam($team))
                                    class="positive"
                                @endif
                            >
                                <td>
                                    <a 
                                        class="ui image{{ Auth::user()->isCurrentTeam($team) ? ' teal' : '' }} label" 
                                        href="{{ route('team.show', $team) }}"
                                    >
                                        <img src="{{ $team->photo_url }}">
                                        {{ $team->name }}
                                    </a>
                                </td>
                                <td>
                                    @if(Auth::user()->isOwnerOfTeam($team))
                                        <span class="ui tiny label">Owner</span>
                                    @endif
                                </td>
                                <td class="right aligned">
                                    @if(! Auth::user()->isCurrentTeam($team))
                                        <a href="{{ route('team.switch', $team) }}" class="ui tiny compact basic button">
                                            <i class="sign in icon"></i> Switch
                                        </a>
                                    @endif

                                    @if(Auth::user()->isOwnerOfTeam($team))
                                        <a href="{{ route('team.edit', $team) }}" class="ui tiny compact basic button">
                                            <i class="edit icon"></i> Edit
                                        </a>

                                        <form 
                                            style="display: inline-block;" 
                                            action="{{ route('team.destroy', $team) }}" 
                                            method="POST"
                                        >
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button class="ui tiny compact basic button"><i class="trash icon"></i> Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @else

                {{-- Empty content --}}
                <div class="ui bottom attached segment">
                    <em>You have no teams.</em>
                </div>

            @endif
        </div>
    </div>
@endsection
