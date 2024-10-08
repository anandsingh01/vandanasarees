<!doctype html>
<html class="no-js " lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <title>:: Admin :: </title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin')); ?>/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin')); ?>/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin')); ?>/assets/plugins/charts-c3/plugin.css"/>

    <link rel="stylesheet" href="<?php echo e(asset('assets/admin')); ?>/assets/plugins/morrisjs/morris.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <?php echo $__env->yieldContent('css'); ?>
    <?php echo $__env->yieldContent('style'); ?>
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin')); ?>/assets/css/style.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <style>
        .mtb-10{
            margin:10px 0;
        }
        .radio.radio-inline {
            display: inline;
        }
    </style>


</head>

<body class="theme-blush">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img class="zmdi-hc-spin" src="<?php echo e(asset('assets/admin')); ?>/assets/images/loader.svg" width="48" height="48" alt="Aero"></div>
        <p>Please wait...</p>
    </div>
</div>

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<!-- Right Icon menu Sidebar -->
<div class="navbar-right">
    <?php echo $__env->make('inc.admin.navbar-right', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <?php echo $__env->make('inc.admin.left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</aside>

<!-- Main Content -->

<section class="content">

    <?php echo $__env->yieldContent('body'); ?>
</section>


<!-- Jquery Core Js -->
<script src="<?php echo e(asset('assets/admin')); ?>/assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
<script src="<?php echo e(asset('assets/admin')); ?>/assets/bundles/vendorscripts.bundle.js"></script> <!-- slimscroll, waves Scripts Plugin Js -->

<script src="<?php echo e(asset('assets/admin')); ?>/assets/bundles/jvectormap.bundle.js"></script> <!-- JVectorMap Plugin Js -->
<script src="<?php echo e(asset('assets/admin')); ?>/assets/bundles/sparkline.bundle.js"></script> <!-- Sparkline Plugin Js -->
<script src="<?php echo e(asset('assets/admin')); ?>/assets/bundles/c3.bundle.js"></script>

<script src="<?php echo e(asset('assets/admin')); ?>/assets/bundles/mainscripts.bundle.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/assets/js/pages/index.js"></script>
<script src="<?php echo e(asset('vendor/laravel-filemanager/js/stand-alone-button.js')); ?>"></script>

<?php echo $__env->yieldContent('js'); ?>
<?php echo $__env->yieldContent('script'); ?>
</body>
</html>
<?php /**PATH H:\xampp\htdocs\silkashi\resources\views/layouts/admin.blade.php ENDPATH**/ ?>