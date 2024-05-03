<?php
// database connection
include '../db_connection.php';

// Fetch prescription data from the database
$sql = "SELECT * FROM prescriptions";
$result = mysqli_query($conn, $sql);

// Check if there are any prescriptions
if (mysqli_num_rows($result) > 0) {
    // Output data each row
    while ($row = mysqli_fetch_assoc($result)) {
        // Display prescription ID 
        if (isset($row["id"])) {
            echo "Prescription ID: " . $row["id"] . "<br>";
        } else {
            echo "Prescription ID: N/A <br>";
        }

        // Display other prescription details
        echo "Note: " . $row["note"] . "<br>";
        echo "Delivery Address: " . $row["delivery_address"] . "<br>";
        echo "Delivery Time: " . $row["delivery_time"] . "<br>";

        // Display uploaded prescription files
        $uploaded_files = explode(",", $row["uploaded_files"]);
        echo "Uploaded Files:<br>";
        echo '<div class="image-container">';
        foreach ($uploaded_files as $file) {
            echo "<img src='../images/" . $file . "' width='100' height='100'><br>";
        }
        echo '</div>';
        
        echo "<br>";


        //link to prepare quotation
        echo '<div class="quotation-link">';
        echo '<a href="prepare_quotation.php?prescription_id=' . $row["id"] . '&images=' . implode(',', $uploaded_files) . '">Prepare Quotation</a>';
        echo '</div>';
        echo "<hr>";
    }
} else {
    echo "No prescriptions uploaded";
}

// Close connection
mysqli_close($conn);
?>

<style>
.image-container {
    display: flex;
}

.image-container img {
    margin-right: 10px; 
}

.quotation-link {
    border: 1px solid #c0392b; 
    background-color: palevioletred; 
    color: black; 
    padding: 6px 12px; 
    display: inline-block;
    text-decoration: none; 
    border-radius: 3px; 
    transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease; 
}

</style>