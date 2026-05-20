<?php
include 'db_connect.php'; // Database connection

if (isset($_GET['flight_id'])) {
    $flight_id = $_GET['flight_id'];

    // Check if there are confirmed bookings for the flight
    $checkQuery = "SELECT * FROM bookings WHERE flight_id = ? AND booking_status = 'confirmed'";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $flight_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "This flight has confirmed bookings and cannot be deleted.";
    } else {
        // Proceed with deletion if no confirmed bookings exist
        $deleteQuery = "DELETE FROM flights WHERE flight_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $flight_id);
        if ($stmt->execute()) {
            echo "Flight deleted successfully.";
        } else {
            echo "Error deleting flight.";
        }
    }
}
?>
