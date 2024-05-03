<?php

//database connection
include '../db_connection.php';

// Initialize variables
$email = $password = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize inputs to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    // Prepare and execute SQL query to fetch user data from the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch user data
        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables and redirect to user dashboard
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            header("Location: ../userdashboard.php");
            exit;
        } else {
            
            $error = "Error: Incorrect password.";
        }
    } else {
       
        $error = "Error: User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>
<body>

<div class="login-container">
<h2>User Login</h2>
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
<p>Don't have an account? <a href="registration.php">Register here</a></p>
</div>
</body>
</html>

<style>
  body {
    font-family: Arial, sans-serif;
    background-image: url('../images/img10.jpg'); 
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
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

/*  width of the email input */
.login-container input[type="email"] {
    width: 100%;
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