<?php

namespace MVC\Controllers;

// Enable CORS (Cross-Origin Resource Sharing)
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

use MVC\Controller;

class ApiController extends Controller {
    // Function to get information for all schools and members
    public function getAllInfo() {
        $conn=$this->openMySQL();

        // get schools information
        $sql = "SELECT * FROM schools";
        $result = $conn->query($sql);
        $schools;
        if ($result) {
            $schools = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            echo json_encode(['error' => $conn->error]);
            exit;
        }

        // get members information
        $sql = "SELECT * FROM members";
        $result = $conn->query($sql);
         $members;
        if ($result) {
            $members = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            echo json_encode(['error' => $conn->error]);
            exit;
        }
        
        // combine and send data
        echo json_encode(['schools' => $schools, 'members'=>$members]);
        $conn->close();
    }

    // Function to process requests based on the school parameter
    public function processRequest() {
        $conn=$this->openMySQL();
        $data = json_decode(file_get_contents('php://input'), true);
        $school = $data['school'];

        if ($school === 'all') {
            $sql = "SELECT * FROM members";
        } else {
            $sql = "SELECT * FROM members WHERE school_id = $school";
        }
    
        // execute query and return the result
        $result = $conn->query($sql);
        if ($result) {
            $members = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($members);
        } else {
            echo json_encode(['error' => $conn->error]);
        }
        $conn->close();
    }
}
    