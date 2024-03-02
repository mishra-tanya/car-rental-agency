<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['agency_id'])) {
    // Redirect to the login page or handle the case where the user is not logged in
    header("Location: login.php");
    exit; // Stop further execution
}

// Include the database connection file
require('../config.php');

// Check if the vehicle ID is provided in the URL
if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];

    // Fetch the vehicle details from the database
    $sql = "SELECT * FROM vehical_table WHERE vehicle_id = '$vehicle_id' AND agency_id = '" . $_SESSION['agency_id'] . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Handle the case where the vehicle ID is not found or unauthorized
        echo "Vehicle not found or unauthorized to edit.";
        exit;
    }
} else {
    // Handle the case where the vehicle ID is not provided in the URL
    echo "Vehicle ID is missing.";
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $v_model = $_POST['v_model'];
    $v_number = $_POST['v_number'];
    $v_seat = $_POST['v_seat'];
    $v_rent = $_POST['v_rent'];

    // Update the vehicle details in the database
    $sql = "UPDATE vehical_table SET v_model = '$v_model', v_number = '$v_number', v_seat = '$v_seat', v_rent = '$v_rent' WHERE vehicle_id = '$vehicle_id'";
    if (mysqli_query($conn, $sql)) {
        // Fetch the updated vehicle details from the database
        $sql = "SELECT * FROM vehical_table WHERE vehicle_id = '$vehicle_id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
        }
        $success_message = "Vehicle details updated successfully.";
    } else {
        echo "Error updating vehicle details: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Vehicle Details</h2>
        <?php if (isset($success_message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="v_model" class="form-label">Vehicle Model</label>
                <input type="text" class="form-control" id="v_model" name="v_model" value="<?php echo isset($row['v_model']) ? $row['v_model'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="v_number" class="form-label">Vehicle Number</label>
                <input type="text" class="form-control" id="v_number" name="v_number" value="<?php echo isset($row['v_number']) ? $row['v_number'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="v_seat" class="form-label">Seating Capacity</label>
                <input type="number" class="form-control" id="v_seat" name="v_seat" value="<?php echo isset($row['v_seat']) ? $row['v_seat'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="v_rent" class="form-label">Rent per day</label>
                <input type="number" class="form-control" id="v_rent" name="v_rent" value="<?php echo isset($row['v_rent']) ? $row['v_rent'] : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
