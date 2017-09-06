<?php //$this->load->view('template/header')?>
<?php $this->load->view('template/menu')?>

<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> List All Users </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Users</a></li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12"> 
        
        <!-- /.box -->
        
        <div class="box"> 
          
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Neighborhood Council</th>
                  <th>Union Council</th>
                  <th>Full Name</th>
                  <th>Email Address</th>
                  <th>Roll</th>
                  <th>Mobile Number</th>
                  <!-- <th>Profile Image</th> -->
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($multiListingData)) foreach($multiListingData as $row){?>
                <tr>
                  <td><?=$row->account_id?></td>
                  <td><?=$row->nc_id?></td>
                  <td><?=$row->uc_id?></td>
                  <td><?=$row->fullname?></td>
                  <td><?=$row->emailad?></td>
                  <td><?php if(isset($row->roll))
                    if($row->roll == 0){
                      echo "<span class='btn bg-navy btn-flat margin'>Mobile App User</span>";
                    }elseif($row->roll == 1){
                      echo "<span class='btn bg-purple btn-flat margin'>Dashboard User</span>";
                    }// elseif($roll->roll == 2){
                    //   echo "<span class='btn gb-green btn-flat margin'>Super Admin</span>";
                    // }

                    ?>                      
                    </td>
                  <td><?=$row->mobilenumber?></td>
                  <?php if(!empty($row->profile_image)){?>
                   <!-- <td><img style="width:80px; height:80px;" src="uploads/profile/<?=$row->profile_image?>" class="img-responsive img-circle"></td> -->
                   <?php }else{?>
                   <!-- <td><img style="width:80px; height:80px;" src="uploads/profile/user.png" class="img-responsive img-circle"></td> -->
                   <?php }?>
                  <td>
                  <?php $data = $this->session->all_userdata();
                  if($data['mobilenumber'] == "03358018012") {?>
                  <a onclick="return confirm('Are you sure you want to delete this?');" href="main/all_users/deleteuser/<?=$row->account_id?>" class="btn" style="background-color:#d73925; color: #fff;"><i class="fa fa-fw fa-close"></i></a> 
                  <?php }?><!-- <a href="edit/<?=$row->account_id?>" class="btn" style="background-color: #222d32;color: #fff; "><i class="fa fa-fw fa-edit"></i></a> --></td>
                </tr> 
                <?php }?>
              </tbody>
              <tfoot>
                <tr>
                  <th>::::</th>
                  <th>::::</th>
                  <th>::::</th>
                  <th>::::</th>
                  <th>::::</th>
                  <th>::::</th>
                  <th>::::</th>
                  <th>::::</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
<style>
.error{
color:#FF0000;
}
</style>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-100500944-1', 'auto');
  ga('send', 'pageview');

</script>