<?php
session_start(); // Start the session

// Check if the agency_id is set in the session
if(isset($_SESSION['agency_id'])) {
    $agency_id = $_SESSION['agency_id'];
} else {
    // Handle the case where the agency_id is not set in the session
    echo "Agency Id not found in session.";
    // You may redirect the user to the login page or handle it based on your application's logic
}

require('../config.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../car.png" type="image/jpeg"> <!-- Set the favicon to the image -->
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JavaScript (optional, for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Car Rental Agency</title> <!-- Title without image -->
</head>
<body>
    <?php 
    require("nav.php");
    ?>
<h2 class="text-center mt-3">Booked Cars</h2>
    <table class="table table-bordered mt-3 border border-secondary  text-center table-striped table-hover">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Customer Name</th>
                <th>Customer Phone</th>
                <th>Customer Email</th>
                <th>Days for Rent</th>
                <th>Booking Date & Time</th>
                <th>Vehical Model</th>
                <th>Vehical Number</th>
                <th>Seating Capacity</th>
                <th>Rent per day</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            $sql = "SELECT bc.*, v.*, c.* FROM booked_cars bc
                    JOIN vehical_table v ON bc.vehicle_id = v.vehicle_id
                    JOIN registered_customer c ON bc.customer_id = c.customer_id
                    WHERE bc.agency_id='$agency_id'";
                    
            $result = mysqli_query($conn, $sql);

            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['c_name'] . "</td>";
                echo "<td>" . $row['c_phone'] . "</td>";
                echo "<td>" . $row['c_email'] . "</td>";
                echo "<td>" . $row['daysforrent'] . "</td>";
                echo "<td>" . $row['booking_date'] . "</td>";
                echo "<td>" . $row['v_model'] . "</td>";
                echo "<td>" . $row['v_number'] . "</td>";
                echo "<td>" . $row['v_seat'] . "</td>";
                echo "<td>" . $row['v_rent'] . "</td>";
                echo "</tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>

    <footer>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>&copy; 2024 Car Rental Agency</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
