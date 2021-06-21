<?php

namespace RecipeApi;

use Psr\Http\Message\ServerRequestInterface;

class Authenticator
{
    public static function authenticateRequest(ServerRequestInterface $request)
    {
        $baseUrl = explode('?', $request->getUri())[0];
        
        if ($request->getHeader('Authorization')[0] !== md5($baseUrl)) {
            header('HTTP/1.1 403 Forbidden');
            die("Invalid Auth Token");
        }
    }
}
