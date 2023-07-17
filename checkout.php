<?php
include 'php/header.php';
// Initialize total price and quantity
$total_price = 0;
$total_quantity = 0;


?>
<section class="py-5 bg-light">
<div class="container">
    <div class="py-5 text-center">
        
        <h2>Checkout form</h2>
        
    </div>
    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">3</span>
            </h4>
            <br>
            <ul class="list-group mb-3 sticky-top">
                
                <?php
                foreach ($_SESSION['cart'] as $product_id => $product) {
                    $product_price = (float) str_replace(',', '', $product['price']);
                    $product_name = str_replace(',', '',$product['name']);
                    $product_quantity = $product['quantity'];
                    $product_total = $product_price * $product_quantity;
                    $total_price += $product_total;
                    $total_quantity += $product_quantity;
                    ?>

                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0"><?php echo $product_name; ?></h6>
                        <small class="text-muted"><?php echo number_format($product_price, 2); ?>€ X <?php echo $product_quantity; ?></small><br>
                    
                    </div>
                    <span class="text-muted"><?php echo number_format($product_total, 2); ?>€</span>
                </li>
                    
                            
                <?php }
                ?>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Total</h6>
                        
                    </div>
                    <span class="text-bold" style="font-weight: bold;text-decoration: underline;"><?php echo number_format($total_price, 2); ?>€</span>
                </li>
            </ul>
            
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Billing address</h4>
            <form method ="post" action="php/formhandler.php" class="needs-validation" novalidate="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" id="firstName" name ="firstName" placeholder="" value="" required="">
                        <div class="invalid-feedback"> Valid first name is required. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input type="text" class="form-control" id="lastName" name ="lastName" placeholder="" value="" required="">
                        <div class="invalid-feedback"> Valid last name is required. </div>
                    </div>
                </div>
                <!--  Comment this section out for possible update for the website. For now, no registeration needed   -->
             <!--   <div class="mb-3">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input type="text" class="form-control" id="username" placeholder="Username" required="">
                        <div class="invalid-feedback" style="width: 100%;"> Your username is required. </div>
                    </div>
                </div> -->
                <div class="mb-3">
                    <label for="email">Email <span class="text-muted">(Optional)</span></label>
                    <input type="email" class="form-control" id="email" name ="email" placeholder="you@example.com">
                    <div class="invalid-feedback"> Please enter a valid email address for shipping updates. </div>
                </div>
                <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name ="address" placeholder="1234 Main St" required="">
                    <div class="invalid-feedback"> Please enter your shipping address. </div>
                </div>
                
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="country">Country</label>
                        <select class="custom-select d-block w-100" id="country" name ="country" required="">
                            <option value="">Choose...</option>
                            <option>Denmark</option>
                            <option>Finland</option>
                            <option>Norway</option>
                            <option>Sweden</option>
                        </select>
                        <div class="invalid-feedback"> Please select a valid country. </div>
                    </div>
                    <div class="col-md-4 mb-3">
                    <label for="address">State</label>
                    <input type="text" class="form-control" id="state" name ="state" placeholder="Northern Ostrobothnia" required="">
                    <div class="invalid-feedback"> Please provide a valid state. </div>
                        
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zip">Zip</label>
                        <input type="text" class="form-control" id="zip" name ="zip" placeholder="" required="">
                        <div class="invalid-feedback"> Zip code required. </div>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="same-address">
                    <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="save-info">
                    <label class="custom-control-label" for="save-info">Save this information for next time</label>
                </div>
                <hr class="mb-4">
                <h4 class="mb-3">Payment</h4>
                <div class="d-block my-3">
                    <div class="custom-control custom-radio">
                        <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
                        <label class="custom-control-label" for="credit">Credit card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required="">
                        <label class="custom-control-label" for="debit">Debit card</label>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cc-name">Name on card</label>
                        <input type="text" class="form-control" id="cc-name" placeholder="" required="">
                        <small class="text-muted">Full name as displayed on card</small>
                        <div class="invalid-feedback"> Name on card is required </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cc-number">Credit card number</label>
                        <input type="text" class="form-control" id="cc-number" placeholder="" required="">
                        <div class="invalid-feedback"> Credit card number is required </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cc-expiration">Expiration</label>
                        <input type="text" class="form-control" id="cc-expiration" placeholder="" required="">
                        <div class="invalid-feedback"> Expiration date required </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-cvv">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" placeholder="" required="">
                        <div class="invalid-feedback"> Security code required </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
            <?php
            if (!isset($_GET['checkout'])) {
                exit();
            }
            else {
                $checkoutCheck = $_GET['checkout'];

                if($checkoutCheck == "empty") {
                    echo "<p class='text-danger'> Please fill all the fields </p>";
                    exit();
                }
                elseif ($checkoutCheck == "char") {
                    echo "<p class='text-danger'> You used invalid characters! </p>";
                    exit();
                }
                elseif ($checkoutCheck == "email") {
                    echo "<p class='text-danger'> You used invalid email! </p>";
                    exit();
                } 
                elseif ($checkoutCheck == "success") {
                    echo "<p class='text-success'> Order has been made! </p>";
                    exit();
            } 
        }  
            

            ?>
        </div>
    </div>
</div>
</section>

<?php
include 'php/footer.php';
?>
