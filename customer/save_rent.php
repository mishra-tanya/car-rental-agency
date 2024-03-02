<?php
session_start();

// Check if the request is made using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $daysforrent = $_POST['numDays'];
    $vehicleId = $_POST['vehicleId'];
    $agencyId = $_POST['agencyId'];
    $customerId = $_POST['customerId'];

    // Perform any necessary validation on the form data

    // Here, you can insert the form data into your database table
    // For example:
    require('../config.php');

    // Prepare and execute the SQL query to insert data into the database
    $sql = "INSERT INTO booked_cars (customer_id, vehicle_id, agency_id, daysforrent) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $customerId, $vehicleId, $agencyId, $daysforrent);
    if ($stmt->execute()) {
        // Close the database connection
        $stmt->close();
        $conn->close();

        // Show alert after successful insertion using JavaScript
        echo "<script>alert('Rental information saved successfully.');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // If the request is not made using POST method, handle the error
    echo "Error: Method not allowed.";
}
?>
