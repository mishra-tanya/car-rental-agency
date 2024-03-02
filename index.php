<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="car.png" type="image/jpeg"> <!-- Set the favicon to the image -->
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JavaScript (optional, for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Car Rental Agency</title> <!-- Title without image -->
</head>
<body>
    <?php 
    require("navbar.php");
    ?>
    <h2 class="text-center my-3">Available Cars</h2>

    <table class="table table-bordered text-center border-secondary table-striped table-hover">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Agency Name</th>
                <th>Agency Phone</th>
                <th>Agency Email</th>
                <th>Vehical Model</th>
                <th>Vehical Number</th>
                <th>Seating Capacity</th>
                <th>Rent per day</th>
                <th>Rent car</th>
            </tr>
        </thead>
        <tbody>
        <?php
require('config.php');

$sql = "SELECT v.*, a.* FROM vehical_table v
        INNER JOIN registerd_agency a ON v.agency_id = a.agency_id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['a_name'].", ".  $row['a_add']. "</td>";
        echo "<td>" . $row['a_phone'] . "</td>";
        echo "<td>" . $row['a_email'] . "</td>";
        echo "<td>" . $row['v_model'] . "</td>";
        echo "<td>" . $row['v_number'] . "</td>";
        echo "<td>" . $row['v_seat'] . "</td>";
        echo "<td>" . $row['v_rent'] . "</td>";
        echo "<td> 
            <button class='btn btn-primary disabled '>Rent Car</button><br>
            <a href='login.php' class='text-danger' style='font-size:12px ; text-decoration:none'>Login for rent</a>
        </td>";
        echo "</tr>";
        $i++;
    }
} else {
    echo "No records found";
}

mysqli_close($conn);
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