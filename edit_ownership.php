<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
    $edit_o_type = $_POST["edit_o_type"];

    // Update data in the database
    $update_stmt = $conn->prepare("UPDATE ownershiptype SET o_type = ? WHERE o_type = ?");
    $update_stmt->bind_param("ss", $edit_o_type, $_POST['original_o_type']); // Adjust the parameter types as needed

    if ($update_stmt->execute()) {
        header("Location: ownership.php"); // Redirect to the main page after a successful update
        exit;
    } else {
        // Handle update error
        echo "Error updating record.";
    }

    $update_stmt->close();
}

// Retrieve the tank data for editing
if (isset($_GET['id'])) {
    $edit_id = $_GET['id'];

    // Fetch the tank data based on the provided ID
    $fetch_stmt = $conn->prepare("SELECT o_type FROM ownershiptype WHERE o_type = ?");
    $fetch_stmt->bind_param("s", $edit_id);
    $fetch_stmt->execute();
    $result = $fetch_stmt->get_result();
    $row = $result->fetch_assoc();

    // Store the existing data in a variable
    $existing_o_type = $row['o_type'];

    $fetch_stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Ownership</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        input[type="date"], select, input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <!-- Include the original data as a hidden input field for reference during the update -->
            <input type="hidden" name="original_o_type" value="<?php echo $existing_o_type; ?>">
            
            
            <table>
                <tr>
                    <th>Ownership Type</th>
              
                <td><input type="text" name="edit_o_type" id="edit_o_type" value="<?php echo $existing_o_type; ?>"></td>
                <tr>
           
           <td colspan="2">
       <input type="submit" value="Save" name="edit">
       <a href="ownership.php" style="display: block; text-align: center; margin-top: 10px; text-decoration: none; color: #fff; background-color: #A9A9A9; padding: 10px 15px; border-radius: 4px;">Back</a>
   </td>
           </tr>
   </table>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'classic', // Choose a theme that matches your styling
            });
        });
    </script>
</body>
</html>
