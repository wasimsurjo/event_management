<?php
class AccessControl {
    private static $whitelist = ['192.168.1.100'];
    private static $blacklist = ['203.0.113.1'];

    public static function checkAccess() {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (in_array($ip, self::$blacklist)) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['message' => 'Access denied.']);
            exit();
        }

        if (!in_array($ip, self::$whitelist)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['message' => 'Not authorized.']);
            exit();
        }
    }
}
?>