<footer class="main-footer">
  <div class="pull-right hidden-xs"> <b>Version</b> 2.3.12 </div>
  <strong>Copyright &copy; 2017 <a href="http://wsspeshawar.org.pk">WSSPESHAWAR.ORG.PK</a>.</strong> All rights
  reserved. </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- <script src="<?php echo base_url();?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>  -->

<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>assets/plugins/fastclick/fastclick.js"></script> 
<script src="<?php echo base_url();?>assets/dist/js/app.min.js"></script> 
<script src="<?php echo base_url();?>assets/plugins/sparkline/jquery.sparkline.min.js"></script> 
<script src="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> 
<script src="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> 
<script src="<?php echo base_url();?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script> 
<!-- <script src="<?php //echo base_url();?>assets/plugins/chartjs/Chart.min.js"></script> 
<script src="<?php //echo base_url();?>assets/dist/js/pages/dashboard2.js"></script>  -->
<script src="<?php echo base_url();?>assets/dist/js/demo.js"></script> 

<script src="<?php echo base_url();?>assets/plugins/js/w2ui-1.4.2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/js/w2ui-1.4.2.min.css">
<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $(function () {
    $("#example1").DataTable();
  //   $('#example2').DataTable({
  //     "paging": true,
  //     "lengthChange": false,
  //     "searching": false,
  //     "ordering": true,
  //     "info": true,
  //     "autoWidth": false
  //   });
  // });
</script>
<script>
$(document).ready(function() {

  $(".popup_image").on('click', function() {
    w2popup.open({
      title: 'Image',
      body: '<div class="w2ui-centered"><img src="' + $(this).attr('src') + '"></img></div>'
    });
  });

});
</script>
