<?php
session_start();

$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "doctor_appointments"; // Replace with your MySQL database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Update password in the database
    $sql = "UPDATE users_login SET password='$password', reset_token=NULL WHERE reset_token='$token'";
    if ($conn->query($sql) === TRUE) {
        echo "Password updated successfully.";
    } else {
        echo "Password update failed.";
    }
}

$conn->close();
?>
