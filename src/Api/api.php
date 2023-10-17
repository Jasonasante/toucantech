<?php
// Create MySQL Schema with sample schools and members
$servername = "127.0.0.1";
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = "toucantech";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// create schools tables
$sql = "CREATE TABLE IF NOT EXISTS schools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

$schools = [
    'School A',
    'School B',
    'School C',
    'School D',
    'School E'
];

// Loop through the schools and add them to the database whilst preventing duplicate entries
foreach ($schools as $school) {
    $checkSchoolSql = "SELECT * FROM schools WHERE name = '$school'";

    $result = $conn->query($checkSchoolSql);

    if ($result->num_rows == 0) {
        $insertSchoolSql = "INSERT INTO schools (name) VALUES ('$school')";

        if ($conn->query($insertSchoolSql) !== TRUE) {
            die("Error inserting record: " . $conn->error);
        }
    }
}


// Create members tables
$sql = "CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    school_id INT,
    FOREIGN KEY (school_id) REFERENCES schools(id)
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

$membersData = [
    ['John Doe', 'john@example.com', 1],
    ['Jane Doe', 'jane@example.com', 2],
    ['Bob Smith', 'bob@example.com', 3]
];

// Loop through the members and add them to the database whilst preventing duplicate entries
foreach ($membersData as $memberData) {
    list($name, $email, $school_id) = $memberData;
    $checkMemberSql = "SELECT * FROM members WHERE name = '$name' AND email = '$email' AND school_id = $school_id";
    $result = $conn->query($checkMemberSql);

    if ($result->num_rows == 0) {
        $insertMemberSql = "INSERT INTO members (name, email, school_id) VALUES ('$name', '$email', $school_id)";

        if ($conn->query($insertMemberSql) !== TRUE) {
            die("Error inserting sample members: " . $conn->error);
        }
    }
}

$conn->close();

