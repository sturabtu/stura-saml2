<?php

use Illuminate\Support\Facades\Route;
use StuRaBtu\Saml2\Http\Controllers\Saml2Controller;

Route::middleware('web')->group(function() {

    Route::name('auth.saml2.metadata')->get(
        '/auth/saml2',
        [Saml2Controller::class, 'metadata']
    );
    
    Route::middleware(['guest', 'throttle:auth'])->group(function () {
    
        Route::name('auth.saml2.redirect')->get(
            '/auth/saml2/redirect',
            [Saml2Controller::class, 'redirect']
        );
    
        Route::name('auth.saml2.callback')->match(
            ['get', 'post'],
            '/auth/saml2/callback',
            [Saml2Controller::class, 'callback']
        );
    
    });

    Route::redirect('/login', '/auth/saml2/redirect')->name('login');
});
