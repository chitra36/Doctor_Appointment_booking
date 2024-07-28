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
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users_login WHERE reset_token='$token' AND token_expires_at >= NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $sql = "UPDATE users_login SET password='$new_password', reset_token=NULL, token_expires_at=NULL WHERE reset_token='$token'";
        if ($conn->query($sql) === TRUE) {
            echo "Password reset successfully!";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "Invalid or expired token.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="reset_password.php" method="POST">
        <label for="new_password">New Password:</label><br>
        <input type="password" id="new_password" name="new_password" required><br><br>
        
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>"><br><br>
        
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
