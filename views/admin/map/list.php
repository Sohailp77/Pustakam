<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php print(htmlentities($pageTitle)); ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><?php print(htmlentities($parentPage)); ?></li>
                            <li class="breadcrumb-item active"><?php print(htmlentities($pageTitle)); ?></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12">
                <?php
                $alert = $this->session->userdata('alert');
                if ($alert) {

                    $strErrorType = $alert['type'];
                    if ($alert['type'] == "danger") {
                        $strErrorType = "warning";
                    }

                ?><div class="alert alert-<?= $alert['type'] ?> alert-dismissible"><i class="fa fa-check-circle"></i> <?= ucfirst($strErrorType) ?>: <?= $alert['message'] ?>
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div>
                    
                    <?php $create = $this->Common_model->get_moduleId($this->router->fetch_class(), 'create');
                    if (in_array($create->module_id, $this->session->permission)) { ?>
                        <a href="<?php print(base_url()); ?>admin/map/create" class="btn btn-success waves-effect waves-light mb-3">Add Map</a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive mb-4">
                    <table class="table table-centered dt-responsive datatable  table-card-list" id="example1" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th class="all">State</th>
                                <th class="text-wrap" style="width:10rem">Coords</th>
                                <th class="all">Language</th>
                                <th class="text-wrap">Description</th>
                                <th class="all">Status</th>
                                <th class="all" style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($arrMap as $map)
                            {
                                ?>
                                <tr>
                                    <td><?=$map['TT']?></td>
                                    <td><?=$map['CD']?></td>
                                    <td><?=$map['LG']?></td>
                                    <td><?=$map['DS']?></td>
                                    <td><?=$map['ST']?></td>
                                    <td><?=$map['BN']?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>