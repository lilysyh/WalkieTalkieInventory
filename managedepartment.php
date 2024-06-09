
<?php
session_start(); 

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

// Include the database connection file
include("connection.php");


?>

<?php

// Connect to your MySQL database
$connection = new mysqli("localhost", "root", "admin", "walkieinventory");

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch data from the department table
$departmentQuery = "SELECT d_name FROM department";
$departmentResult = $connection->query($departmentQuery);

// Create an array to store the tank data
$departmentData = array();

if ($departmentResult->num_rows > 0) {
    while ($row = $departmentResult->fetch_assoc()) {
        $departmentData[] = array(
            'd_name' => $row['d_name']
        );
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>List of Department</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">



    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <style>
        body, h1, h2, h3, h4, h5, h6 { font-family: "Karma", sans-serif; }
        .w3-bar-block .w3-bar-item { padding: 20px; }
        body { font-size: 140%; }
        h2 { text-align: center; padding: 20px 0; }
        table caption { padding: .5em 0; }
        table.dataTable th, table.dataTable td { white-space: nowrap; }
        .p { text-align: center; padding-top: 140px; font-size: 14px; }
        /* Add some custom styling for the buttons */
        .edit-button, .delete-button, .add-button {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            cursor: pointer;
            background-color: transparent; /* Remove background color */
        }

        /* Change add button color to blue */
    .add-button { color: green; /* Blue */ }
        /* Change edit button color to blue */
        .edit-button { color: blue; /* Blue */ }
        /* Change delete button color to red */
        .delete-button { color: red; /* Red */ }
        /* Increase table width */
        #n2DataTable_wrapper { max-width: 100%; }
        .green-highlight { color: green; font-weight: bold; }
        .red-highlight { color: red; font-weight: bold; }
        .small-label { font-size: 16px; /* Adjust the font size as needed */ }

        #n2DataTable td {
        vertical-align: middle;}
    </style>

</head>
<body>
    <!-- Sidebar (hidden by default) -->
<nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:40%;min-width:300px" id="mySidebar">
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button">Close Sidebar</a>
    <a href="index.php" class="w3-bar-item w3-button">Main Page</a>
    <a href="managestatus.php" class="w3-bar-item w3-button">Manage Status</a>
    <a href="ownership.php" class="w3-bar-item w3-button">Manage Ownership Type</a>
    <a href="managedepartment.php" class="w3-bar-item w3-button">Manage Department</a> 
</nav>

    <!-- Top menu -->
<div class="w3-top">
    <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
        <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()"><img src="FJBlogo.png" alt="Logo Image" style="max-width: 60px; max-height: 60px;"></div>
        <div class="w3-center w3-padding-16" >List of Department</div>
        <div class="w3-button w3-padding-16 w3-right" style="font-size: 70%;margin-top: -50px;">
            <?php
            // Check if the username is set in the session and display it
            if (isset($_SESSION['username'])) {
                echo "<i class='fas fa-user'></i>  " . $_SESSION['username'];
            }
            ?>
        </div>
    </div>
</div>

   

    <!-- !PAGE CONTENT! -->
    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
        

            <div class="table-responsive" style="overflow-x:auto; width: 100%;">
                <table id="n2DataTable" class="table table-bordered table-hover dt-responsive">
                    <thead>
                        <tr>
                            
                            <th>Department Type</th>
                        
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                // Loop through the tank data and display each row
                foreach ($departmentData as $row) {
                    echo "<tr>";
                    echo "<td style='vertical-align: middle;'>" . $row["d_name"] . "</td>";
                    echo "<td style='vertical-align: middle;'>"; 
                    
                    // Edit and delete buttons side by side
                    echo "<div class='action-buttons'>";
                    echo "<a href='add_department.php' class='add-button'><i class='fas fa-plus-circle'></i></a>";
                    echo "<a href='edit_department.php?id=" . $row["d_name"] . "' class='edit-button'><i class='fas fa-pencil-alt'></i></a>";
                  
                    echo "<a onclick='confirmDelete(\"" . $row["d_name"] . "\")' class='delete-button'><i class='fas fa-trash-alt'></i></a>";                 
                   
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
</tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
      const table = $('#n2DataTable').DataTable();

// Initialize DataTable
$(document).ready(function () {
    table.draw();
});

// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}

function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}

// Function to open the Delete Confirmation modal
function confirmDelete(id) {
    // Display a confirmation dialog
    if (confirm("Are you sure you want to delete the department record?")) {
        // Redirect to delete script with the record ID if the user confirms
        window.location.href = "delete_department.php?id=" + id;
    }
}

    
    
    </script>
</body>
</html>
