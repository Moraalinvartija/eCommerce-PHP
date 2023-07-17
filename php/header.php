<?php
// Start the session
include 'php/function.php';
$message = sessionBase();
$total_quantity = 0;
foreach ($_SESSION['cart'] as $product) {
    $total_quantity += $product['quantity'];
}
if (isset($_POST['add_to_cart'])) {
    // Retrieve product information from the $_POST array
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $quantity = $_POST['quantity'];

    // Process the form submission
    // ...

    // Display an alert message to the user
    echo '<script>document.getElementById("lisays-viesti").style.display = "block";</script>';
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>eCommerce</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
         <!-- Jquery-->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

        <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    </head>
    <body class="d-flex flex-column min-vh-100">

        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <h2>eCommerce</h2>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                       
                        <li class="nav-item"><a class="nav-link" href="allproducts.php">Browse Products</a></li>
                   
                    
                    
                        
                        </div>
                        </ul>
                    <?php displayCartAmount();
                    
                    ?>


                
            </div>
        </nav>
        <?php
                // echo message if product is added to the cart        
                echo $message;

                ?>
    <!-- End Banner Hero -->

        <!-- Header-->
       <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Lorem Ipsum</h1>
                    <p class="lead fw-normal text-white-50 mb-0">"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</p>
                </div>
            </div>
        </header>
        