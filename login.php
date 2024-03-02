<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $password = filter_var(trim($_POST["password"]), FILTER_SANITIZE_STRING);
    $user_type = $_POST["user_type"];

    if ($user_type == 'Agency') {
        // Query to check agency credentials
        $query = "SELECT * FROM registerd_agency WHERE a_email = ? AND a_pass = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $agency_id = $row['agency_id'];
            session_start();
            $_SESSION['agency_id'] = $agency_id;
            header("location:agency/dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid Username or Password');</script>";
        }
    } else {
        if ($email && $password && $user_type) {
            $query = "SELECT * FROM registered_customer WHERE c_email = ? AND c_pass = ? AND user_type = ?";
            $stmt = $conn->prepare($query);
            if ($stmt && $stmt->bind_param("sss", $email, $password, $user_type) && $stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                    $customer_id = $result->fetch_assoc()["customer_id"];
                    session_start();
                    $_SESSION['customer_id'] = $customer_id;
                    header("location:customer/available.php");
                    exit();
                }
            }
        }
        echo "<script>alert('Invalid Username or Password');</script>";
        exit();
    }
}

$conn->close(); // Close the database connection
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="car.png" type="image/jpeg"> <!-- Set the favicon to the image -->

    <title>Login Page</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- JavaScript (optional, for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <?php
    require_once("navbar.php");?>
    <div class="container" style=" display: flex;
            justify-content: center;
            align-items: center;
            height: 95vh; ">

        <div class="conatiner card shadow-lg" style="width: 400px; ">
        <h2 class="text-center mt-2">Login Page</h2>
            <form method="POST">
                <div class="p-4">

                    <div class="form-group  mb-3">
                        <label for="user_type " class="mb-3">Choose your account type:</label>
                        <select class="form-control" id="user_type" name="user_type">
                            <option value="Agency" selected>Agency</option>
                            <option value="Customer">Customer</option>
                        </select>
                    </div>
                    <div class="mb-3 ">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary ">Login</button>
                    </div>
                    <div class="mt-2">
                    <p>Not Registered? <a href="signup.php">Register</a> Now</p>
                    </div>
                </div>
            </form>
        </div>

    </div>
    </div>
    </div>
</body>

</html>