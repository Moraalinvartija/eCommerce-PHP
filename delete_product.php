<?php
session_start();

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Check if the product exists in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        $quantity_to_delete = isset($_POST['quantity_to_delete']) ? (int) $_POST['quantity_to_delete'] : 1;

        $product = $_SESSION['cart'][$product_id];
        $product_quantity = $product['quantity'];

        // Remove the product from the cart or update the quantity
        if ($quantity_to_delete >= $product_quantity) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id]['quantity'] -= $quantity_to_delete;
        }
    }
}
?>
