<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    $add_radioID = $_POST["add_radioID"];
    $add_serialNo = $_POST["add_serialNo"];
    $add_status = $_POST["add_status"];
    $add_model = $_POST["add_model"];
    $add_ownershipType = $_POST["add_ownershipType"];
    $add_ownership = $_POST["add_ownership"];
    $add_position = $_POST["add_position"];
    $add_department = $_POST["add_department"];
    $add_remarks = $_POST["add_remarks"];

    // Prepare the SQL statement
    $sql = "INSERT INTO wakietalkie (RadioID, SerialNo, Status, Model, OwnershipType, Ownership, Position, Department, Remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($sql);

    // Check if prepare() failed
    if ($insert_stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind parameters
    $insert_stmt->bind_param("sssssssss", $add_radioID, $add_serialNo, $add_status, $add_model, $add_ownershipType, $add_ownership, $add_position, $add_department, $add_remarks);

    // Execute the statement
    if ($insert_stmt->execute()) {
        header("Location: index.php"); // Redirect to the main page after a successful insert
        exit;
    } else {
        // Handle insert error
        echo "Error adding record: " . $insert_stmt->error;
    }

    $insert_stmt->close();
}

// Fetch data for status, ownership type, and department select options
$statusQuery = "SELECT s_name FROM statusdb";
$statusResult = $conn->query($statusQuery);

$ownershipTypeQuery = "SELECT o_type FROM ownershiptype";
$ownershipTypeResult = $conn->query($ownershipTypeQuery);

$departmentQuery = "SELECT d_name FROM department";
$departmentResult = $conn->query($departmentQuery);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Walkie Talkie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 40%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px #ccc;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="date"],
        select,
        input[type="text"] {
            width: calc(100% - 16px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .back-button {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #ffffff;
            background-color: #A9A9A9;
            padding: 10px 15px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
    <form action="" method="post">

    
            <div class="form-group">
                <label for="add_radioID">Radio ID :</label>
                <input type="text" name="add_radioID" id="add_radioID" required>
            </div>

            
            <div class="form-group">
                <label for="add_serialNo">Serial No:</label>
                <input type="text" name="add_serialNo" id="add_serialNo" required>
            </div>

            <div class="form-group">
                <label for="add_status">Status:</label>
                <select name="add_status" class="select2" required>
                    <?php while ($statusRow = $statusResult->fetch_assoc()): ?>
                        <option value="<?php echo $statusRow['s_name']; ?>">
                            <?php echo $statusRow['s_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="add_model">Model:</label>
                <input type="text" name="add_model" id="add_model" required>
            </div>

            <div class="form-group">
                <label for="add_ownershipType">Ownership Type:</label>
                <select name="add_ownershipType" class="select2" required>
                    <?php while ($ownershipTypeRow = $ownershipTypeResult->fetch_assoc()): ?>
                        <option value="<?php echo $ownershipTypeRow['o_type']; ?>">
                            <?php echo $ownershipTypeRow['o_type']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="add_ownership">Ownership:</label>
                <input type="text" name="add_ownership" id="add_ownership" required>
            </div>

            <div class="form-group">
                <label for="add_position">Position:</label>
                <input type="text" name="add_position" id="add_position" required>
            </div>

            <div class="form-group">
                <label for="add_department">Department:</label>
                <select name="add_department" class="select2" required>
                    <?php while ($departmentRow = $departmentResult->fetch_assoc()): ?>
                        <option value="<?php echo $departmentRow['d_name']; ?>">
                            <?php echo $departmentRow['d_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="add_remarks">Remarks:</label>
                <input type="text" name="add_remarks" id="add_remarks">
            </div>

            <input type="submit" value="Add" name="add">
            <a href="index.php" class="back-button">Back</a>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'classic', // Choose a theme that matches your styling
            });
        });
    </script>
</body>

</html>
