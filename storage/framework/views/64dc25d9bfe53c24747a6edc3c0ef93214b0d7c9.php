<!doctype html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/font-awesome.min.css')); ?>">
    <!-- owl.carousel CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/owl.carousel.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/owl.theme.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/owl.transitions.css')); ?>">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/animate.css')); ?>">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/normalize.css')); ?>">
    <!-- meanmenu icon CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/meanmenu.min.css')); ?>">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/main.css')); ?>">
    <!-- educate icon CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/educate-custon-icon.css')); ?>">
    <!-- morrisjs CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/morrisjs/morris.css')); ?>">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/scrollbar/jquery.mCustomScrollbar.min.css')); ?>">
    <!-- metisMenu CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/metisMenu/metisMenu.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/metisMenu/metisMenu-vertical.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/style.css')); ?>">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/responsive.css')); ?>">
    <!-- modernizr JS
		============================================ -->
    <script src="<?php echo e(asset('assets/js/vendor/modernizr-2.8.3.min.js')); ?>"></script>
    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            color: white;
            text-align: center;
        }
        .footer p {
            color: gray;
        }
        .footer p a {
            color: blue;
        }
    </style>
</head>

<body>

    <main role="main">
        <!--[if lt IE 8]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p><![endif]-->
        <!-- Start Welcome area -->
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="all-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="logo-pro">
                            <a href="<?php echo e(url('/')); ?>"><img class="main-logo" src="<?php echo e(asset('assets/img/logo/logo.png')); ?>" alt="" /></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-advance-area">
                <div class="header-top-area">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="header-top-wraper">
                                    <div class="row">
                                        <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                            <div class="menu-switcher-pro">
                                                <button type="button" id="sidebarCollapse"
                                                    class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                                    <i class="educate-icon educate-nav"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                            <div class="header-top-menu tabl-d-n">
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                            <div class="header-right-info">
                                                <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                                    <li class="nav-item">
                                                        <a href="#" data-toggle="dropdown" role="button"
                                                            aria-expanded="false" class="nav-link dropdown-toggle">
                                                            <span class="admin-name" style="min-width:150px">Hi, <?php echo e(Auth::user()->name); ?></span>
                                                            <i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
                                                        </a>
                                                        <ul role="menu"
                                                            class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                                            <li>
                                                                <a title="Rekapitulasi" class="" href="<?php echo e(route('password.edit')); ?>" aria-expanded="false">
                                                                    <span class="fa fa-gears sub-icon-mg" aria-hidden="true"></span>
                                                                    <span class="mini-click-non ">Ubah Password</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a title="Keluar" class="" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false">
                                                                    <span class="fa fa-sign-out sub-icon-mg" aria-hidden="true"></span>
                                                                    <span class="mini-click-non ">Keluar</span>
                                                                </a>

                                                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                                                    <?php echo csrf_field(); ?>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu start -->
                <div class="mobile-menu-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php echo $__env->make('layouts.navbar-mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu end -->

                <!-- Content of Web -->

                <!-- Breadcumb -->
                <div class="breadcome-area" >
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="breadcome-list">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                          <?php echo $__env->yieldPushContent('breadcrumb-left'); ?>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                          <?php echo $__env->yieldPushContent('breadcrumb-right'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Breadcumb end -->
                <?php echo $__env->yieldPushContent('breadcumb-custom'); ?>
            </div>
            <?php echo $__env->make('layouts.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <!-- jquery
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/vendor/jquery-1.12.4.min.js')); ?>"></script>
    <!-- bootstrap JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
    <!-- wow JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/wow.min.js')); ?>"></script>
    <!-- price-slider JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/jquery-price-slider.js')); ?>"></script>
    <!-- meanmenu JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/jquery.meanmenu.js')); ?>"></script>
    <!-- sticky JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/jquery.sticky.js')); ?>"></script>
    <!-- scrollUp JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/jquery.scrollUp.min.js')); ?>"></script>
    <!-- counterup JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/counterup/jquery.counterup.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/counterup/waypoints.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/counterup/counterup-active.js')); ?>"></script>
    <!-- mCustomScrollbar JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/scrollbar/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/scrollbar/mCustomScrollbar-active.js')); ?>"></script>
    <!-- metisMenu JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/metisMenu/metisMenu.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/metisMenu/metisMenu-active.js')); ?>"></script>
    <!-- owl.carousel JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/owl.carousel.min.js')); ?>"></script>
    <!-- morrisjs JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/morrisjs/raphael-min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/morrisjs/morris.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/morrisjs/morris-active.js')); ?>"></script>
    <!-- morrisjs JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/sparkline/jquery.sparkline.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/sparkline/jquery.charts-sparkline.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/sparkline/sparkline-active.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts-asset'); ?>

    <!-- plugins JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/plugins.js')); ?>"></script>
  <?php echo $__env->yieldPushContent('scripts'); ?>
    <!-- main JS
  ============================================ -->
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/sweetalert/sweetalert.min.js')); ?>"></script>

</body>

</html>
<?php /**PATH /home/u5982481/public_html/spp-sekolah/core/resources/views/layouts/app.blade.php ENDPATH**/ ?>