<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
   
</head>
<body>
    <div class="content">
        <h1>Welcome to the ABC Pharmacy</h1>
    </div>
</body>
</html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<div class="sidebar">
  <i class='fas fa-user-circle' style='font-size:36px'></i>
  <a href="http://localhost:8080/PharmacySystem/userdashboard.php"><i class="fa fa-fw fa-home"></i> Home</a><br><br>
  <a href="http://localhost:8080/PharmacySystem/User/upload_prescription.php"><i class="fa fa-fw fa-wrench"></i> Upload Prescriptions</a><br><br>
  <a href="http://localhost:8080/PharmacySystem/userdashboard.php"><i class="fa fa-fw fa-user"></i>Medicines</a><br><br>
  <a href="http://localhost:8080/PharmacySystem/userdashboard.php"><i class="fa fa-fw fa-user"></i> About Us</a><br><br>
  <a href="http://localhost:8080/PharmacySystem/userdashboard.php"><i class="fa fa-fw fa-envelope"></i> Contact</a><br><br>
</div>

</body>

<form class="example" action="/PharmacySystem/userdashboard.php" style="margin:auto;max-width:200px">
  <input type="text" placeholder="Search.." name="">
  <button type="submit"><i class="fa fa-search"></i></button>
</form>

</html> 


<style>
        /*background image */
 body {
         margin: 0;
         padding: 0;
         font-family: Arial, sans-serif;
         background-image: url('images/img7.jpg'); 
         background-size: cover;
         background-position: center;
         height: 100vh; 
        }

        .content {
            text-align: center;
            padding: 200px;
            color: white;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
        }
        .welcome-message {
            margin-bottom: 20px;
        }
        

body {font-family: "Lato", sans-serif;}

.sidebar {
  height: 100%;
  width: 160px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 16px;
}

.sidebar a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 20px;
  color: #818181;
  display: block;
}

.sidebar a:hover {
  color: #f1f1f1;
}

.main {
  margin-left: 160px; 
  padding: 0px 10px;
}

@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}


/*search */

* {
  box-sizing: border-box;
  
}

form.example input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 15%;
  background: #f1f1f1;
  position: fixed;
  top: 5px;
  right: 20px;

}

form.example button {
  position: fixed;
  top: 5px;
  right: 5px;
  width: auto; 
  padding: 10px;
  background: #2196F3;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  cursor: pointer;
  
}


</style>