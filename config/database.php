<?php
class Database {
    private static $host = "localhost";
    private static $username = "root";
    private static $password = "hh6o7x!&C5QRNsBH";
    private static $database = "webauth";

    public static function getConnection() {
        $conn = new mysqli(self::$host, self::$username, self::$password, self::$database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
}
?>
