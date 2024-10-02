<?php $getCommonSetting = getCommonSetting();?>
<style>
    .list{
        overflow: scroll !important;
    }
    td span {
        font-size: 16px !important;
        padding: 5px !important;
    }
    .navbar-brand img {
        /* background: #000; */
        height: 100px;
        width: 100%;
        background: #000;
    }
</style>

<div class="navbar-brand">
    <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
    <a href=""><img src="<?php echo e(asset('images/webp/58941724953574.webp')); ?>" alt="<?php echo e($getCommonSetting->site_title); ?>"></a>
</div>
<div class="menu">
    <ul class="list">

        <li><a href="<?php echo e(url('admin/dashboard')); ?>" class=" waves-effect waves-block">
                <i class="zmdi zmdi-book-image"></i><span>Dashboard</span></a></li>

        <li><a href="javascript:void(0);" class="menu-toggle waves-effect waves-block">
                <i class="zmdi zmdi-apps"></i><span>Add Banner</span></a>
            <ul class="ml-menu">
                <li><a href="<?php echo e(url('admin/all-banner')); ?>"><span>All Banner</span></a></li>
                <li><a href="<?php echo e(url('admin/add-banner')); ?>"><span>Add Banner</span></a></li>
            </ul>
        </li>

        <li><a href="javascript:void(0);" class="menu-toggle waves-effect waves-block">
                <i class="zmdi zmdi-apps"></i><span>Section & Category</span></a>
            <ul class="ml-menu">
                <li><a href="<?php echo e(url('admin/section')); ?>"><span> Section </span></a></li>
                <li><a href="<?php echo e(url('admin/categories?type=category')); ?>"><span> Category</span></a></li>
            </ul>
        </li>


        <li class="<?php echo e(strpos($_SERVER['REQUEST_URI'], "products") ? 'active' : ''); ?>

            || <?php echo e(strpos($_SERVER['REQUEST_URI'], "product") ? 'active' : ''); ?>

            || <?php echo e(strpos($_SERVER['REQUEST_URI'], "attributes") ? 'active' : ''); ?>

            "><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Products</span></a>
            <ul class="ml-menu">
                <li class="<?php echo e(request()->is('products/all-attributes') ? 'active' : ''); ?>"><a href="<?php echo e(url('admin/products/all-attributes')); ?>">Product Attributes</a></li>
                <li class="<?php echo e(request()->is('add-products') ? 'active' : ''); ?>"><a href="<?php echo e(url('admin/add-products')); ?>">Add Products</a></li>
                <li class="<?php echo e(request()->is('all-products') ? 'active' : ''); ?>"><a href="<?php echo e(url('admin/all-products')); ?>">All Products</a></li>
            </ul>
        </li>

        <li><a href="javascript:void(0);" class="menu-toggle waves-effect waves-block">
                <i class="zmdi zmdi-apps"></i>
                <span>Offers & Discount</span></a>
            <ul class="ml-menu">
                <li><a href="<?php echo e(url('admin/offers')); ?>"><span>All Offers</span></a></li>
            </ul>
        </li>


        <li><a href="javascript:void(0);" class="menu-toggle waves-effect waves-block">
                <i class="zmdi zmdi-apps"></i><span>Orders</span></a>
            <ul class="ml-menu">
                <li><a href="<?php echo e(url('admin/all-orders')); ?>" class=" waves-effect waves-block"><span>All Orders</span></a></li>
            </ul>
        </li>


        <li><a href="javascript:void(0);" class="menu-toggle waves-effect waves-block">
                <i class="zmdi zmdi-apps"></i><span>Add Reviews</span></a>
            <ul class="ml-menu">
                <li><a href="<?php echo e(url('admin/all-reviews')); ?>"><span>All reviews</span></a></li>
                <li><a href="<?php echo e(url('admin/add-reviews')); ?>"><span>Add reviews </span></a></li>
            </ul>
        </li>


        <li><a href="javascript:void(0);" class="menu-toggle waves-effect waves-block">
                <i class="zmdi zmdi-apps"></i><span>Blog</span></a>
            <ul class="ml-menu">
                <li><a href="<?php echo e(url('admin/add-posts?type=article')); ?>" class=" waves-effect waves-block"><span>Add Posts</span></a></li>
                <li><a href="<?php echo e(url('admin/all-post?type=all-posts')); ?>" class=" waves-effect waves-block"><span>Posts</span></a></li>

            </ul>
        </li>

        <li><a href="javascript:void(0);" class="menu-toggle waves-effect waves-block">
                <i class="zmdi zmdi-apps"></i><span>FAQ</span></a>
            <ul class="ml-menu">
                <li><a href="<?php echo e(url('admin/all-faqs')); ?>"><span>All FAQ</span></a></li>
                <li><a href="<?php echo e(url('admin/add-faqs')); ?>"><span>Add FAQ</span></a></li>
            </ul>
        </li>


        <li><a href="javascript:void(0);" class="menu-toggle waves-effect waves-block">
                <i class="zmdi zmdi-apps"></i><span>Return & Refunds</span></a>
            <ul class="ml-menu">
                <li><a href="<?php echo e(url('admin/return-refunds')); ?>" class=" waves-effect waves-block"><span>Return & Refunds</span></a></li>
            </ul>
        </li>
        <li><a href="javascript:void(0);" class="menu-toggle waves-effect waves-block">
                <i class="zmdi zmdi-apps"></i><span>Enquiry</span></a>
            <ul class="ml-menu">
                <li><a href="<?php echo e(url('admin/enquiry')); ?>" class=" waves-effect waves-block"><span>Enquiry</span></a></li>
            </ul>
        </li>

        <li><a href="<?php echo e(url('admin/common-settings')); ?>" class=" waves-effect waves-block"><i class="zmdi zmdi-book-image"></i><span>Common Settings</span></a></li>
        <li><a href="<?php echo e(url('admin/all-users')); ?>" class=" waves-effect waves-block"><i class="zmdi zmdi-book-image"></i><span>Users</span></a></li>
        <li><a href="<?php echo e(url('admin/newsletter')); ?>" class=" waves-effect waves-block"><i class="zmdi zmdi-book-image"></i><span>Newsletter</span></a></li>

    </ul>
</div>
<?php /**PATH H:\xampp\htdocs\silkashi\resources\views/inc/admin/left-sidebar.blade.php ENDPATH**/ ?>