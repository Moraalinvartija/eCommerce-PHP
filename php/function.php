<?php
function getProducts()
{
    include('php/db_connect.php');
    $sql = "SELECT * FROM product ";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Retrieve product information from the row
            $id_product = $row['id_product'];
            $product_name = $row['name'];
            $product_price = $row['price'];
            $product_category = $row['category_id'];
            $product_description = $row['description'];
            $product_image = $row['image'];
            $product_rating = $row['rating'];

            // Generate star icons based on product rating
            $star_icons = '';
            for ($i = 0; $i < $product_rating; $i++) {
                $star_icons .= '<div class="bi-star-fill"></div>';
            }

            // Check if product is already in cart
            $isInCart = false;
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $cartItem) {
                    if (isset($cartItem['id_product']) && $cartItem['id_product'] == $id_product) {
                        $isInCart = true;
                        break;
                    }
                }
            }

            // Output product card HTML
            echo '
            
            <div class="col-md-6 col-lg-4 mb-5">
    <div class="card h-100">
        <!-- Product image-->
        <a href="single.php?product_id=', $id_product, '&category_id=', $product_category, '">
            <img class="rounded mx-auto d-block" style="max-width:150px;max-height:300px;" src="assets/image/', $product_image, '" alt="..." />
        </a>
        <!-- Product details-->
        <div class="card-body p-4">
            <div class="text-center">
                <!-- Product name-->
                <h5 class="fw-bolder">', $product_name, '</h5>
                <!-- Product price-->
            </div>
        </div>
        <!-- Product actions-->
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent d-flex flex-column">
            <div class="d-flex justify-content-center small text-warning mb-3">
                ', $star_icons, '
            </div>
            <form class="form-inline" method="POST">
                        <div class="text-center">
                            <input type="hidden" name="quantity" id="inputQuantity" type="num" min="1" max="1000" value="1" style="max-width: 3rem" />
                            <input type="hidden" name="product_id" value="', $id_product, ',">
                            <input type="hidden" name="product_name" value="', $product_name, ',">
                            <input type="hidden" name="product_price" value="', $product_price, ',">
                            <button class="btn btn-outline-dark flex-shrink-0" name="add_to_cart" value="add to cart" type="submit" ' . ($isInCart ? 'disabled' : '') . '>
                                <i class="bi-cart-fill me-1"></i>
                                <span class="button-text">' . ($isInCart ? 'Add to Cart' : $product_price . '€') . '</span>
                                <span class="hidden-value">' . ($isInCart ? $product_price . '€' : 'Add to Cart') . '</span>
                            </button>

                        </div>
            </form>
        </div>
    </div>
</div>


            ';
        }
    }
}

function getProductbyCategory()
{
    if (isset($_GET['product_id']) && isset($_GET['category_id'])) {
        include('php/db_connect.php');
        $product_id = $_GET['product_id'];
        $category_id = $_GET['category_id'];

        // Prepare the SQL statement using a prepared statement
        $sql = "SELECT product.id_product, product.name, category.category_id, category.category_name, product.price, product.description, product.image, product.rating
        FROM product
        INNER JOIN category ON product.category_id = CAST(category.category_id AS INT)
        WHERE product.category_id = ? AND product.id_product != ?
        LIMIT 4";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the category_id and product_id parameters to the prepared statement
        $stmt->bind_param("ii", $category_id, $product_id);

        // Execute the prepared statement
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Retrieve product information from the row
                $id_product = $row['id_product'];
                $product_name = $row['name'];
                $product_price = $row['price'];
                $product_category = $row['category_name'];
                $product_category_id = $row['category_id'];
                $product_description = $row['description'];
                $product_image = $row['image'];
                $product_rating = $row['rating'];

                // Generate star icons based on product rating
                $star_icons = '';
                for ($i = 0; $i < $product_rating; $i++) {
                    $star_icons .= '<div class="bi-star-fill"></div>';
                }
                $isInCart = false;
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $cartItem) {
                        if (isset($cartItem['id_product']) && $cartItem['id_product'] == $id_product) {
                            $isInCart = true;
                            break;
                        }
                    }
                }

                // Output product card HTML
                echo '
                <div class="col-md-6 col-lg-4 mb-5">
        <div class="card h-100">
            <!-- Product image-->
            <a href="single.php?product_id=', $id_product, '&category_id=', $product_category_id, '">
                <img class="rounded mx-auto d-block" style="max-width:150px;max-height:300px;" src="assets/image/', $product_image, '" alt="..." />
            </a>
            <!-- Product details-->
            <div class="card-body p-4">
                <div class="text-center">
                    <!-- Product name-->
                    <h5 class="fw-bolder">', $product_name, '</h5>
                    <!-- Product price-->
                </div>
            </div>
            <!-- Product actions-->
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent d-flex flex-column">
                <div class="d-flex justify-content-center small text-warning mb-3">
                    ', $star_icons, '
                </div>
                <form class="form-inline" method="POST">
                            <div class="text-center">
                                <input type="hidden" name="quantity" id="inputQuantity" type="num" min="1" max="1000" value="1" style="max-width: 3rem" />
                                <input type="hidden" name="product_id" value="', $id_product, ',">
                                <input type="hidden" name="product_name" value="', $product_name, ',">
                                <input type="hidden" name="product_price" value="', $product_price, ',">
                                <button class="btn btn-outline-dark flex-shrink-0" name="add_to_cart" value="add to cart" type="submit" ' . ($isInCart ? 'disabled' : '') . '>
                                    <i class="bi-cart-fill me-1"></i>
                                    <span class="button-text">' . ($isInCart ? 'Add to Cart' : $product_price . '€') . '</span>
                                    <span class="hidden-value">' . ($isInCart ? $product_price . '€' : 'Add to Cart') . '</span>
                                </button>
    
                            </div>
                </form>
            </div>
        </div>
    </div>
    
    
                ';
            }
        }
    } else {
        exit();
    }
}

function viewProduct()
{
    if (isset($_GET['product_id'])) {
        include('php/db_connect.php');
        $product_id = $_GET['product_id'];

        // Prepare the SQL statement using a prepared statement
        $sql = "SELECT product.id_product, product.name, category.category_id, category.category_name, product.price, product.description, product.image, product.rating
        FROM product
        INNER JOIN category ON product.category_id = CAST(category.category_id AS INT)
        WHERE product.id_product = ?";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the product_id parameter to the prepared statement
        $stmt->bind_param("i", $product_id);

        // Execute the prepared statement
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Retrieve product information from the row
                $category_id = $row['category_id'];
                $id_product = $row['id_product'];
                $product_name = $row['name'];
                $product_price = $row['price'];
                $product_category = $row['category_name'];
                $product_description = $row['description'];
                $product_image = $row['image'];
                $product_rating = $row['rating'];

                // Generate star icons based on product rating
                $star_icons = '';
                for ($i = 0; $i < $product_rating; $i++) {
                    $star_icons .= '<div class="bi-star-fill"></div>';
                }

                // Check if product is already in cart
                $isInCart = false;
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $cartItem) {
                        if (isset($cartItem['id_product']) && $cartItem['id_product'] == $id_product) {
                            $isInCart = true;
                            break;
                        }
                    }
                }

                // Output product card HTML
                echo '
                <!-- Product section-->
                <section class="py-5">
                <div class="container px-4 px-lg-5 my-5">
                    <div class="row gx-4 gx-lg-5 align-items-center">
                        <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" style="max-width:550px;max-height:600px"src="assets/image/', $product_image, '" alt="..." /></div>
                        <div class="col-md-6">
                        <div class="mb-1">', $product_category, '</div>
                            <h1 class="display-5 fw-bolder" name="product_name" value="', $product_name, '">', $product_name, '</h1>
                            <div class="fs-5 mb-5"><br>
                                <span>', $product_price, '€</span>
                            </div>
                            <p class="lead">', $product_description, '</p>
                            <form class="form-inline" method="POST">
                            <div class="d-flex">
                                <input class="form-control text-center me-3" name="quantity" id="inputQuantity" type="num" min="1" max="1000" value="1" style="max-width: 3rem" />
                                <input type="hidden" name="product_id" value="', $id_product, ',">
                                <input type="hidden" name="product_name" value="', $product_name, ',">
                                <input type="hidden" name="product_price" value="', $product_price, ',">
                                <button class="btn btn-outline-dark flex-shrink-0" name="add_to_cart" value="add to cart" type="submit" ', ($isInCart ? 'disabled' : ''), '>
                                    <i class="bi-cart-fill me-1"></i>
                                    ', ($isInCart ? 'In Cart' : 'Add to Cart'), '
                                </button>
                            </div>
                            </form>
                            
              
                        </div>
                    </div>
                </div>
            </section>
                ';
            }
        }
    } else {

        exit();
    }
}


function makeProductGategoryList()
{
    include('php/db_connect.php');
    $sql = "SELECT * FROM `category` WHERE 1";

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Retrieve product information from the row
            $category_id = $row['category_id'];
            $category_name = $row['category_name'];

            // Output category selectors
            echo '
                <li class="list-group-item">
                    <a href="allproducts.php?category_id=', $category_id, '">' . $category_name . '</a>
                </li>
            ';
        }
    }
}

function listAllProducts()
{
    if (isset($_GET['category_id'])) {
        include('php/db_connect.php');
        $category_id = $_GET['category_id'];

        // Prepare the SQL statement using a prepared statement
        $sql = "SELECT product.id_product, product.name, category.category_id, category.category_name, product.price, product.description, product.image, product.rating
                FROM product
                INNER JOIN category ON product.category_id = CAST(category.category_id AS INT)
                WHERE product.category_id = ?";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the category_id parameter to the prepared statement
        $stmt->bind_param("i", $category_id);

        // Execute the prepared statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Retrieve product information from the row
                $id_product = $row['id_product'];
                $product_name = $row['name'];
                $product_price = $row['price'];
                $product_category = $row['category_name'];
                $product_category_id = $row['category_id'];
                $product_description = $row['description'];
                $product_image = $row['image'];
                $product_rating = $row['rating'];
                // Generate star icons based on product rating
                $star_icons = '';
                for ($i = 0; $i < $product_rating; $i++) {
                    $star_icons .= '<div class="bi-star-fill"></div>';
                }
                // Check if product is already in cart
                $isInCart = false;
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $cartItem) {
                        if (isset($cartItem['id_product']) && $cartItem['id_product'] == $id_product) {
                            $isInCart = true;
                            break;
                        }
                    }
                }

                // Output product card HTML
                echo '
            
            <div class="col-md-6 col-lg-4 mb-5">
    <div class="card h-100">
        <!-- Product image-->
        <a href="single.php?product_id=', $id_product, '&category_id=', $product_category_id, '">
            <img class="rounded mx-auto d-block" style="max-width:150px;max-height:300px;" src="assets/image/', $product_image, '" alt="..." />
        </a>
        <!-- Product details-->
        <div class="card-body p-4">
            <div class="text-center">
                <!-- Product name-->
                <h5 class="fw-bolder">', $product_name, '</h5>
                <!-- Product price-->
            </div>
        </div>
        <!-- Product actions-->
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent d-flex flex-column">
            <div class="d-flex justify-content-center small text-warning mb-3">
                ', $star_icons, '
            </div>
            <form class="form-inline" method="POST">
                        <div class="text-center">
                            <input type="hidden" name="quantity" id="inputQuantity" type="num" min="1" max="1000" value="1" style="max-width: 3rem" />
                            <input type="hidden" name="product_id" value="', $id_product, ',">
                            <input type="hidden" name="product_name" value="', $product_name, ',">
                            <input type="hidden" name="product_price" value="', $product_price, ',">
                            <button class="btn btn-outline-dark flex-shrink-0" name="add_to_cart" value="add to cart" type="submit" ' . ($isInCart ? 'disabled' : '') . '>
                                <i class="bi-cart-fill me-1"></i>
                                <span class="button-text">' . ($isInCart ? 'Add to Cart' : $product_price . '€') . '</span>
                                <span class="hidden-value">' . ($isInCart ? $product_price . '€' : 'Add to Cart') . '</span>
                            </button>

                        </div>
            </form>
        </div>
    </div>
</div>
            ';
            }
        }
    } else {
        getProducts();
    }
}
function sessionBase()
{
    session_start();
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Include the database connection
    include('php/db_connect.php');
    $message = ''; // Initialize an empty message
    // Check if the add to cart button has been clicked
    if (isset($_POST['add_to_cart'])) {
        // Get the product ID, name, price, and quantity from the form
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $quantity = $_POST['quantity'];
        // Check if the cart is already set in the session
        if (isset($_SESSION['cart'])) {
            // If the cart is already set, check if the product is already in the cart
            if (isset($_SESSION['cart'][$product_id])) {
                // If the product is already in the cart, update the quantity
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            } else {
                // If the product is not in the cart, add it to the cart
                $_SESSION['cart'][$product_id] = array(
                    'name' => $product_name,
                    'price' => $product_price,
                    'quantity' => $quantity
                );
            }
        } else {
            // If the cart is not set in the session, add the product to the cart
            $_SESSION['cart'][$product_id] = array(
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => $quantity
            );
        }

        // Set the message for the user
        $message = '<div class="container">
                        <div id="message" class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                            <span>Product added to cart!</span>
                            <button type="button" class="btn btn-danger btn-rounded close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>';
    }

    return $message; // Return the message
}

function displayCartAmount()
{
    $total_quantity = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product) {
            $total_quantity += $product['quantity'];
        }
    }
    echo '<a class="btn btn-outline-dark" href="cart.php">
    <i class="bi-cart-fill me-1"></i>
    Cart
    <span class="badge bg-dark text-white ms-1 rounded-pill">', $total_quantity, '</span>
    </a>';
}
