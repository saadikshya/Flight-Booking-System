<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "flight_booking");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure booking_id is set and valid
if (isset($_GET['booking_id']) && is_numeric($_GET['booking_id'])) {
    $booking_id = (int)$_GET['booking_id'];

    // Get the booking details from the database
    $sql = "SELECT * FROM bookings WHERE booking_id = $booking_id";
    $result = $conn->query($sql);

    // If a booking was found
    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
        $passenger_name = $booking['passenger_name'];
        $passenger_email = $booking['passenger_email'];
        $departure_city = $booking['departure_city'];
        $destination_city = $booking['destination_city'];
        $travel_date = $booking['travel_date'];
    } else {
        echo "No booking found with ID: $booking_id.";
        exit();
    }
} else {
    echo "Invalid or missing booking ID.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="confirmation.css"> <!-- Link to CSS file -->
</head>
<body>
    <section class="confirmation-container">
        <h2>Booking Successful!</h2>
        <p>Thank you for booking your flight with us. Here are the details of your booking:</p>

        <div class="booking-details">
            <p><strong>Name:</strong> <?php echo $passenger_name; ?></p>
            <p><strong>Email:</strong> <?php echo $passenger_email; ?></p>
            <p><strong>Departure City:</strong> <?php echo $departure_city; ?></p>
            <p><strong>Destination City:</strong> <?php echo $destination_city; ?></p>
            <p><strong>Travel Date:</strong> <?php echo $travel_date; ?></p>
        </div>

        <div class="actions">
            <a href="index.html" class="btn">Back to Dashboard</a> <!-- Link back to dashboard -->
        </div>
    </section>
</body>
</html>
