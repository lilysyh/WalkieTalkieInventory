<?php
// database.php - Adjust these values with your database configuration
$hostname = "localhost";
$username = "root";
$password = "admin";
$database = "walkieinventory";

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}