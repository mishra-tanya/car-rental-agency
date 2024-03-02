<?php
    require("config.php");
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_type=$_POST['user_type'];
    if($user_type=='Agency'){
        if (empty($_POST["a_email"]) || empty($_POST["a_pass"]) || empty($user_type)) {
            echo "<script>alert('Please enter all required fields.'); window.location.assign('signup.php');</script>";
            exit;
        }
        if (!filter_var($_POST["a_email"], FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email');  window.location.assign('signup.php');</script>";
            exit;
        }
        $sql_max_agency_id = "SELECT MAX(agency_id) AS max_agency_id FROM registerd_agency";
        $result_max_agency_id = mysqli_query($conn, $sql_max_agency_id);
        $row_max_agency_id = mysqli_fetch_assoc($result_max_agency_id);
        $agency_id = $row_max_agency_id['max_agency_id'] + 1;

        $a_name=$_POST['a_name'];
        $a_add=$_POST['a_add'];
        $a_phone=$_POST['a_phone'];
        $a_email=$_POST['a_email'];
        $a_pass=$_POST['a_pass'];
        $sql="SELECT * FROM registerd_agency WHERE a_email='$a_email'";
        $row=mysqli_query($conn,$sql);
        if(mysqli_num_rows($row)>0){
            echo "<script>alert('Email already exists!');  window.location.assign('registration.php');</script>";
            die();
        }
        $sql = "INSERT INTO registerd_agency (agency_id,user_type, a_name, a_add, a_phone, a_email, a_pass) VALUES ($agency_id,'$user_type', '$a_name', '$a_add', '$a_phone', '$a_email', '$a_pass')";
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            echo "<script>alert('Registration successful!'); window.location.assign('login.php');</script>";
        } else {
            echo "<script>alert('Registration failed!'); window.location.assign('registration.php');</script>";
        }

    }

    else{
        if($user_type=='Customer'){
            if (empty($_POST["c_email"]) || empty($_POST["c_pass"]) || empty($user_type)) {
                echo "<script>alert('Please enter all required fields.'); window.location.assign('signup.php');</script>";
                exit;
            }
            if (!filter_var($_POST["c_email"], FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('Invalid email');  window.location.assign('signup.php');</script>";
                exit;
            }
            $sql_max_customer_id = "SELECT MAX(customer_id) AS max_customer_id FROM registered_customer";
            $result_max_customer_id = mysqli_query($conn, $sql_max_customer_id);
            $row_max_customer_id = mysqli_fetch_assoc($result_max_customer_id);
            $customer_id = $row_max_customer_id['max_customer_id'] + 1;
    
            $c_name=$_POST['c_name'];
            $c_phone=$_POST['c_phone'];
            $c_email=$_POST['c_email'];
            $c_pass=$_POST['c_pass'];
            $sql="SELECT * FROM registered_customer WHERE c_email='$c_email'";
            $row=mysqli_query($conn,$sql);
            if(mysqli_num_rows($row)>0){
                echo "<script>alert('Email already exists!');  window.location.assign('registration.php');</script>";
                die();
            }
            $sql = "INSERT INTO registered_customer (customer_id, user_type, c_name, c_phone, c_email, c_pass) VALUES ($customer_id, '$user_type', '$c_name', '$c_phone', '$c_email', '$c_pass')";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                echo "<script>alert('Registration successful!'); window.location.assign('login.php');</script>";
            } else {
                echo "<script>alert('Registration failed!'); window.location.assign('registration.php');</script>";
            }
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="car.png" type="image/jpeg"> <!-- Set the favicon to the image -->

    <title>SignUp</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require_once("navbar.php");?>
<div class="d-flex justify-content-center">
    <div class="container card shadow-lg m-4 ">
    <h2 class="text-center mt-2">Registeration Page</h2>

        <form action='' method='POST'>
            <div class="p-4">
                <div class="form-group mb-3">
                    <label for="user_type" class="mb-3">Choose your account type:</label>
                    <select class="form-control" id="user_type" name="user_type">
                        <option value="Agency" selected>Agency</option>
                        <option value="Customer">Customer</option>
                    </select>
                </div>

                <!-- Agency details -->
                <div id="agencyfield" class="agency-fields">
                    <label>Agency Name:</label>
                    <input type="text" required class="form-control" id="" name="a_name">

                    <label>Agency Address:</label>
                    <input type="text"required class="form-control" id="" name="a_add">

                    <label>Phone number:</label>
                    <input type="text"required class="form-control" id="" name="a_phone">

                    <label for="customer_email" class="form-label">Email address</label>
                    <input type="email" required class="form-control" name="a_email" id="customer_email" aria-describedby="emailHelp">
                    
                    <label for="customer_password" class="form-label">Password</label>
                    <input type="password"required class="form-control" name="a_pass" id="customer_password">

                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
                <div class="mt-2">
                    <p>Already Registered? <a href="login.php">Login</a> Now</p>
                    </div>
                </div>


    <!-- Customer details -->

    <div id="customerfield" class="customer-fields d-none">
        <label>Customer Name:</label>
        <input type="text"required class="form-control" name="c_name"id="customer_name">

        <label>Phone number:</label>
        <input type="text"required class="form-control" id="" name="c_phone">
        <label for="customer_email" class="form-label">Email address</label>
        <input type="email"  required class="form-control" id="customer_email" name="c_email"aria-describedby="emailHelp">
        <label for="customer_password" class="form-label">Password</label>
        <input type="password"required class="form-control" name="c_pass"id="customer_password">

    <div class="d-flex justify-content-center mt-3">
        <button type="submit" class="btn btn-primary">Register</button>
    </div>
    <div class="mt-2">
                    <p>Already Registered? <a href="login.php">Login</a> Now</p>
                    </div>
    </div>

    </div>
    </form>
    </div>
    </div>
    </div>
    </div>


    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#user_type').on('change', function() {
            var userType = $(this).val();
            if (userType === 'Agency') {
                $('.agency-fields').removeClass('d-none');
                $('.customer-fields').addClass('d-none');
            } else if (userType === 'Customer') {
                $('.customer-fields').removeClass('d-none');
                $('.agency-fields').addClass('d-none');
            }
        });
    });
    </script>
</body>

</html>