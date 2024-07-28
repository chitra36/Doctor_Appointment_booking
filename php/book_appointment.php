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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = intval($_POST['doctor_id']);
    $patient_name = $conn->real_escape_string($_POST['patient_name']);
    $patient_email = $conn->real_escape_string($_POST['patient_email']);
    $appointment_date = $conn->real_escape_string($_POST['appointment_date']);
    $reason = $conn->real_escape_string($_POST['reason']);

    // Server-side validation for doctor selection
    if ($doctor_id == 0) {
        echo "Error: Please select a doctor.";
        exit;
    }

    $sql = "INSERT INTO appointments (doctor_id, patient_name, patient_email, appointment_date, reason) 
            VALUES ('$doctor_id', '$patient_name', '$patient_email', '$appointment_date', '$reason')";

    if ($conn->query($sql) === TRUE) {
        // Send notification email
        $to = "your_email@example.com";
        $subject = "New Appointment Booked";
        $message = "A new appointment has been booked.\n\n"
                 . "Patient Name: $patient_name\n"
                 . "Patient Email: $patient_email\n"
                 . "Appointment Date: $appointment_date\n"
                 . "Reason: $reason\n";
        $headers = "From: noreply@example.com";

        mail($to, $subject, $message, $headers);

        echo "Appointment booked successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
