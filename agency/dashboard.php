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
<h2 class="text-center mb-3 mb-3">Agency Cars</h2>
    <table class="table table-bordered border-secondary text-center border-black table-striped table-hover">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Vehical Model</th>
                <th>Vehical Number</th>
                <th>Seating Capacity</th>
                <th>Rent per day</th>
                <th>Edit Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            session_start(); // Start the session

            require('../config.php');
            
            // Check if the user is logged in
            if (!isset($_SESSION['agency_id'])) {
                // Redirect to the login page or handle the case where the user is not logged in
                header("Location: login.php");
                exit; // Stop further execution
            }
            
            require('../config.php');
    $agency_id = $_SESSION['agency_id']; 
            $sql = "SELECT * FROM vehical_table WHERE agency_id='$agency_id'";
    $result = mysqli_query($conn, $sql);

   

    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['v_model'] . "</td>";
        echo "<td>" . $row['v_number'] . "</td>";
        echo "<td>" . $row['v_seat'] . "</td>";
        echo "<td>" . $row['v_rent'] . "</td>";
        echo "<td><a href='edit_vehicle.php?id=" . $row['vehicle_id'] . "' class='btn btn-outline-primary'>Edit</a></td>";
       
        echo "</tr>";
        $i++;
    }
    if(mysqli_num_rows($result)==0){
        echo "<div class='alert alert-warning text-center' role='alert'>No Available cars</div>";
    }
    echo "</table>";

    $conn->close();
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