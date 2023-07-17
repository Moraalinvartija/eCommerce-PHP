<?php
include 'php/header.php';
session_destroy();

// Check if the checkout success parameter and order ID are present in the URL
if (isset($_GET['checkout']) && $_GET['checkout'] === 'success' && isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

        // Retrieve order details and ordered items from the database based on the order ID
        include 'php/db_connect.php';
        $sql = "SELECT orders.order_id, orders.order_first_name, orders.order_last_name, orders.order_email, orders.order_address, orders.order_country, orders.order_state, orders.order_zip, orders.order_time, order_items.product_id, order_items.product_name, order_items.product_quantity, order_items.product_total
        FROM orders
        INNER JOIN order_items ON orders.order_id = order_items.order_id
        WHERE orders.order_id = ?";

        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $order_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $resultCheck = mysqli_num_rows($result);
            
            if ($resultCheck > 0) {
                $row = mysqli_fetch_assoc($result);
                $first_name = $row['order_first_name'];
                $last_name = $row['order_last_name'];
                $email = $row['order_email'];
                $address = $row['order_address'];
                $country = $row['order_country'];
                $state = $row['order_state'];
                $zip = $row['order_zip'];
                $time = $row['order_time'];

        echo '
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-8 col-xl-6">
                    <div class="card border-top border-bottom border-3" style="border-color: rgba(33,37,41,1) !important;">
                        <div class="card-body p-5">
                            <p class="lead fw-bold mb-5" style="color: rgba(33,37,41,1);">Purchase Receipt</p>
                            <div class="row">
                                <div class="col mb-3">
                                    <p class="small text-muted mb-1">Date</p>
                                    <p>'.$time.'</p>
                                </div>
                                <div class="col mb-3">
                                    <p class="small text-muted mb-1">Order No.</p>
                                    <p>'.$order_id.'</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <p class="small text-muted mb-1">Name</p>
                                    <p>'.$first_name.'</p>
                                </div>
                                <div class="col mb-3">
                                    <p class="small text-muted mb-1">Last name</p>
                                    <p>'.$last_name.'</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-12">
                                    <p class="small text-muted mb-1">Address</p>
                                    <p>'.$address.' | '.$country.' | '.$state.' | '.$zip.'</p>
                                </div>
                            </div>
                            <div class="mx-n5 px-5 py-4" style="background-color: #f2f2f2;">';
        
        $total = 0;
        do {
            $product_name = $row['product_name'];
            $product_quantity = $row['product_quantity'];
            $product_total = $row['product_total'];
            $total += $product_total;
            
            echo '
            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <p>'.$product_name.' X '.$product_quantity.'</p>
                </div>
                <div class="col-md-4 col-lg-3">
                    <p>'.$product_total.' €</p>
                </div>
            </div>';
        } while ($row = mysqli_fetch_assoc($result));
        
        echo '
                            </div>
                            <div class="row my-4">
                                <blockquote class="blockquote text-center">
                                    <p class="lead fw-bold mb-1 pb-2" style="color: rgba(33,37,41,1);">Total price</p>
                                    <footer><p class="lead fw-bold mb-0" style="color: rgba(33,37,41,1);"><u>'.$total.'</u> €</p></footer>
                                </blockquote>
                                <a href="index.php" class="btn btn-dark btn-lg active" role="button" aria-pressed="true">Return to front page</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </section>';
    } else {
        // No order found with the given ID
        echo 'No order found with the given ID.';
    }
    } else {
        // No order found with the given ID
        echo 'No order found with the given ID.';
    }
} else {
    // Invalid access, redirect to an error page or appropriate location
    header("Location: ../error.php");
    exit();
}

include 'php/footer.php';

?>
