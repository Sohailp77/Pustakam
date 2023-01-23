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
                                        <h5 class="font-size-16 mb-1">System Variable Info</h5>
                                        <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                    </div>
                                </div>
                            </div>

                            <div id="addproduct-billinginfo-collapse" class="collapse show" data-parent="#addproduct-accordion">
                                <div class="p-4 border-top">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtCode">Code</label><?php

                                                $strReadOnly = "";
                                                $strBgColor = "";
                                                if($pageCode == "USV"){
                                                    $strReadOnly = "readonly";
                                                    $strBgColor = "#f5f6f8";
                                                }

                                                ?><input id="txtCode" name="txtCode" type="text" class="form-control" value="<?php print($txtCode); ?>" maxlength="5" <?php print($strReadOnly); ?> style="background-color: <?php print($strBgColor); ?>">
                                                <?php print(form_error('txtCode')); ?>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtName">Name</label>
                                                <input id="txtName" name="txtName" type="text" class="form-control" value="<?php print($txtName); ?>" maxlength="255">
                                                <?php print(form_error('txtName')); ?>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtValue">Value</label>
                                                <input id="txtValue" name="txtValue" type="text" class="form-control" value="<?php print($txtValue); ?>">

                                                <?php print(form_error('txtValue'));


                                            ?></div>
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
                    <a href="<?php print(site_url('admin/system_settings')); ?>" class="btn btn-danger"> <i class="uil uil-times mr-1"></i> Cancel </a>
                    <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt mr-1"></i> Save </button>
                </div> <!-- end col -->
            </div> <!-- end row-->
        </form>
        
    </div> <!-- container-fluid -->
</div>