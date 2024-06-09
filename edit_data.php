<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $radioID = $_GET["id"];

    // Fetch the existing data for the specified ID
    $select_stmt = $conn->prepare("SELECT * FROM wakietalkie WHERE id = ?");
    $select_stmt->bind_param("i", $radioID);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        die("Record not found.");
    }

    // Fetch data for status, ownership type, and department select options
    $statusQuery = "SELECT s_name FROM statusdb";
    $statusResult = $conn->query($statusQuery);

    $ownershipTypeQuery = "SELECT o_type FROM ownershiptype";
    $ownershipTypeResult = $conn->query($ownershipTypeQuery);

    $departmentQuery = "SELECT d_name FROM department";
    $departmentResult = $conn->query($departmentQuery);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $radioID = $_POST["radioID"];
    $serialNo = $_POST["serialNo"];
    $status = $_POST["status"];
    $model = $_POST["model"];
    $ownershipType = $_POST["ownershipType"];
    $ownership = $_POST["ownership"];
    $position = $_POST["position"];
    $department = $_POST["department"];
    $remarks = $_POST["remarks"];

    // Prepare the SQL update statement
    $update_stmt = $conn->prepare("UPDATE wakietalkie SET SerialNo = ?, Status = ?, Model = ?, OwnershipType = ?, Ownership = ?, Position = ?, Department = ?, Remark = ? WHERE id = ?");
    
    // Check if prepare() failed
    if ($update_stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind parameters
    $update_stmt->bind_param("ssssssssi", $serialNo, $status, $model, $ownershipType, $ownership, $position, $department, $remarks, $radioID);

    // Execute the statement
    if ($update_stmt->execute()) {
        header("Location: index.php"); // Redirect to the main page after a successful update
        exit;
    } else {
        // Handle update error
        echo "Error updating record: " . $update_stmt->error;
    }

    $update_stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Walkie Talkie</title>
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
        <form action="edit_data.php" method="post">
            <input type="hidden" name="radioID" value="<?php echo $row['id']; ?>">
            
            <div class="form-group">
                <label for="serialNo">Serial No:</label>
                <input type="text" name="serialNo" id="serialNo" value="<?php echo $row['SerialNo']; ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" class="select2" required>
                    <?php while ($statusRow = $statusResult->fetch_assoc()): ?>
                        <option value="<?php echo $statusRow['s_name']; ?>" <?php if ($statusRow['s_name'] == $row['Status']) echo 'selected'; ?>>
                            <?php echo $statusRow['s_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="model">Model:</label>
                <input type="text" name="model" id="model" value="<?php echo $row['Model']; ?>" required>
            </div>

            <div class="form-group">
                <label for="ownershipType">Ownership Type:</label>
                <select name="ownershipType" class="select2" required>
                    <?php while ($ownershipTypeRow = $ownershipTypeResult->fetch_assoc()): ?>
                        <option value="<?php echo $ownershipTypeRow['o_type']; ?>" <?php if ($ownershipTypeRow['o_type'] == $row['OwnershipType']) echo 'selected'; ?>>
                            <?php echo $ownershipTypeRow['o_type']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ownership">Ownership:</label>
                <input type="text" name="ownership" id="ownership" value="<?php echo $row['Ownership']; ?>" required>
            </div>

            <div class="form-group">
                <label for="position">Position:</label>
                <input type="text" name="position" id="position" value="<?php echo $row['Position']; ?>" required>
            </div>

            <div class="form-group">
                <label for="department">Department:</label>
                <select name="department" class="select2" required>
                    <?php while ($departmentRow = $departmentResult->fetch_assoc()): ?>
                        <option value="<?php echo $departmentRow['d_name']; ?>" <?php if ($departmentRow['d_name'] == $row['Department']) echo 'selected'; ?>>
                            <?php echo $departmentRow['d_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="remarks">Remarks:</label>
                <input type="text" name="remarks" id="remarks" value="<?php echo $row['Remark']; ?>">
            </div>

            <input type="submit" value="Update" name="update">
            <a href="index.php" class="back-button">Back</a>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'classic', 
            });
        });
    </script>
</body>
</html>
