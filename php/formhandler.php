<?php
session_start();
$first_name = $last_name = $email = $address = $country = $state = $zip = "";
$pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = test_input($_POST["firstName"]);
    $last_name = test_input($_POST["lastName"]);
    $email = test_input($_POST["email"]);
    $address = test_input($_POST["address"]);
    $country = test_input($_POST["country"]);
    $state = test_input($_POST["state"]);
    $zip = test_input($_POST["zip"]);
    $time = date('d/m/Y');

    if (empty($first_name) || empty($last_name) || empty($email) || empty($address) || empty($country) || empty($state) || empty($zip)) {
        header("Location: ../checkout.php?checkout=empty");
        exit();
    } else {
        // Check if input characters are valid again with our own check instead of relying only on test_input function
        if (preg_match($pattern, $first_name) || preg_match($pattern, $last_name)) {
            header("Location: ../checkout.php?checkout=char");
            exit();
        } else {
            // Check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../checkout.php?checkout=email");
                exit();
            } else {
                include('db_connect.php');

                
                $stmt = $conn->prepare("INSERT INTO orders (order_first_name, order_last_name, order_email, order_address, order_country, order_state, order_zip, order_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $address, $country, $state, $zip, $time);

                // Execute the prepared statement
                if ($stmt->execute()) {
                    // Get the last inserted order ID
                    $order_id = $stmt->insert_id;
                    // Remove the trailing comma from product_id
$product_id = "";

// Insert order items into the order_items table
foreach ($_SESSION['cart'] as $product_id => $product) {
    $product_id = rtrim($product_id, ',');
    $product_name = $product['name'];
    $product_price = (float) str_replace(',', '', $product['price']);
    $product_quantity = $product['quantity'];
    $product_total = $product_price * $product_quantity;

    echo "Product ID: $product_id<br>";
    echo "Product Name: $product_name<br>";
    echo "Product Price: $product_price<br>";
    echo "Product Quantity: $product_quantity<br>";
    echo "Product Total: $product_total<br>";

    $stmt_items = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_price, product_quantity, product_total) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_items->bind_param("iissdd", $order_id, $product_id, $product_name, $product_price, $product_quantity, $product_total);

    $stmt_items->execute();

    if ($stmt_items->error) {
        echo "Error: " . $stmt_items->error;
    }

    $stmt_items->close();
}


// After the loop, you can redirect to the success page
header("Location: ../reroute.php?checkout=success&order_id=$order_id");
exit();

                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
            }
        }
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
