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
    $patient_name = $conn->real_escape_string(trim($_POST['patient_name']));
    $patient_email = $conn->real_escape_string(trim($_POST['patient_email']));
    $appointment_date = $conn->real_escape_string(trim($_POST['appointment_date']));
    $reason = $conn->real_escape_string(trim($_POST['reason']));

    // Server-side validation for doctor selection
    if ($doctor_id == 0) {
        echo "Error: Please select a doctor.";
        exit;
    }

    // Additional validation can be added here (e.g., email format, date format, etc.)

    $stmt = $conn->prepare("INSERT INTO appointments (doctor_id, patient_name, patient_email, appointment_date, reason) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $doctor_id, $patient_name, $patient_email, $appointment_date, $reason);

    if ($stmt->execute()) {
        // Send notification email
        $to = "bishtc933@.com";
        $subject = "New Appointment Booked";
        $message = "A new appointment has been booked.\n\n"
                 . "Patient Name: $patient_name\n"
                 . "Patient Email: $patient_email\n"
                 . "Appointment Date: $appointment_date\n"
                 . "Reason: $reason\n";
        $headers = "From: noreply@example.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "Appointment booked successfully and email sent!";
        } else {
            echo "Appointment booked successfully, but email could not be sent.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
