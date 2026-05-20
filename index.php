<?php
$conn = new mysqli("localhost", "root", "", "flight_booking");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$flights = $conn->query("SELECT * FROM flights");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Flight Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="logo-section">
            <img src="assets/logo.png" alt="Fly High Logo" class="logo">
        </div>
        <nav class="navbar">
            <a href="#" onclick="addHomeDetails()">Home</a>
            <a href="#"  onclick="window.location.href='book-flight.php'">Book Flight</button></a>
            <a href="#"  onclick="window.location.href='offer.php'">Offers</button></a>
            <a href="#"  onclick="window.location.href='Seat.php'">Seat</button></a>
            <a href="#"  onclick="window.location.href='destination.php'">Destination</button></a>
           
            
        </nav>
        <div class="login-section">
            <a href="login.php"><button>Login</button></a>
            <a href="menu.php"><button>Menu</button></a>
            
        </div>
    </header>

    <!-- Hero Section with Booking Form Below -->
    <section class="hero-container">
        <div class="hero">
            <h2 class="overlay-text">BOOK YOUR NEXT ADVENTURE WITH EASE</h2><br><br><br><br>
            <img src="assets/airplane1.jpg" alt="Airplane taking off" class="hero-image">
        </div>

       
        
        

    <!-- JavaScript -->
    <script src="script.js"></script>

    table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Available Flights</h2>
    
    <table>
        <tr>
            <th>Flight No</th>
            <th>Departure</th>
            <th>Destination</th>
            <th>Price (Nrs)</th>
        </tr>
        <?php while ($flight = $flights->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($flight['flight_no']); ?></td>
            <td><?= htmlspecialchars($flight['departure']); ?></td>
            <td><?= htmlspecialchars($flight['destination']); ?></td>
            <td>Nrs <?= htmlspecialchars($flight['price']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
