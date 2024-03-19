<?php
session_start(); 
if (!isset($_SESSION['agency_id'])) {
    header("Location: login.php");
    exit; 
}

require('../config.php');

$errors = [];

if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];

    $sql = "SELECT * FROM vehical_table WHERE vehicle_id = '$vehicle_id' AND agency_id = '" . $_SESSION['agency_id'] . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Vehicle not found or unauthorized to edit.";
        exit;
    }
} else {
    echo "Vehicle ID is missing.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $v_model = $_POST['v_model'];
    $v_number = $_POST['v_number'];
    $v_seat = $_POST['v_seat'];
    $v_rent = $_POST['v_rent'];

    // Validate Vehicle Model
    if (empty($v_model)) {
        $errors[] = "Vehicle model is required.";
    }
    
    // Validate Vehicle Number
    if (empty($v_number)) {
        $errors[] = "Vehicle number is required.";
    }
    
    // Validate Seating Capacity
    if (empty($v_seat) || !is_numeric($v_seat)) {
        $errors[] = "Seating capacity must be a number.";
    }
    
    // Validate Rent Per Day
    if (empty($v_rent) || !is_numeric($v_rent)) {
        $errors[] = "Rent per day must be a number.";
    }

    // Handle image upload
    if ($_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if uploaded file is an image
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

        // Upload file if no errors
        if ($uploadOk) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Update image path in database
                $imagePath = $targetFile;
                $sql = "UPDATE vehical_table SET image_path = '$imagePath' WHERE vehicle_id = '$vehicle_id'";
                mysqli_query($conn, $sql);
            } else {
                $errors[] = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // If no errors, update vehicle details
    if (empty($errors)) {
        $sql = "UPDATE vehical_table SET v_model = '$v_model', v_number = '$v_number', v_seat = '$v_seat', v_rent = '$v_rent' WHERE vehicle_id = '$vehicle_id'";
        if (mysqli_query($conn, $sql)) {
            $success_message = "Vehicle details updated successfully.";
        } else {
            echo "Error updating vehicle details: " . mysqli_error($conn);
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger' role='alert'>$error</div>";
        }
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

        <form method="post" enctype="multipart/form-data">
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
            <div class="mb-3">
                <label for="image" class="form-label">Vehicle Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
