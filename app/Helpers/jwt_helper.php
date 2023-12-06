<?php

use App\Models\ModelAuthentication;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWT($authHeader)
{
    if (is_null($authHeader)) {
        throw new Exception("Token Authentication Failed!");
    }

    return explode(" ", $authHeader)[1];
}

function validateJWT($encodedToken)
{
    $key = getenv("JWT_SECRET_KEY");
    $decodedToken = JWT::decode($encodedToken, new Key($key, "HS256"));

    $auth = new ModelAuthentication();
    $auth->getEmail($decodedToken->email);
}

function createJWT($email)
{
    $timeRequest = time();
    $timeToken = getenv("JWT_TIME_TO_LIVE");
    $timeExpire = $timeRequest + $timeToken;

    $payload = [
        "email" => $email,
        "iat" => $timeRequest,
        "exp" => $timeExpire
    ];

    $key = getenv("JWT_SECRET_KEY");
    $jwt = JWT::encode($payload, $key, "HS256");

    return $jwt;
}
