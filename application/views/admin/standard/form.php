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
                                        <h5 class="font-size-16 mb-1">Standard Info</h5>
                                        <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                    </div>
                                </div>
                            </div>

                            <div id="addproduct-billinginfo-collapse" class="collapse show" data-parent="#addproduct-accordion">
                                <div class="p-4 border-top">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="classname">Enter Class Name</label>
                                                <input id="classname" name="classname" type="text" placeholder="Enter name"
                                                    class="form-control" value="<?php print($classname); ?>"
                                                    maxlength="255">
                                                <?php print(form_error('classname')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mt-3 mt-lg-0">
                                                <label for="example-text-input-user" class="control-label">Enter Sort
                                                    Order</label>
                                                <input class="form-control" type="number" value="<?= $sort_order; ?>"
                                                    id="example-text-input-pass2" name="sort_order" min="1">
                                                <?php echo form_error('sort_order'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
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
                        <input type="hidden" name="cid" value="<?=$cid; ?>">
                        <a href="<?php print(site_url('admin/standard')); ?>" class="btn btn-danger"> <i
                                class="uil uil-times mr-1"></i> Cancel </a>
                        <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt mr-1"></i> Save
                        </button>
                    </div> <!-- end col -->
                </div> <!-- end row-->
        </form>
    </div> <!-- container-fluid -->
</div>