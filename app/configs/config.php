<?php
class Config {
    public static function get($key) {
        $config = [
            'db_host' => 'localhost',
            'db_name' => 'movie',
            'db_user' => 'root',
            'db_pass' => ''
        ];
        return $config[$key] ?? null;
    }
}
?>