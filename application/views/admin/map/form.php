<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php print(htmlentities($pageTitle)); ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <?php
                            foreach ($arrParentPage as $parentPage => $strUrl) {
                            ?>
                                <li class="breadcrumb-item">
                                    <?php
                                    if (!empty($strUrl)) {
                                    ?>
                                        <a href="<?php print($strUrl); ?>"><?php print(htmlentities($parentPage)); ?></a>
                                    <?php } else {
                                        print(htmlentities($parentPage));
                                    }
                                    ?>
                                </li>
                            <?php } ?>
                            <li class="breadcrumb-item active"><?php print(htmlentities($pageTitle)); ?></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <form action="<?php print($action); ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12">
                    <div id="addproduct-accordion" class="custom-accordion">
                        <div class="card">
                            <div class="p-4">
                                <div class="media align-items-center">
                                    <div class="media-body overflow-hidden">
                                        <h5 class="font-size-16 mb-1">Map Info</h5>
                                        <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                    </div>
                                </div>
                            </div>

                            <div id="addproduct-billinginfo-collapse" class="collapse show" data-parent="#addproduct-accordion">
                                <div class="p-4 border-top">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="state">Enter State</label>
                                                <input id="state" name="state" type="text" placeholder="Enter State" class="form-control" value="<?php print($state); ?>" maxlength="255">
                                                <?php print(form_error('state')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="coords">Enter Map Coords</label>
                                                <input id="coords" name="coords" type="text" placeholder="Enter Map Coords" class="form-control" value="<?php print($coords); ?>" maxlength="255">
                                                <?php print(form_error('coords')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="language">Enter Regional Language</label>
                                                <input id="language" name="language" type="text" placeholder="Enter Regional Language" class="form-control" value="<?php print($language); ?>" maxlength="255">
                                                <?php print(form_error('language')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mt-3 mt-lg-0">
                                                <label for="example-text-input-user" class="control-label">Status</label>
                                                <select id="selGroup" name="status" class="custom-select my-1 select2">
                                                    <option value="">-- Please Select --</option>
                                                    <option value="Y" <?php if($status == 'Y') echo 'selected';?>>Yes
                                                    </option>
                                                    <option value="N" <?php if($status == 'N') echo 'selected';?>>No
                                                    </option>
                                                </select>
                                                <?php print(form_error('status')); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group mt-3 mt-lg-0">
                                                <label for="example-text-input-user" class="control-label">Description</label>
                                                <textarea class="form-control" value="" id="example-text-input-pass2" placeholder="Enter Description" name="description" rows="3"><?php print($description); ?></textarea>
                                                <?php echo form_error('description'); ?>
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
                    <input type="hidden" name="mid" value="<?= $mid; ?>">
                    <a href="<?php print(site_url('admin/map')); ?>" class="btn btn-danger"> <i class="uil uil-times mr-1"></i> Cancel </a>
                    <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt mr-1"></i> Save </button>
                </div> <!-- end col -->
            </div> <!-- end row-->
        </form>

    </div> <!-- container-fluid -->
</div>