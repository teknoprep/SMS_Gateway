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
                            <h5 class="m-b-10">User Numbers</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">User Number</a></li>
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
                        <h5>View All User Numbers</h5>
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
                                    <!--   <h5>Striped Table</h5>
                                    <span class="d-block m-t-5">use class <code>table-striped</code> inside table element</span> -->
                                    <a href="<?= base_url() ?>/admin/user/getNumbers/<?= $id ?>"><input type="button" value="Add new Number" class="btn btn-primary has-ripple" style="float:right"></a>
                                </div>
                                <div class="card-body table-border-style">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Number</th>
                                                    <th>Label</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($numbers->getResult() as $row) : ?>
                                                    <tr>

                                                        <td><?= $row->number ?></td>
                                                        <td><?php
                                                            $labelId = $row->label_id;
                                                            if ($labelId) {
                                                                $labelId = explode(",", $labelId);
                                                                $labelName = '';
                                                                foreach ($labelId as $labelRow) {
                                                                    foreach ($labels as $label) {
                                                                        if ($label['label_id'] == $labelRow) {
                                                                            $labelName .= $label['label_name'] . ',';
                                                                        }
                                                                    }
                                                                }
                                                                echo rtrim($labelName, ',');
                                                            }

                                                            ?></td>
                                                        <td>

                                                            <a href="<?= base_url()  ?>/admin/user/assignNumber/<?= md5($row->number_id); ?>/<?= $id ?>">Assign Number</a>

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