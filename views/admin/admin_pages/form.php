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

        <form action="<?php print($action); ?>" method="POST">
            <div class="row">
                <div class="col-lg-12">
                    <div id="addproduct-accordion" class="custom-accordion">
                        <div class="card">
                            <div class="p-4">
                                <div class="media align-items-center">
                                    <div class="media-body overflow-hidden">
                                        <h5 class="font-size-16 mb-1">Admin Page</h5>
                                        <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                    </div>
                                </div>
                            </div>

                            <div id="addproduct-billinginfo-collapse" class="collapse show" data-parent="#addproduct-accordion">
                                <div class="p-4 border-top">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="txt_name">Title</label>
                                                <input id="txt_name" name="txt_name" type="text" class="form-control" value="<?php print($txt_name); ?>" required>
                                                <?php print(form_error('txt_name')); ?>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="txt_controller">Controller</label>
                                                <input id="txt_controller" name="txt_controller" type="text" class="form-control" value="<?php print($txt_controller); ?>" required>
                                                <?php print(form_error('txt_controller')); ?>
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
                    <a href="<?php print(site_url('admin/admin_pages')); ?>" class="btn btn-danger"> <i class="uil uil-times mr-1"></i> Cancel </a>
                    <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt mr-1"></i> Save </button>
                </div> <!-- end col -->
            </div> <!-- end row-->
        </form>
        
    </div> <!-- container-fluid -->
</div>