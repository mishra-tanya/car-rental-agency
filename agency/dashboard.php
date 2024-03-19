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

<h2 class="text-center mb-3 mb-3"><strong>Agency Cars</strong></h2>
   <div class="m-3 table-responsive">
   <table class="table table-bordered border-secondary text-center border-black table-striped table-hover">
        <thead class="text-white bg-dark">
            <tr>
                <th>S.No.</th>
                <th>Image</th>
                <th>Vehical Model</th>
                <th>Vehical Number</th>
                <th>Seating Capacity</th>
                <th>Rent per day</th>
                <th>Edit Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            session_start();  

            require('../config.php');
            
            if (!isset($_SESSION['agency_id'])) {
                header("Location: ../login.php");
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
        echo "<td><img src='" . $row['image_path'] . "' style='max-width: 100px; max-height: 100px;' alt='Vehicle Image'></td>";
        echo "<td>" . $row['v_model'] . "</td>";
        echo "<td>" . $row['v_number'] . "</td>";
        echo "<td>" . $row['v_seat'] . "</td>";
        echo "<td>" . $row['v_rent'] . "</td>";
        echo "<td><a href='edit_vehicle.php?id=" . $row['vehicle_id'] . "' class='btn btn-outline-dark'>Edit</a></td>";
       
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