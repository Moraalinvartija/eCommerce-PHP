<?php
include 'php/header.php';
?>

        <!-- Start Content -->
        
        <section class="py-5 bg-light";>
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                 
                    getProducts();
                    
                    ?>
                    
                </div>
            </div>
        </section>
        
        <!-- End Content -->
        <!-- Footer-->
    <?php 
    include 'php/footer.php';
    ?>
