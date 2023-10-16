<?php

namespace MVC\Controllers;
use MVC\Controller;
header('Access-Control-Allow-Origin: http://localhost:3000');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');

class ApiController extends Controller {
    private $conn;

    public function processRequest() {
        $servername = "127.0.0.1";
        $username = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');
        $dbname = "toucantech";
    
        $conn = new \mysqli($servername, $username, $password, $dbname);;
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $data = json_decode(file_get_contents('php://input'), true);
       if ($data['action'] === 'getSchools') {
            $sql = "SELECT * FROM schools";
            $result = $conn->query($sql);
        if ($result) {
            $schools = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($schools);
        } else {
            echo json_encode(['error' => $conn->error]);
        }
        } elseif ($data['action'] === 'getUsers') {
            $school = $data['school'];
            if ($school === 'all') {
                $sql = "SELECT * FROM users";
            } else {
                $sql = "SELECT * FROM users WHERE school_id = $school";
            }
        
            $result = $conn->query($sql);
        
            if ($result) {
                $users = $result->fetch_all(MYSQLI_ASSOC);
                echo json_encode($users);
            } else {
                echo json_encode(['error' => $conn->error]);
            }
        }
        $conn->close();
    }
}
    