<style type="text/css">
.audio-player {
  height: 80px;
  width: 100%;
  background: #444;
  box-shadow: 0 0 20px 0 #000a;
  font-family: arial;
  color: white;
  font-size: 0.75em;
  overflow: hidden;
  display: grid;
  grid-template-rows: 6px auto;
}
.audio-player .timeline {
  background: white;
  width: 100%;
  position: relative;
  cursor: pointer;
  box-shadow: 0 2px 10px 0 #0008;
}
.audio-player .timeline .progress {
  background: coral;
  width: 0%;
  height: 100%;
  transition: 0.25s;
}
.audio-player .controls {
  display: flex;
  justify-content: space-between;
  align-items: stretch;
  padding: 0 20px;
}
.audio-player .controls > * {
  display: flex;
  justify-content: center;
  align-items: center;
}
.audio-player .controls .toggle-play.play {
  cursor: pointer;
  position: relative;
  left: 0;
  height: 0;
  width: 0;
  border: 7px solid #0000;
  border-left: 13px solid white;
}
.audio-player .controls .toggle-play.play:hover {
  transform: scale(1.1);
}
.audio-player .controls .toggle-play.pause {
  height: 15px;
  width: 20px;
  cursor: pointer;
  position: relative;
}
.audio-player .controls .toggle-play.pause:before {
  position: absolute;
  top: 0;
  left: 0px;
  background: white;
  content: "";
  height: 15px;
  width: 3px;
}
.audio-player .controls .toggle-play.pause:after {
  position: absolute;
  top: 0;
  right: 8px;
  background: white;
  content: "";
  height: 15px;
  width: 3px;
}
.audio-player .controls .toggle-play.pause:hover {
  transform: scale(1.1);
}
.audio-player .controls .time {
  display: flex;
}
.audio-player .controls .time > * {
  padding: 2px;
}
.audio-player .controls .volume-container {
  cursor: pointer;
  position: relative;
  z-index: 2;
}
.audio-player .controls .volume-container .volume-button {
  height: 26px;
  display: flex;
  align-items: center;
}
.audio-player .controls .volume-container .volume-button .volume {
  transform: scale(0.7);
}
.audio-player .controls .volume-container .volume-slider {
  position: absolute;
  left: -3px;
  top: 15px;
  z-index: -1;
  width: 0;
  height: 15px;
  background: white;
  box-shadow: 0 0 20px #000a;
  transition: 0.25s;
}
.audio-player .controls .volume-container .volume-slider .volume-percentage {
  background: coral;
  height: 100%;
  width: 75%;
}
.audio-player .controls .volume-container:hover .volume-slider {
  left: -123px;
  width: 120px;
}

</style>
<link rel="stylesheet" type="text/css" href="https://icono-49d6.kxcdn.com/icono.min.css">
<!--Start event Single area-->
<section class="event-single-area" style="padding-top: 30px;">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12">
                <div class="single-event-content">
                    <div class="img-holder" id="pdf_holder" style="height: 100%;">
                        <object
                        data='<?=base_url()?>uploads/pdf/<?=$chapter->text_file?>'
                        type="application/pdf"
                        width="100%"
                        height="700">
                        
                        <iframe
                          src='<?=base_url()?>uploads/pdf/<?=$chapter->text_file?>#toolbar=0&scrollbar=0'
                          width="100%"
                        height="700"
                        >
                        </iframe>
                    </object>
                    </div>
                                 
                    
                </div>
            </div>
            
            <div class="col-xl-4 col-lg-5 col-md-9 col-sm-12">
                <div class="event-single-sidebar" style="padding:0px">
                    <!--Start single sidebar box-->
                    <div class="single-sidebar-box">
                        <div class="event-timeline" style="padding:0px">
                            <div class="audio-player">
                              <div class="timeline">
                                <div class="progress"></div>
                              </div>
                              <div class="controls">
                                <div class="play-container">
                                  <div class="toggle-play play">
                                </div>
                                </div>
                                <div class="time">
                                  <div class="current">0:00</div>
                                  <div class="divider">/</div>
                                  <div class="length"></div>
                                </div>
                                <div class="name">
                                    <?php
                                    if($chapter->payment=='N')
                                    {
                                        echo "Chapter ".$chapter->chapter;
                                    }
                                    else
                                    {
                                        if(!empty($payment_data))
                                        {
                                            echo "Chapter ".$chapter->chapter;
                                        }
                                        else
                                        {
                                            echo "Paid File";
                                        }
                                    }
                                    ?> 
                                </div>

                                <div class="volume-container">
                                  <div class="volume-button">
                                    <div class="volume icono-volumeMedium"></div>
                                  </div>
                                  
                                  <div class="volume-slider">
                                    <div class="volume-percentage"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>     
                    </div>
                    <!--End single sidebar box-->

                    <!--Start single sidebar box-->
                    <div class="single-sidebar-box">
                        <div class="book-now">
                            <h3 class="title thm-bg-clr">Details</h3>
                            <div class="inner-content"> 
                                <ul>
                                    <li>
                                        <p>Language: <?=$chapter->language?></p>
                                    </li>
                                    <li>
                                        <p>Class: <?=$chapter->classname?></p>
                                    </li>
                                    <li>
                                        <p>Description: <?=$chapter->description?></p>
                                    </li>
                                    <li>
                                        <p>Payment: <?php 
                                        if($chapter->payment == "Y")
                                        {
                                            if(!empty($payment_data))
                                            {
                                                echo "Purchased";
                                            }
                                            else
                                            {
                                                echo "Paid";
                                            }
                                        }
                                        else
                                        {
                                            echo "Free";
                                        }
                                        ?></p>
                                    </li>
                                </ul>
                            </div>   
                        </div>     
                    </div>
                    <!--End single sidebar box-->
                </div>
            </div>
            
        </div>
    </div>
</section>
<!--End event Single area-->
<script type="text/javascript">
const audioPlayer = document.querySelector(".audio-player");
const audio = new Audio(
  "<?php
  if($chapter->payment=='N')
  {
    echo base_url()."uploads/audio/".$chapter->audio_file;
  }
  else
  {
    if(!empty($payment_data))
    {
        echo base_url()."uploads/audio/".$chapter->audio_file;
    }
    else
    {
        echo '';
    }
  }
  ?>"
);
//credit for song: Adrian kreativaweb@gmail.com

console.dir(audio);

audio.addEventListener(
  "loadeddata",
  () => {
    audioPlayer.querySelector(".time .length").textContent = getTimeCodeFromNum(
      audio.duration
    );
    audio.volume = 0.75;
  },
  false
);

//click on timeline to skip around
const timeline = audioPlayer.querySelector(".timeline");
timeline.addEventListener(
  "click",
  (e) => {
    const timelineWidth = window.getComputedStyle(timeline).width;
    const timeToSeek = (e.offsetX / parseInt(timelineWidth)) * audio.duration;
    audio.currentTime = timeToSeek;
  },
  false
);

//click volume slider to change volume
const volumeSlider = audioPlayer.querySelector(".controls .volume-slider");
volumeSlider.addEventListener(
  "click",
  (e) => {
    const sliderWidth = window.getComputedStyle(volumeSlider).width;
    const newVolume = e.offsetX / parseInt(sliderWidth);
    audio.volume = newVolume;
    audioPlayer.querySelector(".controls .volume-percentage").style.width =
      newVolume * 100 + "%";
  },
  false
);

//check audio percentage and update time accordingly
setInterval(() => {
  const progressBar = audioPlayer.querySelector(".progress");
  progressBar.style.width = (audio.currentTime / audio.duration) * 100 + "%";
  audioPlayer.querySelector(".time .current").textContent = getTimeCodeFromNum(
    audio.currentTime
  );
}, 500);

//toggle between playing and pausing on button click
const playBtn = audioPlayer.querySelector(".controls .toggle-play");
playBtn.addEventListener(
  "click",
  () => {
    if (audio.paused) {
      playBtn.classList.remove("play");
      playBtn.classList.add("pause");
      audio.play();
    } else {
      playBtn.classList.remove("pause");
      playBtn.classList.add("play");
      audio.pause();
    }
  },
  false
);

audioPlayer.querySelector(".volume-button").addEventListener("click", () => {
  const volumeEl = audioPlayer.querySelector(".volume-container .volume");
  audio.muted = !audio.muted;
  if (audio.muted) {
    volumeEl.classList.remove("icono-volumeMedium");
    volumeEl.classList.add("icono-volumeMute");
  } else {
    volumeEl.classList.add("icono-volumeMedium");
    volumeEl.classList.remove("icono-volumeMute");
  }
});

//turn 128 seconds into 2:08
function getTimeCodeFromNum(num) {
  let seconds = parseInt(num);
  let minutes = parseInt(seconds / 60);
  seconds -= minutes * 60;
  const hours = parseInt(minutes / 60);
  minutes -= hours * 60;

  if (hours === 0) return `${minutes}:${String(seconds % 60).padStart(2, 0)}`;
  return `${String(hours).padStart(2, 0)}:${minutes}:${String(
    seconds % 60
  ).padStart(2, 0)}`;
}


</script>
