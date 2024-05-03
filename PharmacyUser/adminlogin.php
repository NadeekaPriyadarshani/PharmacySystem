<?php
session_start();

// database connection
include '../db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve input values from the form
    $email = $_POST['email'] ?? ''; 
    $password = $_POST['password'] ?? '';

    // Admin credentials
    $admin_email = 'abcpharmacy@gmail.com';
    $admin_password = 'abc123@';

    // Check if the provided credentials match the admin credentials
    if ($email === $admin_email && $password === $admin_password) {
        // Admin login successful and redirect to dashboard
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header('Location: ../dashboard.php');
        exit;
    } else {
        // login failed error message
        $error = 'Invalid email or password. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>

<div class="login-container">
<h2>Admin Login</h2>
<?php if (!empty($error)) : ?>
    <p style='color: red;'><?php echo $error; ?></p>
<?php endif; ?>
<form method="post">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>
</div>
</body>
</html>

<style>

body {
    font-family: Arial, sans-serif;
    background-image: url('../images/img7.jpg'); 
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

  body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

.login-container {
    width: 300px;
    margin: 0 auto;
    margin-top: 100px;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
}

.login-container h2 {
    text-align: center;
    margin-bottom: 20px;
}

.login-container input[type="text"],
.login-container input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
}

/* Adjust the width of the email input */
.login-container input[type="email"] {
    width: 100%; /* Change this value as needed */
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
}

.login-container input[type="submit"] {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 3px;
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
}

.login-container input[type="submit"]:hover {
    background-color: #45a049;
}

</style>
