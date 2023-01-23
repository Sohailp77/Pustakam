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
                                        <h5 class="font-size-16 mb-1">Chapter Info</h5>
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
                                                <select id="selGroup1" name="state" class="custom-select my-1 select2">
                                                    <option value="">-- Please Select --</option>
                                                    <?php
                                                    foreach($arrState as $st)
                                                    {
                                                        ?>
                                                        <option value="<?=$st->mid?>" <?php if($st->mid == $state) echo 'selected';?>><?=$st->state?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php print(form_error('state')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="state">Enter Class</label>
                                                <select id="selGroup2" name="class" class="custom-select my-1 select2">
                                                    <option value="">-- Please Select --</option>
                                                    <?php
                                                    foreach($arrClass as $cl)
                                                    {
                                                        ?>
                                                        <option value="<?=$cl->cid?>" <?php if($cl->cid == $class) echo 'selected';?>><?=$cl->classname?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php print(form_error('class')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="chapter">Enter Chapter</label>
                                                <input id="chapter" name="chapter" type="text" placeholder="Enter Chapter" class="form-control" value="<?php print($chapter); ?>" maxlength="255">
                                                <?php print(form_error('chapter')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mt-3 mt-lg-0">
                                                <label for="example-text-input-user" class="control-label">Enter Sort
                                                    Order</label>
                                                <input class="form-control" type="number" value="<?= $sort_order; ?>"
                                                    id="example-text-input-pass2" name="sort_order" min="1">
                                                <?php echo form_error('sort_order'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mt-3 mt-lg-0">
                                                <label for="example-text-input-user" class="control-label">View Status</label>
                                                <select id="selGroup3" name="status" class="custom-select my-1 select2">
                                                    <option value="">-- Please Select --</option>
                                                    <option value="Y" <?php if($status == 'Y') echo 'selected';?>>Yes
                                                    </option>
                                                    <option value="N" <?php if($status == 'N') echo 'selected';?>>No
                                                    </option>
                                                </select>
                                                <?php print(form_error('status')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mt-3 mt-lg-0">
                                                <label for="example-text-input-user" class="control-label">Payment Status</label>
                                                <select id="selGroup4" name="payment" class="custom-select my-1 select2">
                                                    <option value="">-- Please Select --</option>
                                                    <option value="Y" <?php if($payment == 'Y') echo 'selected';?>>Paid
                                                    </option>
                                                    <option value="N" <?php if($payment == 'N') echo 'selected';?>>Free
                                                    </option>
                                                </select>
                                                <?php print(form_error('payment')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mt-3 mt-lg-0">
                                                <label for="example-text-input-user" class="control-label">Description</label>
                                                <textarea class="form-control" id="example-text-input-pass2" placeholder="Enter Description" name="description" rows="3"><?php print($description); ?></textarea>
                                                <?php echo form_error('description'); ?>
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="text_file">Pdf File</label><br/>
                                                <?php
                                                if(!empty($text_file)){
                                                    ?><a href="<?php print(UPLOAD_URL . 'pdf/' . $text_file) ?>" target="_blank" style="height: 50px;"><?php print(UPLOAD_URL . 'pdf/' . $text_file) ?></a><?php
                                                }
                                                ?>
                                                <input id="text_file" name="text_file" type="file" class="form-control">
                                                <input type="hidden" name="text" value="<?php print($text_file); ?>">
                                                <?php print(form_error('text_file')); ?>
                                            </div>
                                        </div> -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="image_file">Image File</label><br/>
                                                <?php
                                                if(!empty($image_file)){
                                                    ?><img style="width: 50px;" src="<?php print(UPLOAD_URL . 'images/' . $image_file) ?>"><?php
                                                }
                                                ?>
                                                <input id="image_file" name="image_file" type="file" class="form-control">
                                                <input type="hidden" name="image" value="<?php print($image_file); ?>">
                                                <?php print(form_error('image_file')); ?>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="audio_file">Audio File</label><br/>
                                                <?php
                                                if(!empty($audio_file)){
                                                    ?><audio controls style="max-height:50px"><source src="<?php print(UPLOAD_URL.'audio/'.$audio_file)?>"></audio><?php
                                                }
                                                ?>
                                                <input id="audio_file" name="audio_file" type="file" class="form-control">
                                                <input type="hidden" name="audio" value="<?php print($audio_file); ?>">
                                                <?php print(form_error('audio_file')); ?>
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
                    <a href="<?php print(site_url('admin/chapter')); ?>" class="btn btn-danger"> <i class="uil uil-times mr-1"></i> Cancel </a>
                    <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt mr-1"></i> Save </button>
                </div> <!-- end col -->
            </div> <!-- end row-->
        </form>

    </div> <!-- container-fluid -->
</div>