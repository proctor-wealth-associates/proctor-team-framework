<?php

Route::name('impersonate')
    ->get('impersonate/{id}', 'ImpersonationController@impersonate');
    
Route::name('stop-impersonating')
    ->get('stop-impersonating', 'ImpersonationController@stopImpersonating');
