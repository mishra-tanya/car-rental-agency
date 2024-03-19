<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="car.png" type="image/jpeg"> <!-- Set the favicon to the image -->
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JavaScript (optional, for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Car Rental Agency</title> <!-- Title without image -->
    <style>
        body {
            background-image: url("car2.png");
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .ava {
            position: relative;
            text-align: center;
            margin-top: 50px;
        }

        .ava img {
            max-width: 100%;
            height: auto;
        }

        .btn-rent {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>
    <?php require("navbar.php"); ?>

    <div class="ava">
        <img src="car2.png" alt="Car Image">
        <a href="#available" class="btn btn-dark btn-rent">Available cars</a>
    </div>

    <h2 class="text-center my-3 text-white" id="available">Available Cars</h2>

    <div class="container  ">
        <div class="table-responsive">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <?php
                    require('config.php');
                    
                    $limit = 6;  
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;  
                    $start = ($page - 1) * $limit; 
                    
                    $sql = "SELECT v.*, a.*
                            FROM vehical_table v
                            INNER JOIN registerd_agency a ON v.agency_id = a.agency_id
                            LIMIT $start, $limit";
                    $result = mysqli_query($conn, $sql);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-md-4 mb-4 ">
                        <div class="card ">
                        <?php
                                if ($row['image_path'] != "") {
                                    echo "<img src='agency/" . $row['image_path'] . "' style='width: 100%; height: 200px;' alt='Vehicle Image'>";
                                } else {
                                    echo "<img src='car.png' style='width: 100%; height: 200px;' alt='Vehicle Image'>";
                                }
                                ?>
                            <div class="card-body ">
                               
                                <h5 class="card-title mt-2 text-center"><b><?php echo $row['v_model']; ?></b></h5>
                                <b class="text-secondary"><?php echo $row['a_name']?></b><br>
                                <span class="card-text"> <i class="fas fa-phone"></i> <?php echo $row['a_phone']; ?></span><br>
                        <span class="card-text"><i class="fas fa-envelope"></i> <?php echo $row['a_email']; ?></span>
                       
                                <div class="row">
                                    <div class="col-6">
                                        <i class="fas fa-car-side"></i> <?php echo $row['v_number']; ?><br>
                                    </div>
                                    <div class="col-6">
                                        <i class="fas fa-chair"></i> <?php echo $row['v_seat']; ?><br>
                                    </div>
                                </div>
                                <p style="font-size:25px"><b>&#x20B9; </b> <b><?php echo $row['v_rent']; ?></b></p>
                                <a href="login.php" class="btn btn-outline-dark rent-btn">Rent Car</a>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    } else {
                        echo "<div class='col-md-12'><p>No records found</p></div>";
                    }
                    mysqli_close($conn);
                    ?>
                </div>
            </div>

        </div>
    </div>

    <div class="container mt-4">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php
                require('config.php');
                $sql = "SELECT COUNT(*) AS total FROM vehical_table";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $total_pages = ceil($row["total"] / $limit);
                
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<li class='page-item'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
                }
                mysqli_close($conn);
                ?>
            </ul>
        </nav>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center ">
                    <p class="text-white">&copy; 2024 Car Rental Agency</p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
