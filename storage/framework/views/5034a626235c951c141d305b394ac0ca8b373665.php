<?php $__empty_1 = true; $__currentLoopData = $get_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getProducts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-md-3 mt-3 product-desc">
        <div class="product-item">

            <a href="<?php echo e(url('products/'.$getProducts->slug)); ?>">
                <img src="<?php echo e(asset($getProducts->photo)); ?>"
                     alt="<?php echo e($getProducts->title); ?>">
            </a>
            <h3 class="product-title text-center">
                <a href="<?php echo e(url('products/'.$getProducts->slug)); ?>"><?php echo e($getProducts->title); ?></a>
            </h3>
            <p class="product-price text-center">
                <span class="currency-symbol">₹</span>
                <span class="sale_price"><?php echo e(number_format($getProducts->product_actual_price ?? 0 , 2)); ?></span>
                <del class="product-price-strike">
                    <span class="currency-symbol">₹</span>
                    <?php echo e(number_format($getProducts->product_max_selling_price ?? 0, 2)); ?>

                </del>
                <br>
                <?php if(!empty($getProducts->product_max_selling_price) && !empty($getProducts->product_actual_price)): ?>
                    <?php
                        $discount = (($getProducts->product_max_selling_price - $getProducts->product_actual_price) / $getProducts->product_max_selling_price) * 100;
                    ?>
                    <span class="discount-percentage"><?php echo e(number_format($discount, 2)); ?>% OFF</span>
                <?php endif; ?>
            </p>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p>No products found</p>
<?php endif; ?>
<?php /**PATH H:\xampp\htdocs\silkashi\resources\views/web/filtered_products.blade.php ENDPATH**/ ?>