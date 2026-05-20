<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_booking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
}

// Get data from the form
$flight_no = $_POST['flight_no'];
$departure = $_POST['departure'];
$destination = $_POST['destination'];
$price = $_POST['price'];

// Insert query
$sql = "INSERT INTO flights (flight_no, departure, destination, price) VALUES ('$flight_no', '$departure', '$destination', '$price')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Flight added successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
}

$conn->close();
?>
