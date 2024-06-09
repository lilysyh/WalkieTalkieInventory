<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $delete_id = $_GET['id'];

    // Delete data from the database
    $delete_stmt = $conn->prepare("DELETE FROM department WHERE d_name = ?");
    $delete_stmt->bind_param("s", $delete_id); // Adjust the parameter type if needed

    if ($delete_stmt->execute()) {
        // Deletion successful
        header("Location: managedepartment.php"); // Redirect to the tank listing page after successful deletion
        exit;
    } else {
        // Handle deletion error
        echo "Error deleting record.";
    }

    $delete_stmt->close();
}

mysqli_close($conn);
?>
