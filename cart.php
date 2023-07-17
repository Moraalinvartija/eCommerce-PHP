<?php
include 'php/header.php';

//functionality if delete button is pressed
if(isset($_POST['delete'])) {
    $product_id = $_POST['product_id'];
    $quantity_to_delete = (int) $_POST['quantity_to_delete'];

    // Check if the product exists in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        $product = $_SESSION['cart'][$product_id];
        $product_quantity = $product['quantity'];

        // Remove the product from the cart or update the quantity
        if ($quantity_to_delete >= $product_quantity) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id]['quantity'] -= $quantity_to_delete;
        }
    }
    // Redirect to cart.php to refresh the cart icon
    header("Location: cart.php");
    exit();
}
    

// Initialize total price and quantity
$total_price = 0;
$total_quantity = 0;
?>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
    <div class="table-responsive">
        
        <table class="table align-middle ">
        
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col"></th>
                   
                  
                    <th scope="col">Remove</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['cart'] as $product_id => $product) {
                    $product_price = (float) str_replace(',', '', $product['price']);
                    $product_name = str_replace(',', '',$product['name']);
                    $product_quantity = $product['quantity'];
                    $product_total = $product_price * $product_quantity;
                    $total_price += $product_total;
                    $total_quantity += $product_quantity;
                    ?>
                    <tr>
                        <td><?php echo $product_name; ?></td>
                        <td><?php echo number_format($product_price, 2); ?></td>
                        <td><?php echo $product_quantity; ?></td>
                        <td><?php echo number_format($product_total, 2); ?></td>
                        
                            <form class="delete-form form-inline" id="delete-form-<?php echo $product_id; ?>" method="post" action="cart.php">
                            <td>
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                </td>
                                <td>
                                <input type="number" name="quantity_to_delete" value="1" min="1" style="max-width: 4.5rem" max="<?php echo $product_quantity; ?>">
                                <button type="submit" class="btn btn-danger " name="delete">Delete</button>
                                </td>
                            </form>
                        
                    </tr>
                <?php }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="table-success" scope="row">Total price</th>
                    <td class="table-success"></td>
                    <td class="table-success"></td>
                    <td class="table-success" style="font-weight: bold;"><?php echo number_format($total_price, 2); ?>€</td>
                    <td class="table-success"></td>
                    <td class="table-success"><a class="btn btn-primary btn-lg" href="checkout.php" role="button">Checkout</a></td>
                    <td class="table-success"></td>
                    
                    
                </tr>
            </tfoot>
        </table>
    </div>
    </div>
</section>

<?php
include 'php/footer.php';
?>
