<!doctype html>
<html lang="en">

<!-- Mirrored from themesbrand.com/minible/layouts/vertical/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 06 Oct 2020 10:57:22 GMT -->

<head>

    <meta charset="utf-8" />
    <title>audioPustakam | <?php print(htmlentities($pageTitle)); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="audioPustakam Admin" name="description" />
    <meta content="audioPustakam" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php print(base_url()); ?>assets/admin/images/favicon.ico">

    <link href="<?php print(base_url()); ?>assets/admin/libs/select2/css/select2.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php print(base_url()); ?>assets/admin/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css"
        rel="stylesheet">

    <!-- DataTables -->
    <link href="<?php print(base_url()); ?>assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link
        href="<?php print(base_url()); ?>assets/admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="<?php print(base_url()); ?>assets/admin/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="<?php print(base_url()); ?>assets/admin/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php print(base_url()); ?>assets/admin/css/app.min.css" id="app-style" rel="stylesheet"
        type="text/css" />
    <link href="<?php print(base_url()); ?>assets/admin/libs/summernote/summernote-bs4.min.css" rel="stylesheet"
        type="text/css" />

    <style type="text/css">
    .dataTables_scrollBody {
        overflow: visible !important;
    }
    #sidebar-menu ul li .badge {
        margin-top: 4px;
    }
    .rounded-pill {
        padding-right: 0.6em;
        padding-left: 0.6em;
    }
    .rounded-pill {
        border-radius: 50rem!important;
    }
    .bg-primary {
        --bs-bg-opacity: 1;
        background-color: rgba(var(--bs-primary-rgb),var(--bs-bg-opacity))!important;
    }
    .float-end {
        float: right!important;
    }
    .badge {
        display: inline-block;
        padding: 0.25em 0.4em;
        font-size: 75%;
        font-weight: 500;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }
    </style>
    <script src="<?php print(base_url()); ?>assets/admin/libs/jquery/jquery.min.js"></script>
</head>
<?php

// Set body class based on the page
$strBodyCls = "";
if ($pageCode == "AL" || $pageCode == "RP") { // Admin login
    $strBodyCls = "authentication-bg";
}

?>

<body class="<?php print($strBodyCls); ?>"><?php

                                            // Display header and sidebar menu for all admin pages except login page.
                                            if ($pageCode != "AL" && $pageCode != "RP") {

                                            ?><div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="<?php print(site_url('admin/dashboard')); ?>" class="logo logo-dark">
                            audioPustakam
                        </a>

                        <a href="<?php print(site_url('admin/dashboard')); ?>" class="logo logo-light">
                            audioPustakam
                        </a>
                    </div>

                    <button type="button"
                        class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block ml-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="uil-minus-path"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="<?php print(base_url()); ?>assets/admin/images/users/ma-loggined-user.png"
                                alt="Logged in user">
                            <span
                                class="d-none d-xl-inline-block ml-1 font-weight-medium font-size-15"><?php print(htmlentities($this->session->userdata(ADMIN_SESSION_NAME)['name'])); ?></span>
                            <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?php print(site_url('admin/logout')); ?>"><i
                                    class="uil uil-sign-out-alt font-size-18 align-middle mr-1 text-muted"></i> <span
                                    class="align-middle">Log out</span></a>

                            <a class="dropdown-item" href="<?php print(site_url('admin/update_password')); ?>"><i
                                    class="uil uil-lock-alt font-size-18 align-middle mr-1 text-muted"></i> <span
                                    class="align-middle">Update Password</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?php print(base_url()); ?>" class="logo logo-dark">
                    <h3 style="padding-top:18px">audioPustakam</h3>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div data-simplebar class="sidebar-menu-scroll">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <?php if (in_array('Dashboard', $this->session->nav)) { ?>
                        <li class="menu-title">Menu</li>
                        <li>
                            <a href="<?php print(base_url()); ?>admin/dashboard">
                                <i class="uil-home-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <?php } ?>
                        <?php
                        if(in_array('User_groups', $this->session->nav) || in_array('Users', $this->session->nav))
                        {
                        ?>
                        <li class="menu-title">Administration</li>
                        <?php
                        }
                        ?>
                        <?php if (in_array('User_groups', $this->session->nav)) { ?>
                        <li>
                            <a href="<?php print(base_url()); ?>admin/user_groups" class="waves-effect">
                                <i class="uil-user-circle"></i>
                                <span>User Groups</span>
                            </a>
                        </li>
                        <?php }
                        if (in_array('Users', $this->session->nav)) { ?>
                        <li>
                            <a href="<?php print(base_url()); ?>admin/users" class="waves-effect">
                                <i class="uil-user-circle"></i>
                                <span>Users</span>
                            </a>
                        </li>
                        <?php } ?>
                        
                        <?php
                        if (in_array('Customer', $this->session->nav)) { ?>
                        <li>
                            <a href="<?php print(base_url()); ?>admin/customer" class="waves-effect">
                                <i class="uil-list-ul"></i>
                                <span>Customer</span>
                            </a>
                        </li>
                        <?php } ?>

                        <?php
                        if (in_array('Standard', $this->session->nav)) { ?>
                        <li>
                            <a href="<?php print(base_url()); ?>admin/standard" class="waves-effect">
                                <i class="uil-list-ul"></i>
                                <span>Standard</span>
                            </a>
                        </li>
                        <?php } ?>

                        <?php
                        if (in_array('Map', $this->session->nav)) { ?>
                        <li>
                            <a href="<?php print(base_url()); ?>admin/map" class="waves-effect">
                                <i class="uil-list-ul"></i>
                                <span>Map Data</span>
                            </a>
                        </li>
                        <?php } ?>

                        <?php
                        if (in_array('Chapter', $this->session->nav)) { ?>
                        <li>
                            <a href="<?php print(base_url()); ?>admin/chapter" class="waves-effect">
                                <i class="uil-list-ul"></i>
                                <span>Chapters</span>
                            </a>
                        </li>
                        <?php } ?>

                        <?php
                        if (in_array('Payment', $this->session->nav)) { ?>
                        <li>
                            <a href="<?php print(base_url()); ?>admin/payment" class="waves-effect">
                                <i class="uil-list-ul"></i>
                                <span>Payments</span>
                            </a>
                        </li>
                        <?php } ?>
                        
                       
                       

                        
                       
                        <?php 
                        if(in_array('System_settings', $this->session->nav))
                        {
                        ?>
                        <li class="menu-title">Settings</li>
                        <?php
                        }
                        ?>
                        <?php if (in_array('System_settings', $this->session->nav)) { ?>
                        <li>
                            <a href="<?php print(base_url()); ?>admin/system_settings" class="waves-effect">
                                <i class="uil-shutter-alt"></i>
                                <span>System Settings</span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>

        <div class="main-content">
            <?php } ?>
