<section class="contact-info-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12">
                <div class="contact-form">
                    <div class="sec-title">
                        <div class="title bold">Drop Your Message Here</div>
                        <div class="dector"></div>
                        <span>Want to get in touch? We'd love to hear from you. Here's how you can reach us...</span>
                    </div>
                    <form action="<?=base_url('home/contact_action')?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="form_name" value="" placeholder="Your Name*" required="">
                                <input type="email" name="form_email" value="" placeholder="Your Mail*" required="">
                                <input type="text" name="form_subject" value="" placeholder="Subject">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="form_phone" value="" placeholder="Phone" required="">
                                <textarea name="form_message" placeholder="Your Message.." required=""></textarea>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                <button class="btn-one thm-bg-clr" type="submit" data-loading-text="Please wait...">Submit Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-7 col-sm-12">
                <div class="contact-box-content">
                    <div class="contact-info-box-one">
                        <div class="contact-box1-carousel owl-carousel owl-theme">
                            <!--Start single item-->
                            <div class="single-item">
                                <!-- <div class="top-info">
                                    <div class="img-holder">
                                        <img src="<?=base_url()?>assets/images/resources/p3.png" alt="Awesome Image">
                                    </div>
                                    <div class="text-holder">
                                        <h3>Mrs. Annie Rajan</h3>
                                        <b class="thm-clr">Associate Professor</b>
                                        <a href="mailto:ann_raj_2000@yahoo.com" target="new">
                                            <span class="flaticon-dark"></span>ann_raj_2000@yahoo.com
                                        </a>
                                    </div>
                                </div> -->
                                <ul>
                                    <!-- <li>
                                        <div class="icon-box">
                                            <span class="flaticon-signs-1 thm-clr"></span>
                                        </div>
                                        <div class="text-box">
                                            <p><span>Address:</span> Ruby Apartment, Near Shenvi School,<br/>M.E.S. Ravanfond<br/>Navelim P.O. Margao,  <br>Goa Pin 403 707.</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon-box">
                                            <span class="flaticon-technology thm-clr"></span>
                                        </div>
                                        <div class="text-box">
                                            <p><span>Call Us:</span><br> +91 883-099-8242</p>
                                        </div>
                                    </li> -->
                                    <li style="padding-left: 0px;">
                                        <p align="justify">Join us for our audioPustakam and make a direct donation now so we can continue our work toward </p>
                                        <button class="btn btn-primary btn-block" type="button">Contact Administrator for Donate</button>
                                        <p align="justify" style="margin-top: 10px;">Your donation will make a difference</p>
                                    </li>
                                    <li>
                                        <div class="icon-box">
                                            <span class="flaticon-dark thm-clr"></span>
                                        </div>
                                        <div class="text-box">
                                            <p><span>Mail Us:</span> admin@audiopustakam.com</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--End single item-->
                        </div>   
                    </div>    
                </div>    
            </div>
            
        </div>
    </div>
</section>
<!--End contact form area-->

<!--Start google map area-->
<!-- <section class="google-map-area">
    <div class="google-map-box">
        <div 
            class="google-map" 
            id="contact-google-map" 
            data-map-lat="44.922124" 
            data-map-lng="-93.327770" 
            data-icon-path="images/resources/map-marker-2.png" 
            data-map-title="Brooklyn, New York, United Kingdom" 
            data-map-zoom="12" 
            data-markers='{
                "marker-1": [44.922124, -93.327770, "<h4>Head Office</h4><p>44/108 Brooklyn, UK</p>"]
    
            }'>
        </div>
    </div>     
</section> -->
<!--End google map area