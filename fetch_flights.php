<?php
header("Content-Type: application/json"); // Set response type to JSON

$servername = "localhost";
$username = "root";  // Default for XAMPP
$password = "";  // Default password is empty
$dbname = "flight_booking";  // Make sure this matches your database name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Fetch flights from database
$sql = "SELECT id, flight_no, departure, destination, price FROM flights";
$result = $conn->query($sql);

$flights = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flights[] = $row;
    }
}

// Return JSON response
echo json_encode($flights);
$conn->close();
?>
