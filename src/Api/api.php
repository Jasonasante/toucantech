<?php
$servername = "127.0.0.1";
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = "toucantech";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

$schools = [
    'School A',
    'School B',
    'School C',
    'School D',
    'School E'
];

foreach ($schools as $school) {
    $checkSchoolSql = "SELECT * FROM schools WHERE name = '$school'";

    $result = $conn->query($checkSchoolSql);

    if ($result->num_rows == 0) {
        // School with this name does not exist, insert it
        $insertSchoolSql = "INSERT INTO schools (name) VALUES ('$school')";

        if ($conn->query($insertSchoolSql) !== TRUE) {
            die("Error inserting record: " . $conn->error);
        }
    }
}



$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    school_id INT,
    FOREIGN KEY (school_id) REFERENCES schools(id)
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

$usersData = [
    ['John Doe', 'john@example.com', 1],
    ['Jane Doe', 'jane@example.com', 2],
    ['Bob Smith', 'bob@example.com', 3]
];

foreach ($usersData as $userData) {
    list($name, $email, $school_id) = $userData;

    $checkUserSql = "SELECT * FROM users WHERE name = '$name' AND email = '$email' AND school_id = $school_id";

    $result = $conn->query($checkUserSql);

    if ($result->num_rows == 0) {
        // User with this name, email, and school_id does not exist, insert it
        $insertUserSql = "INSERT INTO users (name, email, school_id) VALUES ('$name', '$email', $school_id)";

        if ($conn->query($insertUserSql) !== TRUE) {
            die("Error inserting sample users: " . $conn->error);
        }
    }
}

$conn->close();
?>
