<?php
class user_info extends CI_Model{
	public function system_is_creating_user(){
	 
		
	    $data['fullname'] = $this->input->post('fullname');
		$data['emailad']   =$this->input->post('emailad');
	   	$data['mobilenumber']  = $this->input->post('mobilenumber');
	   	
	   	$data['roll']  = $this->input->post('roll');
	   	$data['password']  = sha1($this->input->post('password'));
	   	$data['zones_id']  = $this->input->post('zones');
	   	$data['uc_id']  = $this->input->post('uc');
	   	$data['nc_id']  = $this->input->post('nc');
	   	//$data['address']  = $this->input->post('address');

		$query=$this->db->insert('account',$data);
		   return $query;
	   
	   }
	   public function system_is_creating_user_for_app(){
	 
		
	    $data['fullname'] = $this->input->post('fullname');
		$data['emailad']   =$this->input->post('emailad');
	   	$data['mobilenumber']  = $this->input->post('mobilenumber');
	   	$data['roll']  = $this->input->post('roll');
	   	$data['password']  = sha1($this->input->post('password'));
	   	$data['address']  = $this->input->post('address');
	   	//$data['uc_id']  = $this->input->post('uc');
	   	//$data['nc_id']  = $this->input->post('nc');
		
	    $query=$this->db->insert('account',$data);
			$data=array(
				'status' => 'Successfully Registered !',   
			);
			
			if($query){
				echo json_encode($data);
			   }
			   else{
				echo json_encode("Registeration Faild !");
			   }
	   
	   }
	   
	   function upload(){
	
			$config['upload_path'] = './uploads/profile/';
		
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '100000';
			$config['max_width']  = '10240';
			$config['max_height']  = '7680';
			$config['encrypt_name'] = true;
		
		$this->load->library('upload', $config);

		if ( !$this->upload->do_upload('profile_image')){
			$error = array('error' => $this->upload->display_errors());
			return $error;
		}
		else{
			$data = array('upload_data' => $this->upload->data());
			return $data;
		}
	}
 
}
