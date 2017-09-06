<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminWSSP | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../assets/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
  <link rel="stylesheet" href="../assets/bootstrap/css/chosen.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
.login-box, .register-box {
	width: 560px;
	margin: 7% auto;
}
</style>
  </head>
  <body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo"> <a href=""><b>Admin</b>WSSP</a> </div>
    <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group has-feedback">
        <label for="fullname">Full Name:</label>
        <input type="text" class="form-control" name="fullname"  placeholder="Full name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span> <span><?php echo form_error('fullname', '<span class="error">', '</span>'); ?></span> </div>
        <div class="form-group has-feedback">
        <label for="emailad">Email Address:</label>
        <input type="email" class="form-control" name="emailad" placeholder="Email Address">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span> <span><?php echo form_error('emailad', '<span class="error">', '</span>'); ?></span> </div>
        <div class="form-group has-feedback">
        <label for="mobilenumber">Mobile Number:</label>
        <input type="number" class="form-control" name="mobilenumber" placeholder="Mobile Number">
        <span class="glyphicon glyphicon-phone form-control-feedback"></span> <span><?php echo form_error('mobilenumber', '<span class="error">', '</span>'); ?></span> </div>

        <div class="form-group has-feedback">
        <label for="mobilenumber">Roll:(Note: Roll Is Used For Admin Panel & Mobile App</label>
        <select name="roll" class="form-control">
            <option value="0">Mobile App Users</option>
            <option value="1">Admin Panel Users</option>
        </select>
        <!-- <input type="number" class="form-control" name="roll" placeholder="Mobile Number"> -->
        <span class="glyphicon glyphicon-phone form-control-feedback"></span> <span><?php echo form_error('roll', '<span class="error">', '</span>'); ?></span> </div>

        <div class="form-group has-feedback">
        <label for="mobilenumber">Zone's</label>
        <select name="zones" class="form-control chosen-select" data-placeholder="Choose a Country" tabindex="2">
        <?php

          $zones = $this->db->get('zones')->result_array();
         
         if(isset($zones)) foreach($zones as $zone){?>
            <option value="<?php echo $zone['zones']?>"><?php echo $zone['zones']?></option>
        <?php }?>
        </select>
        <!-- <input type="number" class="form-control" name="roll" placeholder="Mobile Number"> -->
        <span class="glyphicon glyphicon-phone form-control-feedback"></span> <span><?php echo form_error('zones', '<span class="error">', '</span>'); ?></span> </div>

        <div class="form-group has-feedback">
        <label for="uc">Union Council</label>
        <select name="uc" class="form-control chosen-select" data-placeholder="Choose a Country" tabindex="2">
         <?php
          $unioncouncils_c = $this->db->get('unioncouncil_c')->result_array();
         
         if(isset($unioncouncils_c)) foreach($unioncouncils_c as $unioncouncil_c){?>
            <option value="<?php echo $unioncouncil_c['uc']?>"><?php echo $unioncouncil_c['uc']?></option>
        <?php }?>
        </select>
        <!-- <input type="number" class="form-control" name="roll" placeholder="Mobile Number"> -->
        <span class="glyphicon glyphicon-phone form-control-feedback"></span> <span><?php echo form_error('uc', '<span class="error">', '</span>'); ?></span> </div>

        <div class="form-group has-feedback">
        <label for="nc">Nabourhood council</label>
        <select name="nc" class="form-control chosen-select" data-placeholder="Choose a Country" tabindex="2">
            <?php
          $neighbourhoods_c = $this->db->get('neighbourhood_c')->result_array();
         
           if(isset($neighbourhoods_c)) foreach($neighbourhoods_c as $neighbourhood_c){?>
              <option value="<?php echo $neighbourhood_c['nc']?>"><?php echo $neighbourhood_c['nc']?></option>
        <?php }?>
        </select>
        <!-- <input type="number" class="form-control" name="roll" placeholder="Mobile Number"> -->
        <span class="glyphicon glyphicon-phone form-control-feedback"></span> <span><?php echo form_error('roll', '<span class="error">', '</span>'); ?></span> </div>

        <div class="form-group has-feedback">
        <label for="password">Password:</label>
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span> <span><?php echo form_error('password', '<span class="error">', '</span>'); ?></span> </div>
        <div class="form-group has-feedback">
        <label for="cpassword">Confirm Password:</label>
        <input type="password" class="form-control" name="cpassword" placeholder="Retype password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span> <span><?php echo form_error('cpassword', '<span class="error">', '</span>'); ?></span> </div>
       <!--  <div class="form-group has-feedback">
        <label for="profile_image">Profile Image:</label>
        <input type="file" class="form-control" name="profile_image" placeholder="Retype password">
        <span class="glyphicon glyphicon-upload form-control-feedback"></span> <span><?php //echo form_error('profile_image', '<span class="error">', '</span>'); ?></span> </div> -->
        <div class="row">        
        <div class="col-xs-4">
            <button type="submit" name="mysubmit " class="btn btn-primary btn-block btn-flat">Register</button>
          </div>
      </div>
      </form>
    <a href="<?php echo base_url()."main/login_validation" ?>" class="text-center">Already Have ID</a> </div>
  </div>
<script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script> 
<script src="../assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="../assets/plugins/iCheck/icheck.min.js"></script> 
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-100500944-1', 'auto');
  ga('send', 'pageview');


      $(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
      });


</script>