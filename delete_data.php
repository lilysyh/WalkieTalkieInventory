<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $radioID = $_GET["id"];

    // Prepare the SQL delete statement
    $delete_stmt = $conn->prepare("DELETE FROM wakietalkie WHERE id = ?");
    
    // Check if prepare() failed
    if ($delete_stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind parameters
    $delete_stmt->bind_param("i", $radioID);

    // Execute the statement
    if ($delete_stmt->execute()) {
        header("Location: index.php"); // Redirect to the main page after a successful delete
        exit;
    } else {
        // Handle delete error
        echo "Error deleting record: " . $delete_stmt->error;
    }

    $delete_stmt->close();
}

mysqli_close($conn);
?>
