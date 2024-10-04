<script>
    // $(document).ready(function () {
    //     // Select only one checkbox at a time
    //     $('.category-checkbox').on('change', function () {
    //         $('.category-checkbox').prop('checked', false); // Uncheck all checkboxes
    //         $(this).prop('checked', true); // Check the clicked checkbox
    //     });
    //
    // });

    $(document).ready(function() {
        // Select only one checkbox at a time within the category group
        $('.category-checkbox').on('change', function() {
            if ($(this).prop('checked')) {
                $('.category-checkbox').not(this).prop('checked', false);
            }
        });
    });
    $(document).ready(function() {
        // Select only one checkbox at a time within the brand group
        $('.brand-checkbox').on('change', function() {
            if ($(this).prop('checked')) {
                $('.brand-checkbox').not(this).prop('checked', false);
            }
        });
    });

    // $(document).ready(function () {
    //     // Select only one checkbox at a time
    //     $('.brand-checkbox').on('change', function () {
    //         $('.brand-checkbox').prop('checked', false); // Uncheck all checkboxes
    //         $(this).prop('checked', true); // Check the clicked checkbox
    //     });
    //
    // });
    // $(document).ready(function () {
    //     // Select only one checkbox at a time
    //     $('.productsize-checkbox').on('change', function () {
    //         $('.productsize-checkbox').prop('checked', false); // Uncheck all checkboxes
    //         $(this).prop('checked', true); // Check the clicked checkbox
    //     });
    // });

    $(document).ready(function() {
        // Toggle the checkboxes within the producttype group
        $('.producttype-checkbox').on('change', function() {
            $(this).siblings('.producttype-checkbox').prop('checked', false);
        });
    });
    // $(document).ready(function () {
    //     // Select only one checkbox at a time
    //     $('.producttype-checkbox').on('change', function () {
    //         $('.producttype-checkbox').prop('checked', false); // Uncheck all checkboxes
    //         $(this).prop('checked', true); // Check the clicked checkbox
    //     });
    //
    // });
</script>


<?php
$currentUrl = \Request::url();

// Use the collect helper to split the URL by slashes and get the last segment
$segments = collect(explode('/', $currentUrl));
$lastSegment = $segments->last();
?>
<!-- Add this script tag within your HTML body or in a separate JavaScript file -->
<script>
    $(document).ready(function() {
        $('.category-checkbox, .brand-checkbox, .producttype-checkbox, .productsize-checkbox').change(function() {
            updateFilteredProducts();
        });

        function updateFilteredProducts() {
            var currenturl = "<?php echo e($lastSegment); ?>";

            var selectedCategories = $('.category-checkbox:checked')
                .map(function() {
                    return $(this).attr('id').replace('cat-', '');
                })
                .get();

            var selectedBrands = $('.brand-checkbox:checked')
                .map(function() {
                    return $(this).attr('id').replace('brand-', '');
                })
                .get();

            var selectedProductTypes = $('.producttype-checkbox:checked')
                .map(function() {
                    return $(this).attr('id');
                })
                .get();

            var selectedProductSizes = $('.productsize-checkbox:checked')
                .map(function() {
                    return $(this).attr('id');
                })
                .get();

            // alert(currenturl);
            // return false;
            $.ajax({
                url: "<?php echo e(url('/filter')); ?>", // Change this to your Laravel route for filtering
                method: 'GET',
                data: {
                    categories: selectedCategories,
                    brands: selectedBrands,
                    productTypes: selectedProductTypes,
                    productSizes: selectedProductSizes,
                    currenturl : currenturl
                },
                success: function(response) {
                    $('#filteredProducts').html(response); // Update the content of the container
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });



</script>
<?php /**PATH H:\xampp\htdocs\silkashi\resources\views/inc/web/sidebar-script.blade.php ENDPATH**/ ?>