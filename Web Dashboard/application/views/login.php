<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>AdminWSSP | Log in</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="../assets/plugins/iCheck/square/blue.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo"> <a href=""><b>Admin</b>WSSP</a> </div>
  <div class="login-box-body">
    <p class=" glyphicon glyphicon-user" style="     margin: 6px 130px 26px;
    font-size: 40px;"></p>
    <p class="login-box-msg " style="    color: #000;
    font-size: 18px;
    border-bottom: 1px dashed #000;
    margin-bottom: 25px;">Sign in to start your Dashboard</p>
    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="mobilenumber" placeholder="mobile number">
        <?php echo validation_errors(); ?> <span class="glyphicon glyphicon-phone form-control-feedback"></span> </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span> </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck" style="padding: 17px 0px !important; ">
            <label style="color: #000 !important;
    font-size: 18px !important;" >
              <input type="checkbox" >
              Remember Me </label >
          </div>
        </div>
        <div class="col-xs-12">
          <button type="submit" name="login_submit" class="btn btn-primary btn-block btn-flat" style="background: #fe8800; border-color:#fe8800 !important;">Sign In</button>
        </div>
      </div>
    </form>
    <!-- <div class="social-auth-links text-center">
    </div><a href=""  style="float: right; color: #000;font-size: 18px;     padding: 6px 0px">I forgot my password</a>--><br>
    
    <!-- <a href="<?php //echo base_url()."main/signup" ?>" class="text-center">Register Here</a> --> 
    </div>
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
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-100500944-1', 'auto');
  ga('send', 'pageview');

</script>