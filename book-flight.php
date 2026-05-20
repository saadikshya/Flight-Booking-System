<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking</title>
    <link rel="stylesheet" href="book-flight.css">
</head>
<body>
<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "flight_booking");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch unique departure cities
$departureCitiesResult = $conn->query("SELECT DISTINCT departure FROM flights");

// Fetch unique destination cities
$destinationCitiesResult = $conn->query("SELECT DISTINCT destination FROM flights");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];

    // Prepare the SQL query
    $sql = "INSERT INTO bookings (passenger_name, passenger_email, departure_city, destination_city, travel_date) 
            VALUES ('$name', '$email', '$departure', '$destination', '$date')";

    // Execute the query and check for success
    if ($conn->query($sql) === TRUE) {
        // Get the last inserted booking ID
        $booking_id = $conn->insert_id;

        // Redirect to the confirmation page with the booking_id
        header("Location: confirmation_page.php?booking_id=$booking_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
$today = date('Y-m-d');
?>

    <section class="booking-container">
        <h2>Book Your Flight</h2>
        
        <form action="book-flight.php" method="POST" class="booking-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <!-- Departure City Dropdown -->
            <label for="departure">Departure City:</label>
            <select id="departure" name="departure" required>
                <option value="">Select Departure City</option>
                <?php while ($row = $departureCitiesResult->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['departure']); ?>"><?php echo htmlspecialchars($row['departure']); ?></option>
                <?php endwhile; ?>
            </select>

            <!-- Destination City Dropdown -->
            <label for="destination">Destination City:</label>
            <select id="destination" name="destination" required>
                <option value="">Select Destination City</option>
                <?php while ($row = $destinationCitiesResult->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['destination']); ?>"><?php echo htmlspecialchars($row['destination']); ?></option>
                <?php endwhile; ?>
            </select>

            <label for="date">Travel Date:</label>
            <!-- Set the minimum date to today using PHP -->
            <input type="date" id="date" name="date" required min="<?php echo $today; ?>">

            <button type="submit">Book Flight</button>
        </form>
    </section>
</body>
</html>
