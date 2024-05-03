<?php
//database connection
include '../db_connection.php';

// Initialize variables
$note = $delivery_address = $delivery_time = "";
$note_err = $delivery_address_err = $delivery_time_err = "";
$uploaded_files = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate note
    if (empty(trim($_POST["note"]))) {
        $note_err = "Please enter a note.";
    } else {
        $note = trim($_POST["note"]);
    }

    // Validate delivery address
    if (empty(trim($_POST["delivery_address"]))) {
        $delivery_address_err = "Please enter the delivery address.";
    } else {
        $delivery_address = trim($_POST["delivery_address"]);
    }

    // Validate delivery time
    if (empty(trim($_POST["delivery_time"]))) {
        $delivery_time_err = "Please select a delivery time.";
    } else {
        $delivery_time = trim($_POST["delivery_time"]);
    }

    // Check if files were uploaded
    if (!empty(array_filter($_FILES['prescription_files']['name']))) {
        $total_files = count($_FILES['prescription_files']['name']);

        // Check if the total number of files exceeds 5
        if ($total_files > 5) {
            $note_err = "Error: You can upload a maximum of 5 images.";
        } else {
            // Loop through each file
            for ($i = 0; $i < $total_files; $i++) {
                $file_name = $_FILES['prescription_files']['name'][$i];
                $file_tmp = $_FILES['prescription_files']['tmp_name'][$i];

                // Move uploaded file to uploads directory
                if (move_uploaded_file($file_tmp, "../images/" . $file_name)) {
                    $uploaded_files[] = $file_name;
                } else {
                    $note_err = "Error: Failed to move uploaded file.";
                }
            }
        }
    }

    // Check input errors before inserting into database
    if (empty($note_err) && empty($delivery_address_err) && empty($delivery_time_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO prescriptions (note, delivery_address, delivery_time, uploaded_files) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_note, $param_delivery_address, $param_delivery_time, $param_uploaded_files);

            // Set parameters
            $param_note = $note;
            $param_delivery_address = $delivery_address;
            $param_delivery_time = $delivery_time;
            $param_uploaded_files = implode(",", $uploaded_files);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Prescription uploaded successfully
                echo "Prescription uploaded successfully.";
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Prescription</title>
</head>
<body>
<div class="login-container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    
        <div>
            <label>Note:</label><br>
            <textarea name="note" rows="4" cols="50"><?php echo $note; ?></textarea>
            <span><?php echo $note_err; ?></span>
        </div><br>
        <div>
            <label>Delivery Address:</label><br>
            <input type="text" name="delivery_address" value="<?php echo $delivery_address; ?>">
            <span><?php echo $delivery_address_err; ?></span>
        </div><br>
        <div>
            <label>Delivery Time:</label><br>
            <select name="delivery_time">
                <option value="8:00 AM - 10:00 AM">8:00 AM - 10:00 AM</option>
                <option value="10:00 AM - 12:00 PM">10:00 AM - 12:00 PM</option>
                <option value="12:00 PM - 2:00 PM">12:00 PM - 2:00 PM</option>
                <option value="2:00 PM - 4:00 PM">2:00 PM - 4:00 PM</option>
                <option value="4:00 PM - 6:00 PM">4:00 PM - 6:00 PM</option>
            </select>
            <span><?php echo $delivery_time_err; ?></span>
        </div><br>
        <div>
            <label>Upload Prescription Images (Max 5):</label><br>
            <input type="file" name="prescription_files[]" multiple>
        </div><br>
        <div>
            <input type="submit" value="Upload Prescription"><br><br>
            <button onclick="goback()" class="back-button">Back</button>
        </div>
    </form>
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
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-container {
        width: 400px;
        padding: 50px;
        background-color: rgba(255, 255, 255, 0.5); 
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); 
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

    .back-button {
        background-color: lightseagreen;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .back-button:hover {
        background-color: lightseagreen;
    }







</style>
