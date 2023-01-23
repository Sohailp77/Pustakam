<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php print(htmlentities($pageTitle)); ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <?php foreach ($arrParentPage as $parentPage => $strUrl) { ?>
                                <li class="breadcrumb-item">
                                    <?php if (!empty($strUrl)) { ?>
                                        <a href="<?php print($strUrl); ?>"><?php print(htmlentities($parentPage)); ?></a>
                                    <?php } else {
                                        print(htmlentities($parentPage)); ?>
                                </li>
                            <?php } ?>
                            <li class="breadcrumb-item active"><?php print(htmlentities($pageTitle)); ?></li>
                        <?php } ?>
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
                <form id="form-list" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
                    <div class="table-responsive mb-4">
                        <table class="table table-centered dt-responsive nowrap table-card-list" id="example1" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Module </th>
                                    <th>View</th>
                                    <th>Add </th>
                                    <th>Edit</th>
                                    <th>Delete </th>
                                </tr>
                                <?php
                                foreach ($objParentModules as $module) {
                                ?>
                                    <tr>
                                        <td><?= $module->title ?></td>
                                        <?php
                                        $add = "";
                                        $view = "";
                                        $delete = "";
                                        $edit = "";
                                        $print="";
                                        foreach ($objSubModules as $objSubModuleInfo) {
                                            if ($objSubModuleInfo->parent_module_id == $module->module_id) {

                                                if ($objSubModuleInfo->action_type == "VW") {
                                                    $view = "checked";
                                                } else  if ($objSubModuleInfo->action_type == "AD") {
                                                    $add = "checked";
                                                } else  if ($objSubModuleInfo->action_type == "ED") {
                                                    $edit = "checked";
                                                } else  if ($objSubModuleInfo->action_type == "DL") {
                                                    $delete = "checked";
                                                }
                                            }
                                        }

                                        ?>
                                        <?php $Submodules = $this->Common_model->getSubModules($module->module_id); ?>
                                        <td>
                                            <?php if (in_array('VW', $Submodules)) { ?>
                                                <div class="checkbox checkbox-inline ">

                                                    <input type="checkbox" class="checked_status" id="inlineCheckbox1" value="chk_view_<?= $module->module_id ?>" name="chk_view_<?= $module->module_id ?>" <?= $view ?>>
                                                    <label for="chk_view_<?= $module->module_id ?>"> </label>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if (in_array('AD', $Submodules)) { ?>
                                                <div class="checkbox checkbox-inline">
                                                    <input type="checkbox" class="checked_status" id="inlineCheckbox2" value="chk_add_<?= $module->module_id ?>" name="chk_add_<?= $module->module_id ?>" <?= $add ?>>
                                                    <label for="chk_add_<?= $module->module_id ?>"> </label>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if (in_array('ED', $Submodules)) { ?>
                                                <div class="checkbox checkbox-inline">
                                                    <input type="checkbox" class="checked_status" id="inlineCheckbox3" value="chk_edit_<?= $module->module_id ?>" name="chk_edit_<?= $module->module_id ?>" <?= $edit ?>>
                                                    <label for="chk_edit_<?= $module->module_id ?>"> </label>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if (in_array('DL', $Submodules)) { ?>
                                                <div class="checkbox checkbox-inline">
                                                    <input type="checkbox" class="checked_status" id="inlineCheckbox4" value="chk_delete_<?= $module->module_id ?>" name="chk_delete_<?= $module->module_id ?>" <?= $delete ?>>
                                                    <label for="chk_delete_<?= $module->module_id ?>"> </label>
                                                </div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </thead>
                        </table>
                        <div class="row mb-4">
                            <div class="col text-right">
                                <input type="hidden" name="groupId" value="<?= $groupId; ?>">
                                <a href="<?php print(site_url('admin/user_groups')); ?>" class="btn btn-danger"> <i class="uil uil-times mr-1"></i> Cancel </a>
                                <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt mr-1"></i> Save </button>
                            </div> <!-- end col -->
                        </div> <!-- end row-->
                    </div>
                </form>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>