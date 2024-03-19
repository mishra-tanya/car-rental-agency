<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $password = filter_var(trim($_POST["password"]), FILTER_SANITIZE_STRING);
    $user_type = $_POST["user_type"];

    if ($user_type == 'Agency') {
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

$conn->close(); 
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
    <style>
        body {
            background-color: #f8f9fa;  
            font-family: Arial, sans-serif;  
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            width: 400px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;  
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;  
            font-weight: bold; 
            background-color: #007bff;  
            border-color: #007bff;  
        }

        .btn-primary:hover {
            background-color: #0056b3;  
            border-color: #0056b3;  
        }

        .mt-2 {
            text-align: center;
            color: #777;  
        }
    </style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- JavaScript (optional, for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</head>
<style>
    body{
        background-image: url("car2.png");
    background-size: cover;
    background-repeat: no-repeat;
    }
</style>
<body>
    <?php require_once("navbar.php"); ?>
    <div class="container">
        <div class="card shadow">
            <h2 style="font-family:Lucida Console, Courier, monospace;">Login</h2>
            <form method="POST">
                <div class="p-2">
                    <div class="form-group mb-4">
                        <label for="user_type">Account Type:</label>
                        <select class="form-control" id="user_type" name="user_type">
                            <option value="Agency" selected>Agency</option>
                            <option value="Customer">Customer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark">Login</button>
                    </div>
                    <div class="mt-4">
                        <p>Not Registered? <a href="signup.php" class="text-dark">Sign Up</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
