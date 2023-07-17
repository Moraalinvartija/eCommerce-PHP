<?php function viewProduct()
{
    if (isset($_GET['product_id'])) {
        include('php/db_connect.php');
        $product_id = $_GET['product_id'];
        $sql = "SELECT product.id_product,product.name,category.category_name,product.price,product.description,product.image,product.rating
    FROM product
    INNER JOIN category ON product.category_id = CAST(category.category_id AS INT)
    WHERE product.id_product = $product_id";

        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Retrieve product information from the row
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
                        <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" style="max-width:550px;max-height:600px"src="assets/image/', $product_image,'" alt="..." /></div>
                        <div class="col-md-6">
                        <div class="mb-1">', $product_category, '</div>
                            <h1 class="display-5 fw-bolder" name="product_name" value="',$product_name,'">', $product_name, '</h1>
                            <div class="fs-5 mb-5"><br>
                                <span>', $product_price, '€</span>
                            </div>
                            <p class="lead">', $product_description, '</p>
                            <form class="form-inline" method="POST">
                            <div class="d-flex">
                                <input class="form-control text-center me-3" name="quantity" id="inputQuantity" type="num" min="1" max="1000" value="1" style="max-width: 3rem" />
                                <input type="hidden" name="product_id" value="',$id_product,',">
                                <input type="hidden" name="product_name" value="',$product_name,',">
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
