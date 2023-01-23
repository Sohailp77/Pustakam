
<!--Start login register area-->
<section class="login-register-area">
    <div class="container">
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
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                <div class="form register">
                    <div class="title">
                        <h3>Register Here</h3>
                    </div>
                    <div class="row">
                        <form action="<?=base_url()?>register" method="post">
                            <div class="col-md-12">
                                <?=form_error('name')?> 
                                <div class="input-field">
                                    <input type="text" name="name" placeholder="Your Name *" value="<?=$name?>">
                                    <div class="icon-holder">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </div>
                                </div> 
                            </div> 
                            <div class="col-md-12">
                                <?=form_error('mobile')?> 
                                <div class="input-field">
                                    <input type="text" name="mobile" placeholder="Your Mobile Number *" value="<?=$mobile?>">
                                    <div class="icon-holder">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </div>
                                </div> 
                            </div> 
                            <div class="col-md-12">
                                <?=form_error('email')?>                                 
                                <div class="input-field"> 
                                    <input type="text" name="email" placeholder="Enter Mail id *" value="<?=$email?>">
                                    <div class="icon-holder">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </div>
                                </div>     
                            </div>
                            <div class="col-md-12">
                                <?=form_error('password')?>
                                <div class="input-field">
                                    <input type="password" name="password" placeholder="Enter Password" value="<?=$password?>">
                                    <div class="icon-holder">
                                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                    </div>
                                </div>       
                            </div>
                            <div class="col-md-12">
                                <?=form_error('confirm_password')?>
                                <div class="input-field"> 
                                    <input type="password" name="confirm_password" placeholder="Enter Confirm Password" value="<?=$confirm_password?>">
                                    <div class="icon-holder">
                                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                    </div>
                                </div>      
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-4 col-md-5 col-sm-12">
                                        <button class="btn-one thm-bg-clr" type="submit">Register Here</button>
                                    </div>
                                    <div class="col-lg-8 col-md-7 col-sm-12">
                                        <div class="right">
                                            <h6><span></span></h6>
                                        </div>
                                    </div>
                                </div>   
                            </div> 
                        </form>    
                    </div>
                </div>    
            </div>


            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                <div class="form">
                    <div class="title">
                        <h3>Login Now </h3>
                    </div>
                    <div class="row">
                        <form action="<?=base_url()?>login" method="post">
                            <div class="col-xl-12">
                                <?=form_error('login_mail')?>
                                <div class="input-field">
                                    <input type="text" name="login_mail" placeholder="Enter Mail id *" value="<?=$login_mail?>">
                                    <div class="icon-holder">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-xl-12">
                                <?=form_error('login_password')?>
                                <div class="input-field">
                                    <input type="password" name="login_password" placeholder="Enter Password" value="<?=$login_password?>">
                                    <div class="icon-holder">
                                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-sm-12">
                                        <button class="btn-one thm-bg-clr" type="submit">Login Now</button>
                                    </div>
                                    
                                </div>   
                            </div> 
                        </form>    
                    </div>
                </div>    
            </div>
            
            
        </div>
    </div>
</section>      
<!--End login register area-->
