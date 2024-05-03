<?php

//database connection
include '../db_connection.php';

// Define variables and initialize with empty values
$name = $email = $password = $confirm_password = "";
$address = $contact = $dob = "";
$name_err = $email_err = $password_err = $confirm_password_err = "";
$address_err = $contact_err = $dob_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate address
    if (empty(trim($_POST["address"]))) {
        $address_err = "Please enter your address.";
    } else {
        $address = trim($_POST["address"]);
    }

    // Validate contact number
    if (empty(trim($_POST["contact"]))) {
        $contact_err = "Please enter your contact number.";
    } else {
        $contact = trim($_POST["contact"]);
    }

    // Validate date of birth
    if (empty(trim($_POST["dob"]))) {
        $dob_err = "Please enter your date of birth.";
    } else {
        $dob = trim($_POST["dob"]);
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($address_err) && empty($contact_err) && empty($dob_err)) {
        // Prepare an insert statement for the users table
        $sql_users = "INSERT INTO users (email, password) VALUES (?, ?)";

        if ($stmt_users = mysqli_prepare($conn, $sql_users)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt_users, "ss", $param_email, $param_password);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt_users)) {
                // Prepare an insert statement for the profiles table
                $sql_profiles = "INSERT INTO profiles (user_id, username, address, contact, dob) VALUES (?, ?, ?, ?, ?)";
                // Get the ID of the inserted user
                $user_id = mysqli_insert_id($conn);

                if ($stmt_profiles = mysqli_prepare($conn, $sql_profiles)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt_profiles, "issss", $param_user_id, $param_username, $param_address, $param_contact, $param_dob);

                    // Set parameters
                    $param_user_id = $user_id;
                    $param_username = $name;
                    $param_address = $address;
                    $param_contact = $contact;
                    $param_dob = $dob;

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt_profiles)) {
                        // Redirect to login page
                        header("location: ../User/login.php");
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    mysqli_stmt_close($stmt_profiles);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt_users);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
<div class="registration-container">
    <h2>User Registration</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <span><?php echo $name_err; ?></span>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <span><?php echo $email_err; ?></span>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" value="<?php echo $password; ?>">
            <span><?php echo $password_err; ?></span>
        </div>
        <div>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
            <span><?php echo $confirm_password_err; ?></span>
        </div>
        <div>
            <label>Address:</label>
            <input type="text" name="address" value="<?php echo $address; ?>">
            <span><?php echo $address_err; ?></span>
        </div>
        <div>
            <label>Contact Number:</label>
            <input type="text" name="contact" value="<?php echo $contact; ?>">
            <span><?php echo $contact_err; ?></span>
        </div>
        <div>
            <label>Date of Birth:</label>
            <input type="date" name="dob" value="<?php echo $dob; ?>">
            <span><?php echo $dob_err; ?></span>
        </div>
        <div>
            <input type="submit" value="Submit">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>
</body>
</html>

<style>

body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
  }

  .registration-container {
    width: 400px;
    margin: 0 auto;
    margin-top: 50px;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
  }

  .registration-container h2 {
    text-align: center;
    margin-bottom: 20px;
  }

  .registration-container input[type="text"],
  .registration-container input[type="email"],
  .registration-container input[type="password"],
  .registration-container input[type="tel"],
  .registration-container input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
  }

  .registration-container input[type="submit"] {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 3px;
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
  }

  .registration-container input[type="submit"]:hover {
    background-color: #45a049;
  }

  .login-link {
    text-align: center;
    margin-top: 15px;
  }

</style>
