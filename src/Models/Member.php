<?php

namespace MVC\Models;

class Member {
    public $name;
    public $email;
    public $school;

    // Constructor to initialize member properties
    public function __construct($name, $email, $school) {
        $this->name = $name;
        $this->email = $email;
        $this->school = $school;
    }

    // Function to insert a member into the database
    public function insert($conn) {
        
        // check if fields are empty
        if (empty($this->name) || empty($this->email) || empty($this->school)) {
            echo json_encode(['error' => 'Name, email, and school are required.']);
            exit;
        }
        // check if email is already in use
        $checkMemberSql = "SELECT * FROM members WHERE email = '$this->email'";
        $result = $conn->query($checkMemberSql);
    
        if ($result->num_rows == 0) {
            $insertMemberSql = "INSERT INTO members (name, email, school_id) VALUES ('$this->name', '$this->email', $this->school)";
    
            if ($conn->query($insertMemberSql) !== TRUE) {
                $response = ['error' => 'Error Adding New Member'];
                echo json_encode($response);
                exit;
            }

            $response = ['success' => 'Member Added'];
            echo json_encode($response);
        }else{
            $response = ['error' => 'Email Already In Use'];
            echo json_encode($response);  
        }
    }

}
    