<?php
ini_set("SMTP", "localhost:8080");
ini_set("smtp_port", "8080");

// database connection
include '../db_connection.php';

// Initialize variables
$uploaded_files = [];

// Retrieve prescription ID from URL
$prescription_id = $_GET['prescription_id'] ?? '';

// Fetch prescription data from the database
$sql = "SELECT * FROM prescriptions WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $prescription_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if prescription data was found
if ($row = mysqli_fetch_assoc($result)) {
    // Retrieve uploaded image filenames
    $uploaded_files = explode(",", $row["uploaded_files"]);
} else {
    echo "Prescription not found.";
}

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prepare Quotation</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Prescription Images</h2>
    <div>
        <?php
        echo '<div class="image-container">';
        foreach ($uploaded_files as $file) {
            echo "<img src='../images/" . $file . "' width='100' height='100'>";
        }
        echo '</div>';
        echo "<br>";
        ?>
    </div>

    <br>
    <h2>Prepare Quotation</h2>
    <table id="quotation_table">
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table rows will be dynamically added here -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td id="total_amount">0.00</td>
            </tr>
        </tfoot>
    </table>
    <br>
    <h3>Add Drug to Quotation</h3>
    <label for="drug_name">Drug Name:</label>
    <input type="text" id="drug_name">
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" min="1">
    <label for="amount">Amount:</label>
    <input type="text" id="amount">
    <button onclick="addDrug()">Add</button>
    <br><br>

    <script>
        function addDrug() {
            var drugName = document.getElementById("drug_name").value;
            var quantity = document.getElementById("quantity").value;
            var amount = document.getElementById("amount").value;

            if (drugName && quantity && amount) {
                var table = document.getElementById("quotation_table").getElementsByTagName('tbody')[0];
                var newRow = table.insertRow();
                var cell1 = newRow.insertCell(0);
                var cell2 = newRow.insertCell(1);
                var cell3 = newRow.insertCell(2);

                cell1.innerHTML = drugName;
                cell2.innerHTML = quantity;
                cell3.innerHTML = amount;

                updateTotal(parseFloat(amount));
            } else {
                alert("Please fill in all fields.");
            }
        }

        function updateTotal(amount) {
            var totalElement = document.getElementById("total_amount");
            var currentTotal = parseFloat(totalElement.textContent);
            var newTotal = currentTotal + amount;
            totalElement.textContent = newTotal.toFixed(2);
        }

        function sendQuotation() {
            // Collect quotation data
            var quotationData = "";
            var tableRows = document.querySelectorAll("#quotation_table tbody tr");
            tableRows.forEach(function (row) {
                var cells = row.getElementsByTagName("td");
                var drugName = cells[0].innerText;
                var quantity = cells[1].innerText;
                var amount = cells[2].innerText;
                quotationData += drugName + ": " + quantity + " (" + amount + ")\n";
            });

            // Prompt for email and send
            var userEmail = prompt("Please enter your email address:");
            if (userEmail) {
                var subject = "Quotation Details";
                var body = "Here is the quotation details:\n\n" + quotationData + "\nTotal Amount: " + document.getElementById("total_amount").textContent + "\n\nTo accept this quotation, click the button below:\n\n<button onclick=\"acceptQuotation('" + userEmail + "')\">Accept</button>\n\nTo reject, simply ignore this email or reply with the reason for rejection.";
                var mailtoLink = "mailto:" + userEmail + "?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);
                window.location.href = mailtoLink;
            }
        }

        function acceptQuotation(userEmail) {
            // Update status in the database
            alert("Quotation accepted. Thank you!");
        }
    </script>

    <button onclick="sendQuotation()">Send Quotation</button>
</body>
</html>

<style>
    .image-container img {
        margin-right: 10px;
    }
</style>
