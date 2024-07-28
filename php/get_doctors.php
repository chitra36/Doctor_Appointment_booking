<?php
$servername = "localhost";
$username = "root"; // Update with your MySQL username
$password = ""; // Update with your MySQL password
$dbname = "doctor_appointments"; // Update with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name FROM doctors";
$result = $conn->query($sql);

$doctors = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
    }
}

echo json_encode($doctors);

$conn->close();
?>
