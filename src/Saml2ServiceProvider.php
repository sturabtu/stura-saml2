<?php

namespace StuRaBtu\Saml2;

use Illuminate\Support\ServiceProvider;

class Saml2ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/saml2.php');
        $this->mergeConfigFrom(__DIR__ . '/../config/saml2.php', 'saml2');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'saml2');
        $this->loadTranslationsFrom(__DIR__ . '/../lang/saml2.php', 'saml2');
    }
}
