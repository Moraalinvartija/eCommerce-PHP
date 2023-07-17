<?php
include 'php/header.php';

?>
<?php
viewProduct();
?>
        
        <!-- Related items section-->
        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4 text-center">Related products</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                    getProductbyCategory();

                    ?>
              
                </div>
            </div>
        </section>
        <!-- Footer-->
        <?php
        include 'php/footer.php';

        ?>