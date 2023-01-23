<style type="text/css">
    .life-coacher-box .inner-content .top-text p {
    font-size: 14px;
    font-weight: 100;
    margin: 0;
    text-align: justify;
    line-height: 30px;
    color: #000;
}
#display{
    width: 100%;
}

#controllers{
    width: 100%;
}

button{
    padding: 15px;
    margin: 10px;
    border: 1px solid;
    background-color: #c5004d;
    color: #ffffff;
    font-size: 14px;
    line-height: 14px;
    font-weight: 600;
}

button:hover{
    cursor: pointer;
}
</style>

<link rel="stylesheet" href="<?=base_url()?>assets/styles.css"/>



<!--Start Experience area-->
<section class="experience-area about-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                <div class="life-coacher-box">
                    <div class="inner-content">
                        <div class="top-text thm-clr">
                            <p>
                                Experts in climatology and other scientists are becoming extremely concerned about the changes to our climate which are taking place. Admittedly, climate changes have occurred on our planet before. For example, there have been several ice ages or glacial periods.</p>
                                <p>
These climatic changes, however, were different from the modern ones in that they occurred gradually and, as far as we know, naturally. The changes currently being monitored are said to be the result not of natural causes, but of human activity. Furthermore, the rate of change is becoming alarmingly rapid.</p>
<p>
The major problem is that the planet appears to be warming up. According to some experts, this warming process, known as global warming, is occurring at a rate unprecedented in the last 10,000 years. The implications for the planet are very serious. Rising global temperatures could give rise to such ecological disasters as extremely high increases in the incidence of flooding and of droughts. These in turn could have a harmful effect on agriculture.</p>
<p>It is thought that this unusual warming of the Earth has been caused by so-called greenhouse gases, such as carbon dioxide, being emitted into the atmosphere by car engines and modem industrial processes, for example. Such gases not only add to the pollution of the atmosphere, but also create a greenhouse effect, by which the heat of the sun is trapped. This leads to the warming up of the planet.

                            </p>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <audio style="width:100%;" id="audiofile" src="<?=base_url()?>uploads/tutor/Passage 1.mp3" controls=""></audio>
                <br/>
                <br/>
                <br/>
                <div id="display"></div>
                <div id="controllers"></div>  
                <button id="convert" onclick="checkAudio()">Convert Audio</button>   
            </div>
           
        </div>
    </div>
</section>
<!--End Experience area-->

<script src="<?=base_url()?>assets/app.js"></script>