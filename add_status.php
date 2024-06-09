<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    $add_s_name = $_POST["add_s_name"];

    // Insert data into the database
    $insert_stmt = $conn->prepare("INSERT INTO statusdb (s_name) VALUES (?)");
    $insert_stmt->bind_param("s", $add_s_name); // Only one parameter, so "s" is used

    if ($insert_stmt->execute()) {
        header("Location: managestatus.php"); // Redirect to the main page after a successful insert
        exit;
    } else {
        // Handle insert error
        echo "Error adding record.";
    }

    $insert_stmt->close();
}

mysqli_close($conn);
?>



<!DOCTYPE html>
<html>

<head>
    <title>Add Status</title>
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
                <label for="add_s_name">Status Name :</label>
                <input type="s_name" name="add_s_name" id="add_s_name">
            </div>
            
            <input type="submit" value="Add" name="add">
            <a href="managestatus.php" class="back-button">Back</a>
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

