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

$sql = "SELECT specialty, COUNT(*) AS count, AVG(rating) AS avg_rating, GROUP_CONCAT(availability SEPARATOR ', ') AS timings FROM doctors_data GROUP BY specialty";
$result = $conn->query($sql);

$doctorData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctorData[] = [
            'specialty' => $row['specialty'],
            'count' => $row['count'],
            'avg_rating' => floatval($row['avg_rating']), // Ensure avg_rating is a float
            'timings' => $row['timings']
        ];
    }
}

echo json_encode($doctorData);

$conn->close();
?>
