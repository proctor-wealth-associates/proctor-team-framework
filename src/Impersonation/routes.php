<?php

Route::group(['namespace' => 'Elegon\Impersonation\Controllers'], function() {

    Route::name('elegon.impersonate')
        ->get('/elegon/impersonate/{id}', 'ImpersonationController@impersonate');
        
    Route::name('elegon.stop-impersonating')
        ->get('/elegon/stop-impersonating', 'ImpersonationController@stopImpersonating');

});