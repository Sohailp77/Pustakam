
    
<!--Start call To action area-->
<!-- <section class="call-toaction-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="title-holder">
                    <h1>Audio Text Books for Indian <br/><span>Regional Language</span> </h1>
                    <div class="border-right"></div>   
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="text-holder">
                    <p>There are textbooks for standard I - X for languages</p>   
                </div>
            </div>
        </div>
    </div>    
</section> -->
<!--End call To action area-->

<section class="experience-area about-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-11 col-md-11 col-sm-12">
                <map name="picture">
                    <?php
                    foreach($map_coords as $coord)
                    {
                        ?>
                        <area class="state" target="" alt="<?=$coord->state?>" title="<?=$coord->state?>" href="#" coords="<?=$coord->coords?>" shape="poly" data-mid="<?=$coord->mid?>">
                        <?php
                    }
                    ?>
                    </map>
                    <img src = "<?=base_url()?>assets/images/resources/map.png" alt = "India" usemap = "#picture"> 
            </div>
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                <div class="mission-vision-content">
                    <div class="row">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            
                               <!--  <p style="text-align: justify;">Indian languages, languages spoken in the state of India, generally classified as belonging to the following families: Indo-European (the Indo-Iranian branch in particular), Dravidian, Austroasiatic (Munda in particular), and Sino-Tibetan (Tibeto-Burman in particular).</p> -->
                               <h4 style="padding-bottom: 20px;">Audio Text Books for Indian Regional Language</h4>
                               <p align="justify">Learning is more live and effective in classrooms supported by learning resources. Audio textbook in regional language will help students learn and grasp nontrivial concepts more quickly in their home language/mother tongue. </p>   
                            <div  id="state_div">    
                                
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <section class="choosing-area">
    <div class="container">
        <div class="sec-title">
            <div class="title clr-white">Our Solution</div>

            <div class="dector bg-white"></div>
        </div>
        <div class="row">

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="single-choosing-item text-center">
                    <div class="icon-holder">
                        <span class="flaticon-language"></span>
                    </div>
                    <div class="text-holder">
                        <h3>High-quality, human-read audiobooks</h3>
                        <p style="text-align: justify;">With an extensive library of high quality, human-read audiobooks, student-centric features and a suite of teacher resources, our solution provides equitable access to your curriculum in a format struggling readers can easily absorb, allowing them to achieve their academic potential.</p>
                                
                    </div>
                </div>
            </div>


            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="single-choosing-item text-center">
                    <div class="icon-holder">
                        <span class="flaticon-paper"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Affordable and Educator-Friendly</h3>
                        <p style="text-align: justify;">The audioPustakam Audiobook Solution was designed with teachers in mind. Customized launch plans make it easy to get up and running. Student engagement programs keep learning interesting and fun. And our progress dashboard makes it simple to track student progress.<br/><br/></p>     
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="single-choosing-item text-center">
                    <div class="icon-holder">
                        <span class="flaticon-people-4"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Ongoing professional learning</h3>
                        <p style="text-align: justify;">audioPustakam offers a wide variety of professional learning options, including ongoing training and support, to help teachers and administrators utilize our audiobook solution with fidelity.<br/><br/></p>     
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="single-choosing-item text-center">
                    <div class="icon-holder">
                        <span class="flaticon-computer"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Easy implementation</h3>
                        <p style="text-align: justify;">Designed as a supplemental solution, the audioPustakam Audiobook Solution easily snaps into your existing curriculum or intervention programs. A step-by-step guide and easy-to-access tech support ensure a seamless integration.</p>     
                    </div>
                </div>
            </div>

        </div>
    </div>    
</section> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?=base_url()?>assets/image-map.jquery.js"></script>
<script src="<?=base_url()?>assets/image-map.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var mid=Math.floor(Math.random() * (28 + 1));
        state(mid);
    });
    $(".state").on('click', function(event){
        var mid=$(this).attr("data-mid");
        state(mid);
    });

    function state(mid)
    {
        $.ajax({
            url: '<?=base_url();?>state/',
            type: 'post',
            data: {
                mid: mid,
            },
            dataType: 'json',
            success: function(data) {
                $('#state_div').empty();
                $('#state_div').append(data.product_html);
            },
        });
    }
</script>

<script>

    /* jQuery */
    $('img[usemap]').imageMap(500);
</script>