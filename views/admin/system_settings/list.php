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
            <div class="col-md-4">
                <div>
                    <a href="<?php print(base_url()); ?>admin/system_settings/create" class="btn btn-success waves-effect waves-light mb-3"> Add System Variable</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive mb-4">
                    <table class="table table-centered datatable dt-responsive text-wrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th class="all text-nowrap">Code</th>
                                <th class="all text-nowrap">Name</th>
                                <th class="all text-wrap">Value</th>
                                <th class="all text-nowrap" style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody><?php

                            if($objSystemSettings){

                                foreach($objSystemSettings as $objSystemSettingInfo){
                                    ?><tr>
                                        <td class="text-nowrap"><?php print(htmlentities($objSystemSettingInfo->systemCode)); ?></td>
                                        <td class="text-nowrap"><?php print(htmlentities($objSystemSettingInfo->systemName)); ?></td><?php

                                        
                                            ?><td class="text-wrap"><?php print(htmlentities($objSystemSettingInfo->systemValue)); ?></td>
                                            <td class="text-nowrap">
                                            <a href="<?= site_url('admin/system_settings/update/' . $objSystemSettingInfo->systemId) ?>" class="px-3 text-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="uil uil-pen font-size-18"></i></a>
                                            
                                            <a href="<?= site_url('admin/system_settings/delete/' . $objSystemSettingInfo->systemId) ?>" onclick="javascript: return confirm('Are you sure?')" class="px-3 text-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="uil uil-trash-alt font-size-18"></i></a>
                                        </td>
                                    </tr><?php
                                }
                            }
                            else{
                                ?><tr>
                                    <td colspan="4" align="center"><?php print("No data found"); ?></td>
                                </tr><?php
                            }

                        ?></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>