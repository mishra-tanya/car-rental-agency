<?php
session_start();  

if(isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
} else {
    echo "Customer Id not found in session.";
    header("Location: ../login.php");
    exit;
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JavaScript (optional, for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Car Rental Agency</title> <!-- Title without image -->
</head>

<body>
    <?php 
    require("nav.php");
    ?>
<h2 class="text-center my-3"><b>Available Cars</b></h2>
<div class="container mt-4">
    <div class="row justify-content-center">
        <?php
        require('../config.php');

        $sql = "SELECT v.*, a.* FROM vehical_table v
                INNER JOIN registerd_agency a ON v.agency_id = a.agency_id";
 



        $result = mysqli_query($conn, $sql);

        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-md-4">
                <div class="card my-3 shadow">
                    <?php if ($row['image_path'] != "") { ?>
                        <img src="../agency/<?php echo $row['image_path']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Vehicle Image">
                    <?php } else { ?>
                        <img src="../car.png" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Vehicle Image">
                    <?php } ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['a_name']; ?></h5>
                        <p class="card-text"> <i class="fas fa-phone"></i> <?php echo $row['a_phone']; ?></p>
                        <p class="card-text"><i class="fas fa-envelope"></i> <?php echo $row['a_email']; ?></p>
                        <p class="card-text"> <i class="fas fa-car"></i>  <?php echo $row['v_model']; ?></p>
                        <div class="row">
                            <div class="col-6">
                            <p class="card-text"> <i class="fas fa-car-side"></i> <?php echo $row['v_number']; ?></p>
                            </div>
                            <div class="col-6">
                        <p class="card-text"> <i class="fas fa-chair"></i> <?php echo $row['v_seat']; ?></p>
                            </div>
                        </div>
                            <p class="card-text mt-2" style="font-size:20px"><b>&#x20B9; </b> <?php echo $row['v_rent']; ?></p>

                            <?php if ($row['rental_id']!=0) { ?>
                            <p class="text-danger">Already Rented</p>
                        <?php } else { ?>
                            <button class="btn btn-outline-dark rent-btn" data-bs-toggle="modal" data-bs-target="#rentModal" onclick="showVehicleData(this)" data-vehicle-id="<?php echo $row['vehicle_id']; ?>" data-agency-id="<?php echo $row['agency_id']; ?>">Rent Car</button>
                        <?php } ?>

                        <input type="hidden" class="agencyId" value="<?php echo $row['agency_id']; ?>">
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }

        mysqli_close($conn);
        ?>
    </div>
</div>


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
    </div><label for="numDays" class="form-label">Number of days:</label>
<select class="form-select" id="numDays" name="numDays" required>
    <option value="">Select number of days</option>
    <?php for ($i = 1; $i <= 10; $i++): ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
    <?php endfor; ?>
</select>
<label for="numDays" class="form-label">Starting Date:</label>
<input type="date" required name="start"id="startDate" class="form-control" min="<?php echo date('Y-m-d'); ?>" >

                        </div>
                        <!-- Hidden input fields for customer ID and vehicle ID -->
                     

                        <input type="hidden" id="customerId" name="customerId"
                            value="<?php echo  $customer_id; ?>">

                        <input type="hidden" id="vehicleId" name="vehicleId">

                        <input type="hidden" id="agencyId" name="agencyId">

                        <button type="submit" class="btn btn-primary" onclick="location.reload();">Rent</button>
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
        const startDate = document.getElementById('startDate').value;

        

        console.log('Vehicle ID:', vehicleId);
        console.log('Number of days:', numDays);
        console.log('Agency ID:', agencyId);
        console.log('Customer ID:', customerId);
        console.log('start ID:', startDate);

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
    const startDate = document.getElementById('startDate').value;


    const formData = new FormData();
    formData.append('numDays', numDays);
    formData.append('vehicleId', vehicleId);
    formData.append('agencyId', agencyId);
    formData.append('customerId', customerId);
    formData.append('startDate', startDate);


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
