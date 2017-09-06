<?php $this->load->view('template/menu')?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> General Form Elements <small>Preview</small> </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Forms</a></li>
    <li class="active">General Elements</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
<!-- left column --> 

<!--/.col (left) --> 
<!-- right column -->
<div class="col-md-12"> 
  
  <!-- Horizontal Form -->
  <div class="box box-warning">
    <div class="box-header with-border"> </div>
    <!-- /.box-header --> 
    <!-- form start -->
    
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

    <div class="box-body">
      <div class="col-md-6">
       
       <div class="form-group">
          <label for="c_number" class="col-sm-5 control-label">Complaint Number</label>
          <div class="col-sm-7"> 
           
<input type="text" class="form-control" readonly name="c_number" value="<?php echo $c_number?>" id="c_number" placeholder="Email" >
          </div>
        </div>
        <div class="form-group">
          <label for="c_details" class="col-sm-5 control-label">Complaint Details</label>
          <div class="col-sm-7"> 
           
            <textarea name="c_details" readonly class="form-control" ><?php echo $c_details?></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="bin_address" class="col-sm-5 control-label">Complaint Location</label>
          <div class="col-sm-7">
            <input type="text" readonly class="form-control" name="bin_address" value="<?php echo $bin_address?>" id="bin_address" placeholder="">
          </div>
        </div>
        
        <div class="form-group">
          <label for="image_path" class="col-sm-5 control-label">Image</label>
          <div class="col-sm-7">
            <input readonly type="file" name="image_path" readonly class="" value=""><br>
            <img class="img-responsive" src="<?=$image_path?>"> </div>
        </div>
        <div class="form-group">
          <label for="latitude" class="col-sm-5 control-label">Latitude</label>
          <div class="col-sm-7">
            <input type="text" name="latitude"  readonly class="form-control" id="latitude" value="<?php echo $latitude?>" >
          </div>
        </div>
        <div class="form-group">
          <label for="longitude" class="col-sm-5 control-label">Longitude</label>
          <div class="col-sm-7">
            <input type="text" readonly class="form-control" name="longitude" value="<?php echo $longitude?>" id="longitude" >
          </div>
        </div>
        <div class="form-group">
          <label for="status" class="col-sm-5 control-label">Status</label>
          <div class="col-sm-7">
            <select class="" name="status">
              <!-- <option value="">Please Select Option</option> -->
              <option value="pendingreview" <?php if($status=='pendingreview')echo 'selected';?>>Pending Review</option>
              <!-- <option value="underreview" <?php if($status=='underreview')echo 'selected';?>>Under Review</option> -->
              <option value="inprogress" <?php if($status=='inprogress')echo 'selected';?>>In Progress</option>
              <option value="completed" <?php if($status=='completed') echo 'selected';?>>Completed</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="c_type" class="col-sm-5 control-label">Complaint Type</label>
          <div class="col-sm-7">
            <input type="text" readonly class="form-control" name="c_type" value="<?php echo $c_type?>" id="Complaint Type" >
          </div>
        </div>
        <input type="hidden" name="push_type" value="individual"/>
       <input type="hidden" class="form-control" name="token_id" value="<?php if(isset($token_id)) echo $token_id?>" id="Token Id" >
        <input type="hidden" class="form-control" name="c_number" value="<?php if(isset($c_number)) echo $c_number?>" id="Complaint Number" >
      </div>
    </div>
    <!-- /.box-body -->
    
    <div class="box-footer col-md-12">
      <div class="col-md-6">
        <a href="<?php echo base_url();?>main/web_comp/list"type="submit" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-warning pull-right">Submit</button>
      </div>
    </div>
    <!-- /.box-footer -->
    </form>
  </div>
  <!-- /.box --> 
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-100500944-1', 'auto');
  ga('send', 'pageview');

</script>