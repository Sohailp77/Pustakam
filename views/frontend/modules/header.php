<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>audioPustakam | Audio Text Books for Indian Regional Language</title>
    <meta name="description" content="Learning is more live and effective in classrooms supported by learning resources. Audio textbook in regional language will help students learn and grasp nontrivial concepts more quickly in their home language/mother tongue.">
    <meta name="robots" content="noindex,nofollow" />
    <meta name="keywords" content="audiobooks,pustakam,audio,audios,textbook,india,regional language,books,indian regional languages,audiopustakam,book,audiobook,language,indian language,audio language,ncert,ncert books,scert,scert books,scert book">
    <meta name="author" content="audioPustakam">


	<!-- responsive meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- For IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
	<!-- master stylesheet -->
	<link rel="stylesheet" href="<?=base_url()?>assets/css/style.css">
	<!-- Responsive stylesheet -->
	<link rel="stylesheet" href="<?=base_url()?>assets/css/responsive.css">
    <!--Color Switcher Mockup-->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/color-switcher-design.css">
    <!--Color Themes-->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/color-themes/default-theme.css" id="theme-color-file">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="<?=base_url()?>assets/images/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="<?=base_url()?>assets/images/favicon/favicon-16x16.png" sizes="16x16">

    <!-- Fixing Internet Explorer-->
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script src="js/html5shiv.js"></script>
    <![endif]-->
    
    <!-- main jQuery -->
    <script src="<?=base_url()?>assets/js/jquery.js"></script>

    
</head>
<body>
<div class="boxed_wrapper">

<!-- Top bar area -->  
<section class="top-bar-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="top-bar clearfix">
                    <div class="top-left-content float-left">
                        <ul>
                            <li><span class="flaticon-technology thm-clr"></span>+91 883-099-8242</li>
                            <li><span class="flaticon-dark thm-clr"></span>admin@audiopustakam.com</li>
                            <li><a href="<?=base_url()?>audio-tutor/1"><span class="flaticon-social thm-clr"></span>Audio Tutors</a></li>
                        </ul>
                    </div>
                    <div class="top-right-content float-right">
                        <ul class="float-right">
                            <?php
                            if($this->session->userdata(ADMIN_SESSION_NAME)!=null)
                            {
                                ?>
                                <li><a href="<?=base_url()?>profile"><span class="flaticon-social thm-clr"></span><?=$this->session->userdata(ADMIN_SESSION_NAME)['name']?></a></li>
                                <li><a href="<?=base_url()?>logout"><span class="flaticon-arrows thm-clr"></span>Logout</a></li>
                                <?php
                            }
                            else
                            {
                                ?>
                                <li><a href="<?=base_url()?>account"><span class="flaticon-social thm-clr"></span>Login</a></li>
                                <li><a href="<?=base_url()?>account"><span class="flaticon-arrows thm-clr"></span>Register</a></li>
                                <?php
                            }
                            ?>
                            
                        </ul>    
                    </div>
                </div>    
            </div>
        </div>
    </div>
</section>
<!--End Top bar area --> 
 
<!--Start header area-->
<header class="stricky stricky-fixed" style="background: #ffffff;position: relative;z-index: 10;box-shadow: 0px 2px 4px #ededed;">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="inner-content clearfix">
                    <div class="header-left float-left">
                        <div class="logo">
                            <a href="<?=base_url()?>">
                                <img src="<?=base_url()?>assets/images/resources/audio_logo.png" alt="Awesome Logo">
                            </a>
                        </div>
                    </div>
                    <div class="header-middle clearfix float-right">
                        <!--Start mainmenu-->
                        <nav class="main-menu clearfix float-right">
                            <div class="navbar-header clearfix">   	
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="navbar-collapse collapse clearfix float-right">
                                <ul class="navigation clearfix">
                                    <li <?=$_SESSION['menu']=="home"?"class='current'":''?>><a href="<?=base_url()?>">Home</a></li>
                                    <li class="dropdown <?=$_SESSION['menu']=="langauge"?'current':''?>"><a href="#">Langauges</a>
                                        <ul>
                                            <?php
                                            foreach($language_menu as $menu)
                                            {
                                                ?>
                                                <li><a href="<?=base_url()?>standard/<?=$menu->mid?>/0"><?=$menu->state?>-<?=$menu->language?></a></li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                    <li <?=$_SESSION['menu']=="about"?"class='current'":''?>><a href="<?=base_url()?>about">About</a></li>
                                    <li <?=$_SESSION['menu']=="contact"?"class='current'":''?>><a href="<?=base_url()?>contact">Contact</a></li>
                                </ul>
                            </div>
                        </nav>
                        <!--End mainmenu-->    
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</header>  
<!--End header area-->    