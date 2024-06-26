<?php

namespace StuRaBtu\Saml2\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use LightSaml\Error\LightSamlException;
use StuRaBtu\Saml2\Driver\Saml2;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class Saml2Controller
{
    /**
     * Return the SAML2 Server Provider metadata.
     */
    public function metadata(): Response
    {
        return Saml2::getServiceProviderMetadata();
    }

    /**
     * Redirect the user to the SAML2 authentication page.
     */
    public function redirect(): RedirectResponse|SymfonyRedirectResponse
    {
        return Saml2::redirectToIdentityProvider();
    }

    /**
     * Obtain the user information from SAML2 and log the user in.
     */
    public function callback(Request $request): RedirectResponse|View
    {
        try {
            $user = Saml2::user();

            Auth::login($user, remember: $user->permissions !== null && $user->permissions->isNotEmpty());
            $request->session()->regenerate();

            return Redirect::route('dashboard');
        } catch (LightSamlException) {
            return view('saml2::error');
        }
    }
}
