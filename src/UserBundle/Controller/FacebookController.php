<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FacebookController extends Controller
{
    /**
     *
     */
    public function connectAction()
    {
        // will redirect to Facebook!
        return $this->get('oauth2.registry')
            ->getClient('facebook_main') // key used in config.yml
            ->redirect();
    }

    /**
     * After going to Facebook, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config.yml
     *
     */
    public function connectCheckAction(Request $request)
    {

    }
}