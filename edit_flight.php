<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "flight_booking");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate the flight ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Error: Invalid flight ID.");
}

$flight_id = $_GET['id'];

// Fetch flight details
$stmt = $conn->prepare("SELECT * FROM flights WHERE id = ?");
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $flight_id);
if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
}

$result = $stmt->get_result();
$flight = $result->fetch_assoc();
$stmt->close();

if (!$flight) {
    die("Error: Flight not found.");
}

// Handle the form submission
if (isset($_POST['update_flight'])) {
    $flight_no = $_POST['flight_no'];
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $price = $_POST['price'];

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE flights SET flight_no=?, departure=?, destination=?, price=? WHERE id=?");
    $stmt->bind_param("ssssi", $flight_no, $departure, $destination, $price, $flight_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Flight updated successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "Error updating flight: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Flight</title>
</head>
<body>
    <h2>Edit Flight</h2>
    <form method="POST">
        <input type="text" name="flight_no" value="<?= htmlspecialchars($flight['flight_no'] ?? '') ?>" required><br>
        <input type="text" name="departure" value="<?= htmlspecialchars($flight['departure'] ?? '') ?>" required><br>
        <input type="text" name="destination" value="<?= htmlspecialchars($flight['destination'] ?? '') ?>" required><br>
        <input type="text" name="price" value="<?= htmlspecialchars($flight['price'] ?? '') ?>" required><br>
        <button type="submit" name="update_flight">Update Flight</button>
    </form>
</body>
</html>
