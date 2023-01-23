<!--Start coach single area-->
<section class="coach-single-area all-courses-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec-title">
                        <div class="title"><?=$state->language?></div>
                        <div class="dector"> </div>
                    </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <p>Text books used here is from <a href="https://scert.goa.gov.in/" target="_blank">SCERT GOA</a></p>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-9 col-sm-12 pull-right">
                <div class="left-sidebar">
                    <!--Start single sidebar-->
                    <div class="single-sidebar">
                        <div class="service-list-box">
                            <div class="title">
                                <h3>STANDARD</h3>
                            </div>                        
                            <ul class="page-links">
                                <?php
                                $i=1;
                                foreach($class as $cl)
                                {
                                    if($cl->cid==$cid)
                                    {
                                        ?>
                                        <li><a class="active"  href="<?=base_url()?>standard/<?=$mid?>/<?=$cl->cid?>"><?=$cl->classname?></a></li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li><a href="<?=base_url()?>standard/<?=$mid?>/<?=$cl->cid?>"><?=$cl->classname?></a></li>
                                        <?php
                                    }
                                    $i++;
                                }
                                ?>                                
                            </ul>
                        </div>
                    </div>
                    <!--End single sidebar-->
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 pull-left">
                <div class="courses-content">
                    <div class="row">
                        <!--Start single courses item-->
                        <?php
                        foreach($chapter as $cpt)
                        {
                        ?>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                            <div class="single-courses-item">
                                <div class="img-holder">
                                    <img src="<?=base_url()?>uploads/images/<?=$cpt->image_file?>" alt="Awesome Image"> 
                                    <div class="overlay-style-one">
                                        <div class="box">
                                            <?php
                                            if($cpt->payment=="Y")
                                            {   
                                                if(!empty($payment_data))
                                                {
                                                    ?>
                                                    <div class="content">
                                                        <a href="<?=base_url()?>chapter/<?=$cpt->cid?>"><i class="fa fa-link" aria-hidden="true"></i></a>
                                                    </div>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <div class="content">
                                                        <a href="" data-toggle="modal" data-target="#myModal"><i class="fa fa-spinner" aria-hidden="true"></i></a>
                                                    </div>
                                                    <?php   
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <div class="content">
                                                    <a href="<?=base_url()?>chapter/<?=$cpt->cid?>"><i class="fa fa-link" aria-hidden="true"></i></a>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            
                                        </div>
                                    </div>   
                                </div>
                                <div class="text-holder">
                                    <h4><a href="courses-single.html">Chapter- <?=$cpt->chapter?></a></h4>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </div>   
               
        </div> 
    </div>    
</section>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title">Note</p>        
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body">
        <p>1.First you need to <a href="<?=base_url()?>account">Login</a></p>
        <p>2.Send a mail to <a href="mailto:admin@audiopustakam.com">admin@audiopustakam.com</a> to purchase a class</p>
        <p>3.If you successfully complete the purchase you have to use the audios</p>
      </div>
    </div>

  </div>
</div>
<!--End coach single area-->