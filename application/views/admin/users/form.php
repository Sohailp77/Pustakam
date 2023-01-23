<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php print(htmlentities($pageTitle)); ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0"><?php

                                                    foreach ($arrParentPage as $parentPage => $strUrl) {
                                                    ?><li class="breadcrumb-item"><?php

                                                                if (!empty($strUrl)) {
                                                                ?><a href="<?php print($strUrl); ?>"><?php print(htmlentities($parentPage)); ?></a><?php
                                                                                                                        } else {
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
                                        <h5 class="font-size-16 mb-1">User Info</h5>
                                        <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                    </div>
                                </div>
                            </div>

                            <div id="addproduct-billinginfo-collapse" class="collapse show" data-parent="#addproduct-accordion">
                                <div class="p-4 border-top">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtName">Name</label>
                                                <input id="txtName" name="txtName" type="text" placeholder="Enter name" class="form-control" value="<?php print($txtName); ?>" maxlength="255">
                                                <?php print(form_error('txtName')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtEmail">Email Id</label>
                                                <input id="txtEmail" name="txtEmail" type="text" placeholder="Enter email" class="form-control" value="<?php print($txtEmail); ?>" maxlength="255">
                                                <?php print(form_error('txtEmail')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtPhone">Phone No</label>
                                                <input id="txtPhone" name="txtPhone" type="text" placeholder="Enter phone" class="form-control" value="<?php print($txtPhone); ?>" maxlength="255">
                                                <?php print(form_error('txtPhone')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtUsername">Username</label>
                                                <input id="txtUsername" name="txtUsername" type="text" placeholder="Enter username" class="form-control" value="<?php print($txtUsername); ?>" maxlength="255">
                                                <?php print(form_error('txtUsername')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtPassword">Password</label>
                                                <input id="txtPassword" name="txtPassword" type="password" placeholder="Enter password" class="form-control" value="<?php print($txtPassword); ?>" maxlength="255">
                                                <?php print(form_error('txtPassword')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="txtConPassword">Confirm Password</label>
                                                <input id="txtConPassword" name="txtConPassword" type="password" placeholder="Confirm your password" class="form-control" value="<?php print($txtConPassword); ?>" maxlength="255">
                                                <?php print(form_error('txtConPassword')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="selUserGroup">Select Usergroup</label>
                                                <select id="selUserGroup" name="selUserGroup" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php foreach ($userGroupList as $userGroupListInfo) { ?>
                                                        <option value="<?= $userGroupListInfo->id; ?>" <?php if ($selUserGroup == $userGroupListInfo->id) echo 'selected'; ?>><?= $userGroupListInfo->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php print(form_error('selUserGroup')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="selStatus">Select Status</label>
                                                <select id="selStatus" name="selStatus" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Y" <?php if ($selStatus == 'Y') echo 'selected'; ?>>Active</option>
                                                    <option value="N" <?php if ($selStatus == 'N') echo 'selected'; ?>>Inactive</option>
                                                </select>
                                                <?php print(form_error('selStatus')); ?>
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
                    <input type="hidden" name="txtId" value="<?= $txtId; ?>">
                    <a href="<?php print(site_url('admin/users')); ?>" class="btn btn-danger"> <i class="uil uil-times mr-1"></i> Cancel </a>
                    <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt mr-1"></i> Save </button>
                </div> <!-- end col -->
            </div> <!-- end row-->
        </form>

    </div> <!-- container-fluid -->
</div>