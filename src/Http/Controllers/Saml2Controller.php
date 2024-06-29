<?php

namespace StuRaBtu\Saml2\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use LightSaml\Error\LightSamlException;
use StuRaBtu\Saml2\Driver\Saml2;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use App\Models\User;

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
    public function redirect(Request $request): RedirectResponse|SymfonyRedirectResponse
    {
        if (! App::isProduction()) {

            $user = User::where('email', 'test@example.com')->first();

            Auth::login($user, remember: false);
            $request->session()->regenerate();

            return Redirect::route('dashboard');
        }

        return Saml2::redirectToIdentityProvider();
    }

    /**
     * Obtain the user information from SAML2 and log the user in.
     */
    public function callback(Request $request): RedirectResponse|View
    {
        try {
            $user = Saml2::user();

            Auth::login($user, remember: false);
            $request->session()->regenerate();

            return Redirect::route('dashboard');
        } catch (LightSamlException) {
            return view('saml2::error');
        }
    }
}
