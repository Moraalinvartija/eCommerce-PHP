<footer class="py-5 bg-dark mt-auto">
            <div class="container"><p class="m-0 text-center text-white">Portfolio eCommerce Example</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script>
    document.addEventListener('DOMContentLoaded', function() {
        var closeButtons = document.querySelectorAll('[data-dismiss="alert"]');
        closeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var alert = button.closest('.alert');
                alert.remove();
            });
        });
    });
</script>

        
    </body>
</html>