<?php
$servername = "localhost";
$username = "root";
$password = "root";  // This is often the default password for MAMP
$dbname = "http5225-movies";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
