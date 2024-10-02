<ul class="navbar-nav">
    <li>

  <a href="<?php echo e(route('logout')); ?>"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
     class="mega-menu" title="Sign Out"><i class="zmdi zmdi-power"></i>

  </a>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
            <?php echo csrf_field(); ?>
        </form>
    </li>
</ul>
<?php /**PATH H:\xampp\htdocs\silkashi\resources\views/inc/admin/navbar-right.blade.php ENDPATH**/ ?>