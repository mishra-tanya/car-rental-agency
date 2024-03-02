<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $daysforrent = $_POST['numDays'];
    $vehicleId = $_POST['vehicleId'];
    $agencyId = $_POST['agencyId'];
    $customerId = $_POST['customerId'];
    require('../config.php');
    $sql = "INSERT INTO booked_cars (customer_id, vehicle_id, agency_id, daysforrent) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $customerId, $vehicleId, $agencyId, $daysforrent);
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();

        echo "<script>alert('Rental information saved successfully.');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error: Method not allowed.";
}
?>
