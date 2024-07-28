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
    $email = $_POST['email'];

    // Generate a unique token
    $token = bin2hex(random_bytes(32));

    // Set token expiration time (e.g., 1 hour from now)
    $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour'));

    // Store token in the database
    $sql = "UPDATE users_login SET reset_token='$token', token_expires_at='$expires_at' WHERE email='$email'";
    if ($conn->query($sql) === TRUE) {
        // Send password reset link to user's email
        $reset_link = "http://yourdomain.com/reset_password.php?token=$token"; // Replace with your domain and reset password page

        // Load PHPMailer
        require 'PHPMailer-master/src/PHPMailer.php';
        require 'PHPMailer-master/src/SMTP.php';
        require 'PHPMailer-master/src/Exception.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        // SMTP configuration for SendGrid
        $mail->isSMTP();
        $mail->Host = 'smtp.sendgrid.net'; // Set SendGrid SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'apikey'; // Use 'apikey' as the username
        $mail->Password = '92ZNLP8GFAL93HZ1YNPSYV3Y'; // Replace with your SendGrid API key
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        $mail->setFrom('no-reply@yourdomain.com', 'Your Website'); // Replace with your sender email and name
        $mail->addAddress($email); // Add recipient

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Link';
        $mail->Body    = "Click the following link to reset your password: <a href='$reset_link'>$reset_link</a>";

        // Debugging output (optional)
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';

        if ($mail->send()) {
            echo "Password reset link sent to your email.";
        } else {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "Email not found.";
    }
}

$conn->close();
?>
