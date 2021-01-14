<!DOCTYPE html>
<html lang="en">

<head>

    <title>Setup Project</title>
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
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/toastr.min.css">




</head>

<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
    <div class="auth-content">
        <div class="card">
            <div class="row align-items-center text-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <img src="<?= base_url() ?>/assets/images/newlogo.png" alt="" class="img-fluid mb-4">
                        <h4 class="mb-3 f-w-400">Change Password</h4>
                        <?= \Config\Services::validation()->listErrors(); ?>
                        <form action="<?= base_url() ?>/user/login/change_password" method="post">

                            <div class="form-group mb-4">
                                <label class="floating-label" for="Password">New Password</label>
                                <input type="password" class="form-control" id="Password" name="password">
                            </div>

                            <input type="hidden" name="key" value="<?= $_GET['key'] ?>" />
                            <!-- <div class=" custom-control custom-checkbox text-left mb-4 mt-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Save credentials.</label>
                    </div> -->
                            <button class="btn btn-block btn-primary mb-4" type="submit">Signin</button>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="<?= base_url() ?>/assets/admin/js/vendor-all.min.js"></script>
<script src="<?= base_url() ?>/assets/admin/js/plugins/bootstrap.min.js"></script>
<script src="<?= base_url() ?>/assets/admin/js/ripple.js"></script>
<script src="<?= base_url() ?>/assets/admin/js/pcoded.min.js"></script>
<script src=" https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"> </script>

<?php if (isset($_SESSION['msg_error'])) { ?>
    <?php echo "<script>toastr.error('" . display_error() . "')</script>"; ?>
<?php } ?>

<?php if (isset($_SESSION['msg_success'])) { ?>

    <?php echo "<script>toastr.success('" . display_success_message() . "')</script>"; ?>

<?php } ?>


</body>

</html>