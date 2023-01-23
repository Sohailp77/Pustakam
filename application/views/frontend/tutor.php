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
    background-color: #c95656;
    text-decoration: none;
    color: #000;
}
ins{
    background-color: #74d974;
    text-decoration: none;
    color: #000;
}
audio::-webkit-media-controls-panel{
background-color: rgba(200,200,200,1);
width: 100%;
}

#results {
    font-size: 14px;
    /*font-weight: bold;*/
    /*border: 1px solid #ddd;*/
    /*padding: 15px;*/
    text-align: left;
    min-height: 50px;
    margin-top: 5px;
    margin-bottom: 5px;
}

h4{
    font-size: 18px;
}

.start_button {
    border: 0;
    background-color:transparent;
    padding: 0;
  }
  #info {
    font-size: 20px;
    text-align: center;
    color: #777;
    display: none;
  }
  .center {
    padding: 10px;
    text-align: center;
  }
  .final {
    font-size: 16px;
    color: #777;
    padding-right: 3px;
    font-weight: 400;
  }
  .interim {
    color: gray;
  }
  .info {
    font-size: 14px;
    text-align: center;
    color: #777;
    display: none;
  }
  .right {
    float: right;
  }
  .sidebyside {
    display: inline-block;
    width: 45%;
    min-height: 40px;
    text-align: left;
    vertical-align: top;
  }
  #headline {
    font-size: 40px;
    font-weight: 300;
  }
  .button {
    background: -webkit-linear-gradient(top,#008dfd 0,#0370ea 100%);
    border: 1px solid #076bd2;
    border-radius: 3px;
    color: #fff;
    display: none;
    font-size: 13px;
    font-weight: bold;
    line-height: 1.3;
    padding: 8px 25px;
    text-align: center;
    text-shadow: 1px 1px 1px #076bd2;
    letter-spacing: normal;
  }
</style>
<!-- 
<link rel="stylesheet" href="<?=base_url()?>assets/styles.css"/> -->




<!--Start Experience area-->
<section class="experience-area about-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <a href="<?=base_url()?>audio-tutor/1">Passage 1</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?=base_url()?>audio-tutor/2">Passage 2</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?=base_url()?>audio-tutor/3">Passage 3</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <br/>
                <br/>
                <div class="life-coacher-box">
                    <div class="inner-content">
                        <div class="top-text thm-clr">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12" style="align-self: center;">
                                    <h3>Passage <?=$type?></h3>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                    <audio  style="width:100%;background-color:#C8C8C8;" id="audiofile" src="<?=base_url()?>uploads/tutor/<?=$audio?>" controls=""></audio>
                                </div>
                            </div>
                            <br/>
                            <?=$passage?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <h3>Test Your Ability</h3><br/>
                <div id="info">
                  <p id="info_start">Click on the microphone icon and begin speaking.</p>
                  <p id="info_speak_now">Speak now.</p>
                  <p id="info_no_speech">No speech was detected. You may need to adjust your
                    <a href="//support.google.com/chrome/bin/answer.py?hl=en&amp;answer=1407892">
                      microphone settings</a>.</p>
                  <p id="info_no_microphone" style="display:none">
                    No microphone was found. Ensure that a microphone is installed and that
                    <a href="//support.google.com/chrome/bin/answer.py?hl=en&amp;answer=1407892">
                    microphone settings</a> are configured correctly.</p>
                  <p id="info_allow">Click the "Allow" button above to enable your microphone.</p>
                  <p id="info_denied">Permission to use microphone was denied.</p>
                  <p id="info_blocked">Permission to use microphone is blocked. To change,
                    go to chrome://settings/contentExceptions#media-stream</p>
                  <p id="info_upgrade">Web Speech API is not supported by this browser.
                     Upgrade to <a href="//www.google.com/chrome">Chrome</a>
                     version 25 or later.</p>
                </div>
                <?php
                $i=1;
                foreach($passage_arr as $text)
                {
                    ?>
                    <div class="row" style="border-bottom:1px solid #000;margin-bottom: 5px; padding: 5px;">
                        <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12" style="align-self: center;">
                            <h4 style="padding-bottom:10px">Passage Text</h4>
                            <span id="original<?=$i?>"><?=$text?></span>
                            <h4 style="padding-top:10px; padding-bottom:10px;">Recorded Audio</h4>
                            <div id="results<?=$i?>">
                              <span id="final_span<?=$i?>" class="final">Recorded Text displayed here....</span>
                              <span id="interim_span<?=$i?>" class="interim"></span>
                            </div>
                            <h4 style="padding-top:10px; padding-bottom:10px;">Result</h4>
                            <span id="result<?=$i?>" style="padding-bottom:10px;">Result Appeared Here....</span>
                        </div>
                        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12" style="align-self: center;">
                            <button  id="start_button<?=$i?>" class="start_button" onclick="startButton<?=$i?>(event)">
                                <img id="start_img<?=$i?>" src="<?=base_url()?>/assets/mic.gif" alt="Start">
                            </button>
                        </div>
                    </div>
                    <script>

                        showInfo<?=$i?>('info_start');

                        var final_transcript<?=$i?> = '';
                        var recognizing<?=$i?> = false;
                        var ignore_onend<?=$i?>;
                        var start_timestamp<?=$i?>;
                        if (!('webkitSpeechRecognition' in window)) {
                          upgrade();
                        } else {
                          start_button<?=$i?>.style.display = 'inline-block';
                          var recognition<?=$i?> = new webkitSpeechRecognition();
                          recognition<?=$i?>.continuous = true;
                          recognition<?=$i?>.interimResults = true;

                          recognition<?=$i?>.onstart = function() {
                            recognizing<?=$i?> = true;
                            showInfo<?=$i?>('info_speak_now');
                            start_img<?=$i?>.src = '<?=base_url()?>assets/mic-animate.gif';
                          };

                          recognition<?=$i?>.onerror = function(event) {
                            if (event.error == 'no-speech') {
                              start_img<?=$i?>.src = '<?=base_url()?>assets/mic.gif';
                              showInfo<?=$i?>('info_no_speech');
                              ignore_onend<?=$i?> = true;
                            }
                            if (event.error == 'audio-capture') {
                              start_img<?=$i?>.src = '<?=base_url()?>assets/mic.gif';
                              showInfo<?=$i?>('info_no_microphone');
                              ignore_onend<?=$i?> = true;
                            }
                            if (event.error == 'not-allowed') {
                              if (event.timeStamp - start_timestamp < 100) {
                                showInfo<?=$i?>('info_blocked');
                              } else {
                                showInfo<?=$i?>('info_denied');
                              }
                              ignore_onend<?=$i?> = true;
                            }
                          };

                          recognition<?=$i?>.onend = function() {
                            recognizing<?=$i?> = false;
                            if (ignore_onend<?=$i?>) {
                              return;
                            }
                            start_img<?=$i?>.src = '<?=base_url()?>assets/mic.gif';
                            if (!final_transcript<?=$i?>) {
                              showInfo<?=$i?>('info_start');
                              return;
                            }
                            showInfo<?=$i?>('');
                            if (window.getSelection) {
                              window.getSelection().removeAllRanges();
                              var range = document.createRange();
                              range.selectNode(document.getElementById('final_span<?=$i?>'));
                              window.getSelection().addRange(range);
                            }
                          };

                          recognition<?=$i?>.onresult = function(event) {
                            var interim_transcript<?=$i?> = '';
                            for (var i = event.resultIndex; i < event.results.length; ++i) {
                              if (event.results[i].isFinal) {
                                final_transcript<?=$i?> += event.results[i][0].transcript;
                              } else {
                                interim_transcript<?=$i?> += event.results[i][0].transcript;
                              }
                            }
                            final_transcript<?=$i?> = capitalize<?=$i?>(final_transcript<?=$i?>);
                            final_span<?=$i?>.innerHTML = linebreak<?=$i?>(final_transcript<?=$i?>);
                            interim_span<?=$i?>.innerHTML = linebreak<?=$i?>(interim_transcript<?=$i?>);
                          };
                        }

                        function upgrade() {
                          start_button<?=$i?>.style.visibility = 'hidden';
                          showInfo<?=$i?>('info_upgrade');
                        }

                        var two_line = /\n\n/g;
                        var one_line = /\n/g;
                        function linebreak<?=$i?>(s) {
                          return s.replace(two_line, '<p></p>').replace(one_line, '<br>');
                        }

                        var first_char = /\S/;
                        function capitalize<?=$i?>(s) {
                          return s.replace(first_char, function(m) { return m.toUpperCase(); });
                        }


                        function startButton<?=$i?>(event) {
                          if (recognizing<?=$i?>) {
                            recognition<?=$i?>.stop();
                            checkDiff<?=$i?>();
                            return;
                          }
                          final_transcript<?=$i?> = '';
                          recognition<?=$i?>.lang = 'en-IN';
                          recognition<?=$i?>.start();
                          ignore_onend<?=$i?> = false;
                          final_span<?=$i?>.innerHTML = '';
                          interim_span<?=$i?>.innerHTML = '';
                          start_img<?=$i?>.src = '<?=base_url()?>assets/mic-slash.gif';
                          showInfo<?=$i?>('info_allow');
                          start_timestamp<?=$i?> = event.timeStamp;
                        }

                        function showInfo<?=$i?>(s) {
                          if (s) {
                            for (var child = info.firstChild; child; child = child.nextSibling) {
                              if (child.style) {
                                child.style.display = child.id == s ? 'inline' : 'none';
                              }
                            }
                            info.style.display = 'block';
                          } else {
                            info.style.display = 'none';
                          }
                        }

                        function checkDiff<?=$i?>()
                        {
                            var original = $('#original<?=$i?>').html();
                            var record = $('#final_span<?=$i?>').text();
                            
                            if(record == null)
                            {
                              record = $('#interim_span<?=$i?>').html();
                            }

                            // alert('checkDiff<?=$i?>');

                            // alert('final_span<?=$i?>');
                            // alert(record);

                            // alert(final_transcript<?=$i?>);

                            $.ajax({
                              url: '<?=site_url();?>home/checkDiff/',
                              type: 'post',
                              data: {
                                  original: original,
                                  record: record,
                              },   
                              dataType: 'json',
                              success: function(data) {
                                  $("#result<?=$i?>").empty();
                                  $("#result<?=$i?>").html(data.diff);
                              },
                              error:function(e){
                                  alert("error ");
                              },
                          });

                        }

                        </script>
                    <?php
                    $i++;
                }
                ?>
            </div>


        </div>
    </div>
</section>
<!--End Experience area-->

<!-- <script src="<?=base_url()?>assets/app.js"></script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<!-- <script src="<?=base_url()?>assets/script.js"></script> -->
