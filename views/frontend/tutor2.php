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

del{
    background-color: #ffcccc;
    text-decoration: none;
}
ins{
    background-color: #ccffcc;
    text-decoration: none;
}
</style>
<!-- 
<link rel="stylesheet" href="<?=base_url()?>assets/styles.css"/> -->




<!--Start Experience area-->
<section class="experience-area about-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                <a href="<?=base_url()?>audio-tutor/1">Passage 1</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?=base_url()?>audio-tutor/2">Passage 2</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?=base_url()?>audio-tutor/3">Passage 3</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <br/>
                <br/>
                <div class="life-coacher-box">
                    <div class="inner-content">
                        <div class="top-text thm-clr">
                            <h3>Passage <?=$type?></h3><br/>
                            <?=$passage?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <audio style="width:100%;" id="audiofile" src="<?=base_url()?>uploads/tutor/<?=$audio?>" controls=""></audio>
                <br/>
                <br/>
                <br/>
                <button id="start-record-btn" title="Start Record" class="btn btn-primary btn-block">Start Record</button>
                <button id="pause-record-btn" title="Stop Record" class="btn btn-danger btn-block" style="display:none;">Stop Record</button>
                <form method="post" action="<?=base_url()?>home/checkAudio">
                <button id="check-record-btn" title="Stop Record" class="btn btn-danger btn-block" style="display:none;">Check Recorded Audio</button>
                <input type="hidden" name="type" value="<?=$type?>">
                <textarea id="note-textarea" name="note" placeholder="Create a new note by typing or using voice recognition." rows="6" ><?=$note?></textarea>  
                </form>
            </div>
            <?php
            if(isset($diffline))
            {
            ?>
            <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <table class="table table-bordered">
                    <tr align=center>
                        <td>old</td>
                        <td>new</td>
                        <td>similarity</td>
                    </tr>
                    <tr>
                        <td style="text-align: justify; width: 33%;"><?=$old?></td>
                        <td style="text-align: justify; width: 33%"><?=$new?></td>
                        <td style="text-align: justify; width: 33%;"><?=$similarity?></td>
                    </tr>
                </table>
            </div> -->
            <?=$diffline?>
            <?php
            }
            ?>


        </div>
    </div>
</section>
<!--End Experience area-->

<!-- <script src="<?=base_url()?>assets/app.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?=base_url()?>assets/script.js"></script>