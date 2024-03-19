<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $daysforrent = $_POST['numDays'];
    $start = $_POST['startDate']; // This should capture the start date from the form
    $vehicleId = $_POST['vehicleId'];
    $agencyId = $_POST['agencyId'];
    $customerId = $_POST['customerId'];
    require('../config.php');
    $sql0="INSERT INTO vehical_table(rental_id) VALUES(1) WHERE vehical_id=$vehicalId";
    $sql = "INSERT INTO booked_cars (customer_id, vehicle_id, agency_id, daysforrent, startdate) 
    VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiss", $customerId, $vehicleId, $agencyId, $daysforrent, $start);
if ($stmt->execute()) {
// Update vehical_table to mark the car as rented
$update_sql = "UPDATE vehical_table SET rental_id = ? WHERE vehicle_id = ?";
$update_stmt = $conn->prepare($update_sql);
$rental_id = $stmt->insert_id; // Assuming booked_cars has an auto-increment primary key
$update_stmt->bind_param("ii", $rental_id, $vehicleId);
if ($update_stmt->execute()) {
    $update_stmt->close();
    $stmt->close();
    $conn->close();
    echo "<script>alert('Rental information saved successfully.');</script>";
} else {
    echo "Error updating vehical_table: " . $conn->error;
}
} else {
echo "Error inserting into booked_cars: " . $conn->error;
}
}

?>
