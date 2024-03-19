<?php
session_start(); // Start the session
require_once("nav.php");
require_once("../config.php");

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $targetDirectory = "uploads/"; // Directory where images will be stored
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $errors[] = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        $errors[] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, array("jpg", "png", "jpeg", "gif"))) {
        $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $errors[] = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Image uploaded successfully, now insert its path into the database
            $imagePath = $targetFile;
        } else {
            $errors[] = "Sorry, there was an error uploading your file.";
        }
    }

    // Check for other form inputs and perform validation
    $v_model = $_POST['v_model'];
    $v_number = $_POST['v_number'];
    $v_seat = $_POST['v_seat'];
    $v_rent = $_POST['v_rent'];

    if (empty($v_model)) {
        $errors[] = "Vehicle model is required.";
    }

    if (empty($v_number)) {
        $errors[] = "Vehicle number is required.";
    }

    if (empty($v_seat) || !is_numeric($v_seat)) {
        $errors[] = "Seating capacity must be a number.";
    }

    if (empty($v_rent) || !is_numeric($v_rent)) {
        $errors[] = "Rent per day must be a number.";
    }

    if (empty($errors)) {
        // No errors, proceed with database insertion
        $agency_id = $_SESSION['agency_id'];

        $sql = "INSERT INTO vehical_table (agency_id, v_model, v_number, v_seat, v_rent, image_path) 
                VALUES ('$agency_id', '$v_model', '$v_number', $v_seat, $v_rent, '$imagePath')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            $vehicle_id = mysqli_insert_id($conn);
            $_SESSION['vehicle_id'] = $vehicle_id;

            echo "<div class='alert alert-success text-center' role='alert'>Vehicle added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger text-center' role='alert'>Error: " . mysqli_error($conn) . "</div>";
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger text-center' role='alert'>$error</div>";
        }
    }

    mysqli_close($conn);
}
?>


<style>

body{
    color:white;
}
    .card{
        background-image: url("../car2.png");
        background-size:cover;
        background-repeat: no-repeat;
        margin: 0;
        padding: 0;
        height: 100%;
    color:white;

    }

</style>
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
    <div class="container mt-3">

      <div class="m-3">
      <div class="container card shadow-lg">
            <h2 class="text-center mt-3 mb-3">Add Car Details</h2>

            <form method="POST"  enctype="multipart/form-data">
                <div class="p-4">
                    <div class="mb-3">
                        <label for="" class="form-label">Vehicle Model</label>
                        <input type="text" required class="form-control" id="" name="v_model">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Vehicle Number</label>
                        <input type="text" required class="form-control" id="" name="v_number">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Seating Capacity</label>
                        <input type="text" required class="form-control" id="" name="v_seat">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Rent Per Day</label>
                        <input type="text" required class="form-control" id="" name="v_rent">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Vehicle Image</label>
                        <input type="file" required class="form-control" id="image" name="image">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-secondary">Save</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</body>

</html>