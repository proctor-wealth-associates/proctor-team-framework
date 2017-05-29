<?php

namespace App\Http\Controllers\Teams;

use Auth;
use App\Team;
use App\User;
use App\Jobs\StoreAvatar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizePolicy(Team::class, [ 'switch' ]);
    }

    /**
     * Display a listing of the user's teams.
     */
    public function index()
    {
        return view('pages.team.index')->withTeams(Auth::user()->teams);
    }

    /**
     * Show the details and members of the given team.
     */
    public function show(Team $team)
    {
        return view('pages.team.show')->withTeam($team);
    }

    /**
     * Show the form for creating a new team.
     */
    public function create()
    {
        return view('pages.team.create');
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(Request $request)
    {
        $team = Team::create([
            'name' => $request->name,
            'owner_id' => $request->user()->getKey()
        ]);

        $request->user()->attachTeam($team);

        return redirect()->route('team.show', $team);
    }

    /**
     * Show the form for editing the specified team.
     */
    public function edit(Team $team)
    {
        return view('pages.team.edit')->withTeam($team);
    }

    /**
     * Update the specified team in storage.
     */
    public function update(Request $request, Team $team)
    {
        $this->validate($request, [
            'name' => 'filled|max:191',
            'avatar' => 'filled|image|max:4000',
        ]);

        if ($request->hasFile('avatar')) {
            dispatch(new StoreAvatar($team, 'team_avatars', $request->file('avatar')));
        }

        $team->update($request->all());

        flash()->success("$team->name has been updated.");

        return redirect()->route('team.show', $team);
    }

    /**
     * Remove the specified team from storage.
     */
    public function destroy(Team $team)
    {
        $teamId = $team->id;
        $team->delete();

        User::where('current_team_id', $teamId)
            ->update([ 'current_team_id' => null ]);

        flash()->success("{$team->name} has been deleted.");

        return redirect()->route('team.index');
    }

    /**
     * Switch to the given team.
     */
    public function switch(Team $team)
    {
        Auth::user()->switchTeam($team);

        return redirect()->back();
    }
}
