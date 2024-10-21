<?php
class AccessControl {
    private static $whitelist = ['88.201.77.70'];
    private static $blacklist = ['203.0.113.1'];

    public static function checkAccess() {
        $ip = $_SERVER['REMOTE_ADDR'];
        
        // Block access if the IP is in the blacklist
        if (in_array($ip, self::$blacklist)) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['message' => 'Access denied.']);
            exit();
        }

        // Only check whitelist, but don't block if IP is not in it
        if (in_array($ip, self::$whitelist)) {
            header('HTTP/1.1 200 OK');
            echo json_encode(['message' => 'Welcome, your IP is  whitelisted!']);
        }
    }
}
