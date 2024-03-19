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
    <link rel="icon" href="../car.png" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Car Rental Agency</title>
    <style>
        /* Add custom styles here if needed */
        .table-container {
            overflow-x: auto;
        }
    </style>
</head>
<body>
<?php 
require("nav.php");
?>

<h2 class="text-center my-3">Booked Cars</h2>
<div class="m-4 table-container">
    <table class="table table-bordered text-center border-secondary table-striped table-hover">
        <thead class="text-white bg-dark">
            <tr>
                <th>S.No.</th>
                <th>Image</th>
                <th>Agency Name</th>
                <th>Agency Email</th>
                <th>Vehicle Model</th>
                <th>Vehicle Number</th>
                <th>Rent Per Day</th>
                <th>Seating Capacity</th>
                <th>Days for Rent</th>
                <th>Starting Date</th>
                <th>Booking Date & Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require('../config.php');
            
            $sql = "SELECT bc.*, vt.*, a.* FROM booked_cars bc
                    JOIN vehical_table vt ON bc.vehicle_id = vt.vehicle_id
                    JOIN registerd_agency a ON bc.agency_id = a.agency_id
                    WHERE bc.customer_id='$customer_id' ORDER BY booking_date DESC";
                    
            $result = mysqli_query($conn, $sql);

            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td><img src='../agency/" . $row['image_path'] . "' style='max-width: 100px; max-height: 100px;' alt='Vehicle Image'></td>";
                echo "<td>" . $row['a_name'].", ".  $row['a_add'].", ".$row['a_phone'] . "</td>";
                echo "<td>" . $row['a_email'] . "</td>";
                echo "<td>" . $row['v_model'] . "</td>";
                echo "<td>" . $row['v_number'] . "</td>";
                echo "<td>" . $row['v_rent'] . "</td>";
                echo "<td>" . $row['v_seat'] . "</td>";
                echo "<td>" . $row['daysforrent'] . "</td>";
                echo "<td>" . $row['startdate'] . "</td>";
                echo "<td>" . $row['booking_date'] . "</td>";
                echo "</tr>";
                $i++;
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>

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
