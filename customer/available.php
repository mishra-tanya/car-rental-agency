<?php
session_start();  

if(isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
} else {
    echo "Customer Id not found in session.";
}

if(isset($_POST['numDays']) && isset($_POST['vehicleId']) && isset($_POST['agencyId'])) {
    echo "";
}else {
    echo "";
}

?>
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
require('../config.php');

$sql = "SELECT v.*, a.* FROM vehical_table v
        INNER JOIN registerd_agency a ON v.agency_id = a.agency_id";

$result = mysqli_query($conn, $sql);

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
        <button class='btn btn-outline-primary rent-btn' data-bs-toggle='modal' data-bs-target='#rentModal' onclick='showVehicleData(this)' data-vehicle-id='" . $row['vehicle_id'] . "' data-agency-id='" . $row['agency_id'] . "'>Rent Car</button>
    </td>";
    echo "<input type='hidden' class='agencyId' value='" . $row['agency_id'] . "'>";
    echo "</tr>";
    $i++;
}

mysqli_close($conn);
?>

         
        </tbody>
    </table>

    <!-- Rent Modal -->
    <div class="modal fade" id="rentModal" tabindex="-1" aria-labelledby="rentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rentModalLabel">Rent Car</h5>
                </div>
                <div class="modal-body">
                    <form id="rentForm" method="POST" action="save_rent.php">
                        <div class="mb-3">
                        <div id="successMessage" class="alert alert-success mt-3 d-none" role="alert">
        Successfully rented the car.
    </div>
                            <label for="numDays" class="form-label">Number of days:</label>
                            <input type="number" class="form-control" id="numDays" name="numDays" required>
                        </div>
                        <!-- Hidden input fields for customer ID and vehicle ID -->
                     

                        <input type="hidden" id="customerId" name="customerId"
                            value="<?php echo  $customer_id; ?>">

                        <input type="hidden" id="vehicleId" name="vehicleId">

                        <input type="hidden" id="agencyId" name="agencyId">

                        <button type="submit" class="btn btn-primary">Rent</button>
                    </form>

                </div>
            </div>
        </div>
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

    <!-- JavaScript to handle form submission -->
    <script>
    // Add event listener to all rent buttons
    function showVehicleData(button) {
        const vehicleId = button.getAttribute('data-vehicle-id');
        const agencyId = button.getAttribute('data-agency-id');
        document.getElementById('vehicleId').value = vehicleId;
        document.getElementById('agencyId').value = agencyId;
    }

    // Handle form submission
    document.getElementById('rentForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const numDays = document.getElementById('numDays').value;
        const vehicleId = document.getElementById('vehicleId').value;
        const agencyId = document.getElementById('agencyId').value;
        const customerId = document.getElementById('customerId').value;

        console.log('Vehicle ID:', vehicleId);
        console.log('Number of days:', numDays);
        console.log('Agency ID:', agencyId);
        console.log('Customer ID:', customerId);
        document.getElementById('successMessage').classList.remove('d-none');

setTimeout(function() {
    window.location.href = 'available.php';
}, 3000);

      
    });
document.getElementById('rentForm').addEventListener('submit', function(event) {
    event.preventDefault();  

    const numDays = document.getElementById('numDays').value;
    const vehicleId = document.getElementById('vehicleId').value;
    const agencyId = document.getElementById('agencyId').value;
    const customerId = document.getElementById('customerId').value;

    const formData = new FormData();
    formData.append('numDays', numDays);
    formData.append('vehicleId', vehicleId);
    formData.append('agencyId', agencyId);
    formData.append('customerId', customerId);

    // Send the form data using fetch API
    fetch('save_rent.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        console.log(data);  
        var rentModal = new bootstrap.Modal(document.getElementById('rentModal'));
        rentModal.hide();
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
});


    
    </script>

</body>

</html>
