<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
    exit;
}

// Include the database connection file
include("connection.php");

// Retrieve and display data from the database
$sql = "SELECT * FROM wakietalkie";
$result = $conn->query($sql);

$dataArray = array(); // Store the data in an array

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dataArray[] = $row;
        }
    }
} else {
    echo "Error retrieving data: " . $conn->error;
}

$conn->close();

// Connect to your MySQL database to fetch other data
$connection = new mysqli("localhost", "root", "admin", "walkieinventory");

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch data from the department table
$departmentQuery = "SELECT d_name FROM department";
$departmentResult = $connection->query($departmentQuery);

// Fetch data from the status table
$statusQuery = "SELECT s_name FROM statusdb";
$statusResult = $connection->query($statusQuery);

// Fetch data from the ownership table
$ownershipQuery = "SELECT o_type FROM ownershiptype";
$ownershipResult = $connection->query($ownershipQuery);

if (!$departmentResult || !$statusResult || !$ownershipResult) {
    echo "Error retrieving auxiliary data: " . $connection->error;
}

$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Walkie Talkie Inventory</title>
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
        .edit-button, .delete-button, .add-button {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            cursor: pointer;
            background-color: transparent;
        }
        .add-button { color: green; }
        .edit-button { color: blue; }
        .delete-button { color: red; }
        #n2DataTable_wrapper { max-width: 100%; }
        .green-highlight { color: green; font-weight: bold; }
        .red-highlight { color: red; font-weight: bold; }
        .small-label { font-size: 16px; }
    </style>
</head>
<body>
    <nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:40%;min-width:300px" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button">Close Sidebar</a>
        <a href="index.php" class="w3-bar-item w3-button">Main Page</a>
        <a href="managestatus.php" class="w3-bar-item w3-button">Manage Status</a>
        <a href="ownership.php" class="w3-bar-item w3-button">Manage Ownership Type</a>
        <a href="managedepartment.php" class="w3-bar-item w3-button">Manage Department</a> 
    </nav>

    <div class="w3-top">
        <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
            <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()"><img src="FJBlogo.png" alt="Logo Image" style="max-width: 60px; max-height: 60px;"></div>
            <div class="w3-center w3-padding-16">Walkie Talkie Inventory</div>
            <div class="w3-button w3-padding-16 w3-right" style="font-size: 70%;margin-top: -50px;">
                <?php
                if (isset($_SESSION['username'])) {
                    echo "<i class='fas fa-user'></i>  " . $_SESSION['username'];
                }
                ?>
            </div>
        </div>
    </div>

    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
        <div class="container">
            <div class="table-responsive" style="overflow-x:auto; width: 100%;">
                <table id="n2DataTable" class="table table-bordered table-hover dt-responsive">
                    <thead>
                        <tr>
                            <th>Radio ID</th>
                            <th>Serial No</th>
                            <th>Status</th>
                            <th>Model</th>
                            <th>Ownership Type</th>
                            <th>Ownership</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dataArray as $row) {
                            echo "<tr>";
                            echo "<td>" . $row["RadioID"] . "</td>";
                            echo "<td>" . $row["SerialNo"] . "</td>";
                            echo "<td>" . $row["Status"] . "</td>";
                            echo "<td>" . $row["Model"] . "</td>";
                            echo "<td>" . $row["OwnershipType"] . "</td>";
                            echo "<td>" . $row["Ownership"] . "</td>";
                            echo "<td>" . $row["Position"] . "</td>";
                            echo "<td>" . $row["Department"] . "</td>";
                            echo '<td>' . $row['Remark'] . '</td>';
                            echo "<td>";
                            echo "<div class='action-buttons'>";
                            echo "<a href='add_data.php' class='add-button'><i class='fas fa-plus-circle'></i></a>";
                            echo "<a href='edit_data.php?id=" . $row["id"] . "' class='edit-button'><i class='fas fa-pencil-alt'></i></a>";
                            echo "<a href='delete_data.php?id=" . $row["id"] . "' class='delete-button' onclick='return confirmDelete()'><i class='fas fa-trash-alt'></i></a>";
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

        $(document).ready(function () {
            table.draw();
        });

        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
        }

        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
        }

        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }
    </script>
</body>
</html>
