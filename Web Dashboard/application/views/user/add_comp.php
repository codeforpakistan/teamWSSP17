<?php
 //include'../template/menu.php'; 

 ?>
<h3 style="margin-left:140px;">
Add New Complaint
<?php  //echo form_open(base_url().'main/add_comp/add'); ?>
<form action="<?php echo base_url()?>main/add_comp/add" method="post" enctype="multipart/form-data">
<table width="" border="0" align="left" style="margin-left:30px; font-size:13px;  font-family:Verdana, Geneva, sans-serif; margin-bottom:20px;">
  <tr>
    <td align="right">Complaint Number</td>
    <td>:</td>
    <td><input type="text" name="c_number" class="" ></td>
  </tr>
  <tr>
    <td colspan="4"  height="13" align="right"><?php echo form_error('c_number', '<span class="error">', '</span>'); ?></td>
  </tr>
  <tr>
    <td align="right">Details</td>
    <td>:</td>
    <td><input type="text" name="c_details" class=""></td>
  </tr>
  <tr>
    <td colspan="4"  height="13" align="right"><?php echo form_error('c_details', '<span class="error">', '</span>'); ?></td>
  </tr>
  <tr>
    <td align="right">Bin Addresss</td>
    <td>:</td>
    <td><input type="text" name="bin_address" class=""></td>
  </tr>
  <tr>
    <td colspan="4"  height="13" align="right"><?php echo form_error('longitude', '<span class="error">', '</span>'); ?></td>
  </tr>
  <tr>
    <td align="right">Longitude</td>
    <td>:</td>
    <td><input type="text" name="longitude" class="" ></td>
  </tr>
  <tr>
    <td colspan="4"  height="13" align="right"><?php echo form_error('latitude', '<span class="error">', '</span>'); ?></td>
  </tr>
  <tr>
    <td align="right">Latitude</td>
    <td>:</td>
    <td><input type="text" name="latitude" class="" ></td>
  </tr>
  <tr>
    <td colspan="4"  height="13" align="right"><?php echo form_error('image_path', '<span class="error">', '</span>'); ?></td>
  </tr>
  <tr>
    <td align="right">Upload Image </td>
    <td>:</td>
    <td><input type="file" name="image_path"  class="" value=""></td>
    <?php /*?><?php if($image_path){?>
		<img src="../../../uploads/map/<?=$image_path?>" style="width:200px; height:200px;">
    <?php }else{
		echo '';
	}?><?php */?>
  </tr>
  <br>
	<tr>
<td colspan="4"  height="13" align="right"><?php echo form_error('status', '<span class="error">', '</span>'); ?></td>
</tr>
  	<?php /*?><tr>
    <td align="right">Status</td>
    <td>:</td>
    <td>
    <select class="" name="status">
    	<option value="">Please Select Option</option>
    	<option value="pendingreview" <?php if($status=='pendingreview'){ 
					echo 'selected';
				}else{
					'';
					}?>>Pending Review</option>
    	<option value="underreview" <?php if($status=='underreview'){ 
					echo 'selected';
				}else{
					'';
					}?>>Under Review</option>
    	<option value="inprogress" <?php if($status=='inprogress'){ 
					echo 'selected';
				}else{
					'';
					}?>>In Progress</option>
    	<option value="completed" <?php if($status=='completed'){ 
					echo 'selected';
				}else{
					'';
					}?>>Completed</option>
    </select><?php */?>
    <input type="text" name="status" class="" hidden="" value="pendingreview"></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><br>
      <br>
      <input style="width:200px;" type="submit" value="Add Complaint" name="AddComplaint "class="classname"/></td>
  </tr>
  <br />
</table>
<?php echo form_close();  ?>
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
