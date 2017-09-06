
<div class="content-wrapper">
  <section class="content-header">
    <h1> Dashboard  </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
    
      <a href="web_comp/completed">
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box"> <span class="info-box-icon bg-aqua"><i class="fa fa-check-circle"></i></span>
          <div class="info-box-content"> <span class="info-box-text">Completed Complaint</span> <span class="info-box-number"><?php 
				$this->db
				->select("*")
				->from("complaint")
				->where('status', 'completed');
				echo $this->db->count_all_results(); 
				?></span> </div>
          
        </div>
      </div>
    </a>
    
    <a href="web_comp/pending">
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box"> <span class="info-box-icon bg-red"><i class=" fa fa-exclamation-circle"></i></span>
          <div class="info-box-content"> <span class="info-box-text">Pending complaints</span> <span class="info-box-number"><!--41,410--><?php 
				$this->db
				->select("*")
				->from("complaint")
				->where('status', 'pendingreview');
				echo $this->db->count_all_results(); 
				?></span> </div>
        </div>
      </div>
    </a>
    <a href="web_comp/in_progress">
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box"> <span class="info-box-icon bg-green"><i class="fa fa-truck"></i></span>
          <div class="info-box-content"> <span class="info-box-text">In Progress complaints</span> <span class="info-box-number"><!--41,410--><?php 
				$this->db
				->select("*")
				->from("complaint")
				->where('status', 'inprogress');
				echo $this->db->count_all_results(); 
				?></span> </div>
        </div>
      </div>
    </a>
      <div class="clearfix visible-sm-block"></div>
      <a href="web_comp/list">
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box"> <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
          <div class="info-box-content"> <span class="info-box-text">All Complaints</span> <span class="info-box-number"><?php echo $this->db->count_all_results('complaint'); ?></span> </div>
        </div>
      </div>
      </a>
      <a href="web_comp/under_review">
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box"> <span class="info-box-icon bg-info "><i class="fa fa-paper-plane"></i></span>
          <div class="info-box-content"> <span class="info-box-text">Under Review Complaints</span> <span class="info-box-number"><?php 
				$this->db
				->select("*")
				->from("complaint")
				->where('status', 'underreview');
				echo $this->db->count_all_results(); 
				?></span> </div>
        </div>
      </div>
      </a>
      <a href="all_users">
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box"> <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
          <div class="info-box-content"> <span class="info-box-text">New Members</span> <span class="info-box-number"><?php echo $this->db->count_all_results('account'); ?></span> </div>
        </div>
      </div>
      </a>
    </div>
  </section>
</div>
<?php //$this->load->view('template/footer'); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-100500944-1', 'auto');
  ga('send', 'pageview');

</script>