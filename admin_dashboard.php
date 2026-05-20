<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "flight_booking");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle flight operations (add, update, delete)
if (isset($_POST['add_flight'])) {
    $flight_no = $_POST['flight_no'];
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $price = $_POST['price'];

    $sql = "INSERT INTO flights (flight_no, departure, destination, price) VALUES ('$flight_no', '$departure', '$destination', '$price')";
    $conn->query($sql);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM flights WHERE id = $id";
    $conn->query($sql);
}

$flights = $conn->query("SELECT * FROM flights");
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Reset default styles */
        body, h2, h3, table, form {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Center content */
        body {
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 90%;
            max-width: 800px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            float: right;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        form {
            margin: 20px 0;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .add-btn {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .add-btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        .action-btn {
            padding: 6px 10px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
            font-size: 14px;
        }

        .edit-btn {
            background-color: #28a745;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        /* Responsive */
        @media (max-width: 600px) {
            input {
                font-size: 14px;
            }
            .add-btn {
                font-size: 14px;
            }
            th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <a href="logout.php" class="logout-btn">Logout</a>

        <h3>Add Flight</h3>
        <form method="POST">
            <input type="text" name="flight_no" placeholder="Flight No" required><br>
            <input type="text" name="departure" placeholder="Departure" required><br>
            <input type="text" name="destination" placeholder="Destination" required><br>
            <input type="text" name="price" placeholder="Price (Nrs)" required><br>
            <button type="submit" name="add_flight" class="add-btn">Add Flight</button>
        </form>

        <h3>Flight List</h3>
        <table>
            <tr>
                <th>Flight No</th>
                <th>Departure</th>
                <th>Destination</th>
                <th>Price (Nrs)</th>
                <th>Actions</th>
            </tr>
            <?php while ($flight = $flights->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($flight['flight_no']); ?></td>
        <td><?php echo htmlspecialchars($flight['departure']); ?></td>
        <td><?php echo htmlspecialchars($flight['destination']); ?></td>
        <td>Nrs <?php echo htmlspecialchars($flight['price']); ?></td>
        <td>
            <a href="edit_flight.php?id=<?php echo $flight['id']; ?>" class="action-btn edit-btn">Edit</a>
            <a href="?delete=<?php echo $flight['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
<?php endwhile; ?>

</body>
</html>
