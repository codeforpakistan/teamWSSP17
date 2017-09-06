<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminWSSP | Dashboard</title>
  <base href="<?php echo base_url();?>">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.css">
  <style type="text/css">
    .custom-img{width:100px; height:80px; border-radius:4px;}
    .w2ui-popup{
    opacity: 1 !important;
    left: 433px !important;
    top: 101px !important;
    width: 650px !important;
    height:550px !important;
    transition: none !important ;
    transform: translate3d(0px, 0px, 0px) !important;}
  </style>
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!--Success!-->

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<header class="main-header"> <a href="main/members" class="logo" style="background-color: #fe8800!important;" > <span class="logo-mini" >WSSP</span> <span class="logo-lg" style="background-color: #fe8800!important;"><b>Admin</b>WSSP</span> </a>
  <nav class="navbar navbar-static-top" style="background-color: #222d32 !important;"> <a href="main/members" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- <li class="dropdown notifications-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell-o"></i> <span class="label label-warning">10</span> </a>
          <ul class="dropdown-menu">
            <li class="header">You have 10 notifications</li>
            <li>
              <ul class="menu">
                <li> <a href="#"> <i class="fa fa-users text-aqua"></i> 5 new members joined today </a> </li>
                <li> <a href="#"> <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit . </a> </li>
                <li> <a href="#"> <i class="fa fa-users text-red"></i> 5 new members joined </a> </li>
                <li> <a href="#"> <i class="fa fa-shopping-cart text-green"></i> 25 sales made </a> </li>
                <li> <a href="#"> <i class="fa fa-user text-red"></i> You changed your username </a> </li>
              </ul>
            </li>
            <li class="footer"><a href="<?php //echo base_url()."main/web_comp/list"?>"">View all</a></li>
          </ul>
        </li> -->
        <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?php echo base_url();?>assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> <span class="hidden-xs">WSSP</span> </a>
          <ul class="dropdown-menu">
            <li class="user-header"> <img src="<?php echo base_url();?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
              <p> ADMIN <small>WSSP</small> </p>
            </li>
            <li class="user-footer">
              <!--<div class="pull-left"> <a href="<?php //echo base_url();?>main/logout" class="btn btn-default btn-flat">Profile</a> </div>-->
              <div class="pull-right"> <a href="<?php echo base_url();?>main/logout" class="btn btn-default btn-flat">Sign out</a> </div>
            </li>
          </ul>
        </li>
        <!--<li> <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> </li>-->
      </ul>
    </div>
  </nav>
</header>
