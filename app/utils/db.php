<?php
require_once __DIR__ . '/../configs/config.php';

class Database {
    private static $instance = null;

    private function __construct() {
    }

    public static function connect() {
        if (self::$instance === null) {
            
            $host = Config::get('db_host');
            $dbname = Config::get('db_name');
            $user = Config::get('db_user');
            $pass = Config::get('db_pass');

            try {
                self::$instance = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                    $user,
                    $pass
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>
