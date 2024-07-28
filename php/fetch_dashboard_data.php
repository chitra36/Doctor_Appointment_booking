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

$tables = ['doctors_data', 'appointments', 'patients','contact_messages'];
$dashboardData = [];

foreach ($tables as $table) {
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $dashboardData[$table] = $rows;
    } else {
        $dashboardData[$table] = [];
    }
}

echo json_encode($dashboardData);

$conn->close();
?>
