<?php
session_start();  

if(isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
} else {
    echo "Customer Id not found in session.";
}?>
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

<h2 class="text-center my-3">Booked Cars</h2>
    <table class="table table-bordered text-center border-secondary table-striped table-hover">
        <thead>
        <tr>
                <th>S.No.</th>
                <th>Agency Name</th>
                <th>Agency Email</th>
                <th>Vehical Model</th>
                <th>Vehical Number</th>
                <th>Rent Per Day</th>
                <th>Seating Capacity</th>
                <th>Days for Rent</th>
                <th>Booking Date & Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require('../config.php');
            
            $sql = "SELECT bc.*, vt.*, a.* FROM booked_cars bc
                    JOIN vehical_table vt ON bc.vehicle_id = vt.vehicle_id
                    JOIN registerd_agency a ON bc.agency_id = a.agency_id
                    WHERE bc.customer_id='$customer_id'";
                    
            $result = mysqli_query($conn, $sql);

            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['a_name'].", ".  $row['a_add'].", ".$row['a_phone'] . "</td>";
                echo "<td>" . $row['a_email'] . "</td>";
                echo "<td>" . $row['v_model'] . "</td>";
                echo "<td>" . $row['v_number'] . "</td>";
                echo "<td>" . $row['v_seat'] . "</td>";
                echo "<td>" . $row['v_rent'] . "</td>";
                echo "<td>" . $row['daysforrent'] . "</td>";
                echo "<td>" . $row['booking_date'] . "</td>";
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
    </footer>
    
</body>

</html>