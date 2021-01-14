<!DOCTYPE html>
<html lang="en">

<head>
    <title>SMS Gateway | Admin Panel</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="<?= base_url() ?>/assets/admin/images/favicon.ico" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/admin/css/style.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/admin/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">

</head>

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar menu-light ">
        <div class="navbar-wrapper  ">
            <div class="navbar-content scroll-div ">

                <div class="">
                    <div class="main-menu-header">
                        <img class="img-radius" src="<?= base_url() ?>/assets/admin/images/user/avatar-2.jpg" alt="User-Profile-Image">
                        <div class="user-details">
                            <div id="more-details"> <i class="fa fa-caret-down"></i></div>
                        </div>
                    </div>
                    <div class="collapse" id="nav-user-link">
                        <ul class="list-unstyled">
                            <li class="list-group-item"><a href="<?= base_url() ?>/admin/user/edit_profile"><i class="feather icon-user m-r-5"></i>Edit Profile</a></li>

                            <li class="list-group-item"><a href="<?= base_url() ?>/admin/login/logout"><i class="feather icon-log-out m-r-5"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>

                <ul class="nav pcoded-inner-navbar ">

                    <li class="nav-item pcoded-menu-caption">
                        <label>Admins</label>
                    </li>

                    <li class="nav-item">
                        <a href="<?= base_url() ?>/admin/admin" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">View Admins</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/admin/admin/insert" class="nav-link "><span class="pcoded-micon"><i class="feather icon-align-justify"></i></span><span class="pcoded-mtext">Add Admin</span></a>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>Users</label>
                    </li>

                    <li class="nav-item">
                        <a href="<?= base_url() ?>/admin/user" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">View Users</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/admin/user/insert" class="nav-link "><span class="pcoded-micon"><i class="feather icon-align-justify"></i></span><span class="pcoded-mtext">Add User</span></a>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>Carriers</label>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/admin/carrier" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">View Carriers</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/admin/carrier/insert" class="nav-link "><span class="pcoded-micon"><i class="feather icon-align-justify"></i></span><span class="pcoded-mtext">Add New Carrier</span></a>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>Phone Numbers</label>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/admin/number" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">View Numbers</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/admin/number/insert" class="nav-link "><span class="pcoded-micon"><i class="feather icon-align-justify"></i></span><span class="pcoded-mtext">Add New Number</span></a>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>Label</label>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/admin/label" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">View Labels</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/admin/label/insert" class="nav-link "><span class="pcoded-micon"><i class="feather icon-align-justify"></i></span><span class="pcoded-mtext">Add New Label</span></a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">


        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
            <a href="#!" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <img src="<?= base_url() ?>/assets/images/newlogo.png" alt="" class="logo" style="height:50px;">
                <img src="<?= base_url() ?>/assets/admin/images/logo-icon.png" alt="" class="logo-thumb">
            </a>
            <a href="#!" class="mob-toggler">
                <i class="feather icon-more-vertical"></i>
            </a>
        </div>
        <!--  <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="#!" class="pop-search"><i class="feather icon-search"></i></a>
                    <div class="search-bar">
                        <input type="text" class="form-control border-0 shadow-none" placeholder="Search hear">
                        <button type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon feather icon-bell"></i></a>
                        <div class="dropdown-menu dropdown-menu-right notification">
                            <div class="noti-head">
                                <h6 class="d-inline-block m-b-0">Notifications</h6>
                                <div class="float-right">
                                    <a href="#!" class="m-r-10">mark as read</a>
                                    <a href="#!">clear all</a>
                                </div>
                            </div>
                            <ul class="noti-body">
                                <li class="n-title">
                                    <p class="m-b-0">NEW</p>
                                </li>
                                <li class="notification">
                                    <div class="media">
                                        <img class="img-radius" src="<?= base_url() ?>/assets/admin/images/user/avatar-1.jpg" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <p><strong>Admin</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>5 min</span></p>
                                            <p>New ticket Added</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="n-title">
                                    <p class="m-b-0">EARLIER</p>
                                </li>
                                <li class="notification">
                                    <div class="media">
                                        <img class="img-radius" src="<?= base_url() ?>/assets/admin/images/user/avatar-2.jpg" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>10 min</span></p>
                                            <p>Prchace New Theme and make payment</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="notification">
                                    <div class="media">
                                        <img class="img-radius" src="<?= base_url() ?>/assets/admin/images/user/avatar-1.jpg" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <p><strong>Sara Soudein</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>12 min</span></p>
                                            <p>currently login</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="notification">
                                    <div class="media">
                                        <img class="img-radius" src="<?= base_url() ?>/assets/admin/images/user/avatar-2.jpg" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>30 min</span></p>
                                            <p>Prchace New Theme and make payment</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="noti-footer">
                                <a href="#!">show all</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="dropdown drp-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="feather icon-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                            <div class="pro-head">
                                <img src="<?= base_url() ?>/assets/admin/images/user/avatar-1.jpg" class="img-radius" alt="User-Profile-Image">
                                <span>John Doe</span>
                                <a href="<?= base_url() ?>/admin/login/logout" class="dud-logout" title="Logout">
                                    <i class="feather icon-log-out"></i>
                                </a>
                            </div>
                            <ul class="pro-body">
                                <li><a href="user-profile.html" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
                                <li><a href="email_inbox.html" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li>
                                <li><a href="auth-signin.html" class="dropdown-item"><i class="feather icon-lock"></i> Lock Screen</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div> -->


    </header>
    <!-- [ Header ] end -->


    <?= $this->renderSection('content') ?>


    <script src="<?= base_url() ?>/assets/admin/js/vendor-all.min.js"></script>
    <script src="<?= base_url() ?>/assets/admin/js/plugins/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/assets/admin/js/ripple.js"></script>
    <script src="<?= base_url() ?>/assets/admin/js/pcoded.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"> </script>



    <script>
        $(document).ready(function() {

            $('#multi-numbers').multiselect({
                includeSelectAllOption: true
            });

            $('#ddlabel').multiselect({
                includeSelectAllOption: true
            });

            $('#ddLabel').addClass('form-control');
        });
    </script>


</body>

</html>

<?php if (isset($_SESSION['msg_error'])) { ?>
    <?php echo "<script>toastr.error('" . display_error() . "')</script>"; ?>
<?php } ?>

<?php if (isset($_SESSION['msg_success'])) { ?>

    <?php echo "<script>toastr.success('" . display_success_message() . "')</script>"; ?>

<?php } ?>