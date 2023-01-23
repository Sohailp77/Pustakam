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
                    <div class="float-right">
                        <form class="form-inline mb-3" action="<?php print(current_url()); ?>" method="GET">
                            <label class="my-1 mr-2">User Group</label>
                            <select class="custom-select my-1 select2" name="group" onchange="javascript: this.form.submit();">
                                <option value="">All</option>
                                <?php if ($objUserGroups) {
                                    foreach ($objUserGroups as $objUserGroupInfo) {
                                        $strSelected = "";
                                        if ($objUserGroupInfo->userGroupId == $userGroupId) {
                                            $strSelected = "selected";
                                        }
                                ?>
                                        <option value="<?php print($objUserGroupInfo->userGroupId); ?>" <?php print($strSelected); ?>><?php print(htmlentities($objUserGroupInfo->userGroupName)); ?></option>
                                <?php }
                                } ?>
                            </select>

                            <label class="my-1 mr-2 ml-4">Status</label>
                            <select class="custom-select my-1 select2" name="status" onchange="javascript: this.form.submit();">
                                <option value="">All</option>
                                <?php

                                foreach ($arrStatus as $flKey => $strValue) {
                                    $strSelected = "";
                                    if ($flKey == $userStatus) {
                                        $strSelected = "selected";
                                    }
                                ?>
                                    <option value="<?php print($flKey); ?>" <?php print($strSelected); ?>><?php print(htmlentities($strValue)); ?></option>
                                <?php } ?>
                            </select>

                            <label class="my-1 mr-2 ml-4">Date</label>
                            <div class="float-right">
                                <div class="form-inline">
                                    <div class="input-daterange input-group" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-autoclose="true">
                                        <input type="text" class="form-control text-left" placeholder="From" name="datefrom" value="<?php print($fltrDateFrom); ?>" />
                                        <input type="text" class="form-control text-left" placeholder="To" name="dateto" value="<?php print($fltrDateTo); ?>" />
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">Go</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php $create = $this->Common_model->get_moduleId($this->router->fetch_class(), 'create');
                     if (in_array($create->module_id, $this->session->permission)) { ?>
                        <a href="<?php print(base_url()); ?>admin/users/create" class="btn btn-success waves-effect waves-light mb-3">Add User</a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive mb-4">
                    <table class="table table-centered dt-responsive datatable nowrap table-card-list" id="example1" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th class="all">Created Date</th>
                                <th class="all">Name</th>
                                <th class="all">Email Id</th>
                                <th class="all">Phone No</th>
                                <th class="all">Username</th>
                                <th class="all">User Group</th>
                                <th class="all">Status</th>

                                <th class="all" style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>