<?php

namespace MVC;

class Controller {
    protected function openMySQL() {
        $servername = "127.0.0.1";
        $username = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');
        $dbname = "toucantech";
    
        $conn = new \mysqli($servername, $username, $password, $dbname);;
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}
    