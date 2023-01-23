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
                                        <h5 class="font-size-16 mb-1">Payment Info</h5>
                                        <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                    </div>
                                </div>
                            </div>

                            <div id="addproduct-billinginfo-collapse" class="collapse show" data-parent="#addproduct-accordion">
                                <div class="p-4 border-top">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="customer">Enter Customer</label>
                                                <select id="selGroup0" name="customer" class="custom-select my-1 select2">
                                                    <option value="">-- Please Select --</option>
                                                    <?php
                                                    foreach($arrUser as $user)
                                                    {
                                                        ?>
                                                        <option value="<?=$user->email?>" <?php if($user->email == $customer) echo 'selected';?>><?=$user->name?>-<?=$user->email?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php print(form_error('state')); ?>
                                            </div>
                                        </div>
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
                                                <select id="selGroup2" name="classname" class="custom-select my-1 select2">
                                                    <option value="">-- Please Select --</option>
                                                    <?php
                                                    foreach($arrClass as $cl)
                                                    {
                                                        ?>
                                                        <option value="<?=$cl->cid?>" <?php if($cl->cid == $classname) echo 'selected';?>><?=$cl->classname?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php print(form_error('class')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="amount">Enter Amount</label>
                                                <input id="amount" name="amount" type="text" placeholder="Enter Amount" class="form-control" value="<?php print($amount); ?>" maxlength="255">
                                                <?php print(form_error('amount')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="payment_date">Enter Payment Date <?php print($payment_date); ?></label>
                                                <input id="payment_date" name="payment_date" type="date" placeholder="Enter Payment Date" class="form-control" value="<?php print($payment_date); ?>" maxlength="255">
                                                <?php print(form_error('payment_date')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="expire_date">Enter Expire Date <?php print($expire_date); ?></label>
                                                <input id="expire_date" name="expire_date" type="date" placeholder="Enter Expire Date" class="form-control" value="<?php print($expire_date); ?>" maxlength="255">
                                                <?php print(form_error('expire_date')); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="transaction_id">Enter Transaction ID</label>
                                                <input id="transaction_id" name="transaction_id" type="text" placeholder="Enter Transaction ID" class="form-control" value="<?php print($transaction_id); ?>" maxlength="255">
                                                <?php print(form_error('transaction_id')); ?>
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
                    <input type="hidden" name="pid" value="<?= $pid; ?>">
                    <a href="<?php print(site_url('admin/payment')); ?>" class="btn btn-danger"> <i class="uil uil-times mr-1"></i> Cancel </a>
                    <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt mr-1"></i> Save </button>
                </div> <!-- end col -->
            </div> <!-- end row-->
        </form>

    </div> <!-- container-fluid -->
</div>