<?php

return [
    /** IdP */
    'metadata' => env('SAML2_IDP_METADATA', 'https://form.stura-btu.de/auth/idp'),
    'entityid' => env('SAML2_IDP_ENTITYID', 'https://form.stura-btu.de/auth/idp'),

    /** SP */
    'sp_entityid' => env('APP_URL').'/auth/saml2',

    'sp_tech_contact_surname' => 'Kiekbusch',
    'sp_tech_contact_givenname' => 'Julius',
    'sp_tech_contact_email' => 'contact@julius-kiekbusch.de',
    'sp_org_lang' => 'de',
    'sp_org_name' => 'Studierendenrat der Brandenburgischen Technischen Universität Cottbus-Senftenberg',
    'sp_org_display_name' => 'StuRa der BTU Cottbus-Senftenberg',
    'sp_org_url' => 'https://www.stura-btu.de',

    /** Routes */
    'sp_acs' => env('APP_URL').'/auth/saml2/callback',

    /** Signing
     * openssl req -x509 -sha256 -nodes -days 365 -newkey rsa:4096 -keyout storage/app/keys/sp_saml.pem -out storage/app/keys/sp_saml.crt
     */
    'sp_sign_assertions' => true,

    // 'path/to/sp_saml.crt'
    'sp_certificate' => file_exists(storage_path('app/keys/sp_saml.crt'))
        ? file_get_contents(storage_path('app/keys/sp_saml.crt'))
        : null,

    // 'path/to/sp_saml.pem'
    'sp_private_key' => file_exists(storage_path('app/keys/sp_saml.pem'))
        ? file_get_contents(storage_path('app/keys/sp_saml.pem'))
        : null,

    'sp_private_key_passphrase' => env('SAML2_SP_PRIVATE_KEY_PASSPHRASE'),

];
