<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php print(htmlentities($pageTitle)); ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0"><?php

                            foreach($arrParentPage as $parentPage => $strUrl){
                                ?><li class="breadcrumb-item"><?php

                                    if(!empty($strUrl)){
                                        ?><a href="<?php print($strUrl); ?>"><?php print(htmlentities($parentPage)); ?></a><?php
                                    }
                                    else{
                                        print(htmlentities($parentPage));
                                    }

                                ?></li><?php
                            }

                            ?><li class="breadcrumb-item active"><?php print(htmlentities($pageTitle)); ?></li>
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
                    if($alert['type'] == "danger"){
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
                    <a href="<?php print(base_url()); ?>admin/admin_pages/create" class="btn btn-success waves-effect waves-light mb-3">Add Page</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive mb-4">
                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th class="all">Controller</th>
                                <th class="all">Title</th>
                                <th class="all">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>