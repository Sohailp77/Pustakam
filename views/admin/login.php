
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <a href="<?php print(site_url()); ?>" class="mb-2 d-block auth-logo"><h1>audioPustakam</h1></a>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-body p-4"> 
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Welcome Back !</h5>
                            <p class="text-muted">Sign in to continue to audioPustakam admin.</p>
                        </div>
                        
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
                            <form action="<?php print(site_url('admin')); ?>" name="frmLogin" method="POST">

                                <div class="form-group">
                                    <label for="txtUserName">Username</label>
                                    <input type="text" class="form-control" id="txtUserName" placeholder="Enter username" name="txtUserName">
                                    <?php print(form_error('txtUserName')); ?>
                                </div>
        
                                <div class="form-group">
                                    <?php /*<div class="float-right">
                                        <a href="<?php print(site_url('forgot_password')); ?>" class="text-muted">Forgot password?</a>
                                    </div> */ ?>
                                    <label for="txtPassword">Password</label>
                                    <input type="password" class="form-control" id="txtPassword" placeholder="Enter password" name="txtPassword">
                                    <?php print(form_error('txtPassword')); ?>
                                </div>
        
                                <!-- <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="auth-remember-check">
                                    <label class="custom-control-label" for="auth-remember-check">Remember me</label>
                                </div> -->
                                
                                <div class="mt-3 text-right">
                                    <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </form>
                        </div>
    
                    </div>
                </div>

                <!-- <div class="mt-5 text-center">
                    <p>© 2020 Minible. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                </div> -->

            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
