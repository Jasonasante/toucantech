<?php

namespace MVC\Controllers;

// Enable CORS (Cross-Origin Resource Sharing)
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

use MVC\Controller;
use MVC\Models\Member;

class FormController extends Controller {
// Function to process form submission
    public function processForm() {
        // check if  parameters are set
        if (isset($_POST['name'], $_POST['email'], $_POST['school'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $school = $_POST['school'];
    
            // check if any of the fields are empty
            if (empty($name) || empty($email) || empty($school)) {
                echo json_encode(['error' => 'All fields are required']);
                exit;
            }

            $conn=$this->openMySQL();

            // create a new Member and insert it into the database
            $member = new Member($name, $email, $school);
            $member->insert($conn);
            
            $conn->close();

        } else {
            echo json_encode(['error' => 'Missing POST parameters']);
        }
    }
    
}
    