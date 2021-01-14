<?= $this->extend('admin/layouts/default') ?>

<?= $this->section('content') ?>

<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Admin Page</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Admin Page</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header">
                        <h5>View All Admin</h5>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-horizontal"></i>
                                </button>
                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                    <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                    <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>
                                    <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?= base_url() ?>/admin/admin/insert"><input type="button" value="Add new admin" class="btn btn-primary has-ripple" style="float:right"></a>
                                </div>
                                <div class="card-body table-border-style">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Fullname</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php



                                                foreach ($users as $row) : ?>
                                                    <tr>
                                                        <td><?= $row['fullname'] ?></td>
                                                        <td><?= $row['email'] ?></td>
                                                        <td><?= ($row['is_active'] == 1) ? 'Enable' : 'Disable' ?></td>

                                                        <td>
                                                            <a href="<?= base_url()  ?>/admin/admin/update/<?= md5($row['user_id']); ?>">Edit</a> |
                                                            <a href="<?= base_url()  ?>/admin/admin/delete/<?= md5($row['user_id']); ?>">Delete</a> | <a href="<?= base_url()  ?>/admin/admin/sendResetLink/<?= md5($row['email']); ?>">Send Reset Password Link</a> |
                                                            <?php if ($row['is_active'] == 1) : ?>
                                                                <a href="<?= base_url()  ?>/admin/admin/status/<?= md5($row['user_id']); ?>/0">
                                                                    <?= 'Disable' ?>
                                                                </a>
                                                            <?php else : ?>
                                                                <a href="<?= base_url()  ?>/admin/admin/status/<?= md5($row['user_id']); ?>/1">
                                                                    <?= 'Enable' ?>
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>



<?= $this->endSection(); ?>