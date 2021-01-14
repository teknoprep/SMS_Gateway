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
                            <h5 class="m-b-10">Carrier</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>/admin/carrier"><i class="feather icon-home"></i></a></li>

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
                        <h5>Update Carrier</h5>
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
                        <div class="row">
                            <div class="col-md-6">
                                <?= \Config\Services::validation()->listErrors(); ?>
                                <form action="<?= base_url() ?>/admin/carrier/update" method="post" enctype="multipart/form-data">


                                    <div class="form-group">
                                        <number>Carrier</carrier>
                                            <input type="text" class="form-control" name="name" value="<?= $update['name'] ?>" />
                                    </div>

                                    <div class="form-group">
                                        <number>Function name</carrier>
                                            <input type="text" class="form-control" name="function" value="<?= $update['function'] ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="">Label</label>
                                        <select name="ddlabel[]" id="ddlabel" class="form-control" multiple="multiple">
                                            <?php

                                            $labelId = explode(",", $update['label_id']);
                                            foreach ($labels as $row) : ?>
                                                <option value="<?= $row['label_id'] ?>" <?= (in_array($row['label_id'], $labelId, true))
                                                                                            ? "selected" : ""  ?>><?= $row['label_name'] ?></option>
                                            <?php endforeach;   ?>
                                        </select>
                                    </div>

                                    <input type="hidden" name="carrier_id" value="<?= $update['carrier_id'] ?>">

                                    <button type="submit" class="btn  btn-primary">Update Carrier</button>
                                </form>
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