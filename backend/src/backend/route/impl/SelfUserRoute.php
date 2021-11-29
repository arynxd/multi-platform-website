<?php

require_once __DIR__ . "/../Route.php";
require_once __DIR__ . "/../../util/Map.php";
require_once __DIR__ . "/../../util/constant/RequestMethod.php";
require_once __DIR__ . "/../../util/identifier.php";
require_once __DIR__ . '/../../route/Result.php';
require_once __DIR__ . '/../../middleware/impl/AuthenticationMiddleware.php';


class SelfUserRoute extends Route {
    public function __construct() {
        parent ::__construct("user/@me", [RequestMethod::GET]);
    }

    public function handle($sess, $res) {
        $selfUser = $sess -> cache -> user();

        if (!$selfUser) {
            throw new UnexpectedValueException("Self user was not set? The validation middleware must have failed..");
        }

        $selfUser = $selfUser -> toMap();

        // properly type numbers
        $selfUser['permissions'] = (int) $selfUser['permissions'];
        $selfUser['joinDate'] = (int) $selfUser['joinDate'];
        $selfUser['dob'] = (int) $selfUser['dob'];

        $res -> sendJSON($selfUser, StatusCode::OK);
    }

    public function validateRequest($sess, $res) {
        $sess -> applyMiddleware(new AuthenticationMiddleware());
        return Ok();
    }
}