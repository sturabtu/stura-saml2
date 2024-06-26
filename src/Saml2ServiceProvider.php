<?php

namespace StuRaBtu\Saml2;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Saml2\Saml2ExtendSocialite;

class Saml2ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/saml2.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'saml2');
        $this->loadTranslationsFrom(__DIR__ . '/../lang/saml2.php', 'saml2');

        /** Register SAML2 Socialite Provider */
        Event::listen(SocialiteWasCalled::class, Saml2ExtendSocialite::class);
    }
}
