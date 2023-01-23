
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <a href="<?php print(site_url()); ?>" class="mb-2 d-block auth-logo">
                        <h1>BEYOUTIK</h1>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-body p-4">                         
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

                        <div class="p-2 mt-4">
                            <form action="<?php print(current_url() . "?" . $_SERVER['QUERY_STRING']); ?>" name="frmLogin" method="POST">        
                                <div class="form-group">
                                    <label for="txtPassword">New Password</label>
                                    <input type="password" class="form-control" id="txtPassword" placeholder="Enter new password" name="txtPassword">
                                    <?php print(form_error('txtPassword')); ?>
                                </div>

                                <div class="form-group">
                                    <label for="txtConfirmPassword">Confirm New Password</label>
                                    <input type="password" class="form-control" id="txtConfirmPassword" placeholder="Enter password again" name="txtConfirmPassword">
                                    <?php print(form_error('txtConfirmPassword')); ?>
                                </div>
                                        
                                <div class="mt-3 text-right">
                                    <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Reset</button>
                                </div>
                            </form>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
