
// Team routes
Route::group([ 'namespace' => 'Teams' ], function() {
    Route::resource('team', 'TeamController');
    Route::name('team.switch')->get('team/switch/{team}', 'TeamController@switch');

    Route::name('team.invite')->post('team/{team}/invite', 'InviteController@store');
    Route::name('team.invite.resend')->get('team/invite/resend/{invite}', 'InviteController@resend');
    Route::name('team.invite.accept')->get('team/invite/accept/{token}', 'InviteController@accept');
    Route::name('team.invite.ignore')->get('team/invite/ignore', 'InviteController@ignore');
    Route::name('team.invite.cancel')->delete('team/invite/cancel/{invite}', 'InviteController@destroy');

    Route::name('team.members.destroy')->delete('team/{team}/members/{user}', 'TeamMemberController@destroy');
});
