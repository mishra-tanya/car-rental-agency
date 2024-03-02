<?php
session_start(); // Start the session
require_once("nav.php");

require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $v_model = $_POST['v_model'];
    $v_number = $_POST['v_number'];
    $v_seat = $_POST['v_seat'];
    $v_rent = $_POST['v_rent'];
    
    // Retrieve agency_id from session
    $agency_id = $_SESSION['agency_id']; 
    
    $sql = "INSERT INTO vehical_table (agency_id, v_model, v_number, v_seat, v_rent) 
            VALUES ('$agency_id', '$v_model', '$v_number', $v_seat, $v_rent)";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        // Retrieve the last inserted ID
        $vehicle_id = mysqli_insert_id($conn);
        
        // Store the vehicle ID in a session variable
        $_SESSION['vehicle_id'] = $vehicle_id;
        
        echo "<div class='alert alert-success text-center' role='alert'>Vehicle added successfully.</div>";
    } else {
        echo "<div class='alert alert-danger text-center' role='alert'>Error: " . mysqli_error($conn) . "</div>";
    }
    
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../car.png" type="image/jpeg"> <!-- Set the favicon to the image -->

    <title>Add Vehicle</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JavaScript (optional, for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container" style="display: flex; justify-content: center; align-items: center; height: 110vh;">

        <div class="container card shadow-lg" style="width: 500px;">
        <h2 class="text-center mt-3 mb-3">Add Car Details</h2>

            <form method="POST">
                <div class="p-4">
                    <div class="mb-3">
                        <label for="" class="form-label">Vehicle Model</label>
                        <input type="text"required class="form-control" id="" name="v_model">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Vehicle Number</label>
                        <input type="text"required class="form-control" id="" name="v_number">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Seating Capacity</label>
                        <input type="text"required class="form-control" id="" name="v_seat">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Rent Per Day</label>
                        <input type="text"required class="form-control" id="" name="v_rent">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
