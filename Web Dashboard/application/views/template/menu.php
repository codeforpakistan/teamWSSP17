<?php 
if(isset($active)) echo $active;
?>
<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel"> </div>
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="<?=@$active=="members"?"active":"";?>"> <a href="<?php echo base_url()."main/members"  ?>" > <i class="fa fa-dashboard"></i> <span>Dashboard</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a> </li>
      <li class="<?=@$active=="web_comp/list"?"active":"";?>"> 
    <a href="<?php echo base_url()."main/web_comp/list"  ?>"> <i class="fa fa-files-o "></i> <span>All Complaints</span> </a> 			 
    	</li>
      <li class="<?=@$active=="web_comp/pending"?"active":"";?>"> 
      <a href="<?php echo base_url()."main/web_comp/pending"  ?>"> <i class=" fa fa-exclamation-circle"></i> <span>Pending Reviews</span> </a> 
      </li>
      <!-- <li class="<?=@$active=="web_comp/under_review"?"active":"";?>"> 
      <a href="<?php echo base_url()."main/web_comp/under_review"  ?>"> <i class=" fa fa-exclamation-circle"></i> <span>Under Review</span> </a> 
      </li> -->
      <li class="<?=@$active=="web_comp/in_progress"?"active":"";?>"> 
      <a href="<?php echo base_url()."main/web_comp/in_progress"  ?>"> <i class="fa fa-truck" aria-hidden="true"></i> <span>In Progress</span>  </a> 
      </li>
      <li class="<?=@$active=="web_comp/completed"?"active":"";?>"> 
      <a href="<?php echo base_url()."main/web_comp/completed"  ?>"> <i class="fa fa-check-circle" aria-hidden="true"></i> <span>Completed Complaints</span>  </a> 
      </li>
      <li class="<?=@$active=="index"?"active":"";?>"> 
      <a href="<?php echo base_url()."latLangControl/index"?>"> <i class="fa fa-map-marker" aria-hidden="true"></i> <span>Map</span>  </a> 
      </li>
      <?php 
      // $mobilenumber = $this->db->get_where('account', array('mobilenumber' => "03358018012"))->row();
      // //print_r($roll);die;
      //echo '<pre>'; print_r($this->session->all_userdata());exit;
      $data = $this->session->all_userdata();
      if($data['mobilenumber'] == "03358018012") {?>
        <li class="<?=@$active=="index"?"active":"";?>"> 
        <a href="<?php echo base_url()."user/registration"?>"> <i class="fa fa-map-marker" aria-hidden="true"></i> <span>Registration</span>  </a> 
        </li>
      <?php }?>
    </ul>
  </section>
</aside>
