<?php
require_once __DIR__ . '/../../util/constant/StatusCode.php';
require_once __DIR__ . '/../../util/constant/ContentType.php';
require_once __DIR__ . '/../../util/constant/RequestMethod.php';
require_once __DIR__ . '/../../util/Map.php';
require_once __DIR__ . '/../../route/Result.php';
require_once __DIR__ . '/../../route/Route.php';
require_once __DIR__ . '/../../util/constant/Constants.php';
require_once __DIR__ . '/../../util/identifier.php';
require_once __DIR__ . '/../../util/Map.php';

class UserListRoute extends Route {
    public function __construct() {
        parent ::__construct("user/list", [RequestMethod::GET]);
    }

    public function handle($sess, $res) {
        $out = new Map();

        $st = $sess -> db -> query("SELECT * FROM user");

        $dbRes = map($st -> fetchAll());

        if ($dbRes -> length() == 0) {
            $res -> sendError("No users present", StatusCode::NOT_FOUND);
        }


        foreach ($dbRes -> raw() as $arr) {
            $map = map($arr);
            $map['avatar'] = Constants::AVATAR_URL_PREFIX() . "?id=" . $arr['id'];
            $m = UserModel::fromJSON($map);
            $out -> push($m -> toMap());
        }

        $res -> sendJSON($out, StatusCode::OK);
    }

    public function validateRequest($sess, $res) {
        return Ok();
    }
}