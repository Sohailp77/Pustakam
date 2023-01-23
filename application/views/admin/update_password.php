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

        <form action="<?php print(site_url('admin/update_password/update')); ?>" method="POST">
            <div class="row">
                <div class="col-lg-12">
                    <div id="addproduct-accordion" class="custom-accordion">
                        <div class="card">
                            <div class="p-4">
                                <div class="media align-items-center">
                                    <div class="media-body overflow-hidden">
                                        <h5 class="font-size-16 mb-1">Update Your Password</h5>
                                        <p class="text-muted text-truncate mb-0">Enter your old password and new password to update.</p>
                                    </div>
                                </div>
                            </div>

                            <div id="addproduct-billinginfo-collapse" class="collapse show" data-parent="#addproduct-accordion">
                                <div class="p-4 border-top">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtOldPassword">Old Password</label>
                                                <input id="txtOldPassword" name="txtOldPassword" type="password" class="form-control" value="">
                                                <?php print(form_error('txtOldPassword')); ?>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtNewPassword">New Password</label>
                                                <input id="txtNewPassword" name="txtNewPassword" type="password" class="form-control" value="">
                                                <?php print(form_error('txtNewPassword')); ?>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtConfirmPassword">Confirm Password</label>
                                                <input id="txtConfirmPassword" name="txtConfirmPassword" type="password" class="form-control" value="">
                                                <?php print(form_error('txtConfirmPassword')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-4">
                <div class="col text-right">
                    <a href="<?php print(site_url('admin/dashboard')); ?>" class="btn btn-danger"> <i class="uil uil-times mr-1"></i> Cancel </a>
                    <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt mr-1"></i> Save </button>
                </div> <!-- end col -->
            </div> <!-- end row-->
        </form>
        
    </div> <!-- container-fluid -->
</div>