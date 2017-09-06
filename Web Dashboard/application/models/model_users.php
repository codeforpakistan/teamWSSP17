<?php class model_users extends CI_Model{
	public function can_log_ins(){
	
	$this->db->where('mobilenumber',$this->input->post('mobilenumber'));
	$this->db->where('password',sha1($this->input->post('password')));
	$query=$this->db->get('account');
	if($query->num_rows()==1){
		 return true;
	}else{
		return false;
		}
	} 

	public function can_log_in(){
	
	$this->db->where('mobilenumber',$this->input->post('mobilenumber'));
	$this->db->where('password',sha1($this->input->post('password')));
	
	$query=$this->db->get('account');

	if($query->num_rows()==1){
		return true;
	}else{
		return false;
		}
	} 
	 function getOne($mobilenumber){
		$query=$this->db->query('SELECT * FROM account WHERE mobilenumber = '.$mobilenumber);
		return $query->result();
	}

	function get_One_Complaint_Feedback($mobilenumber){
			$this->db->select('*')
			->from('feedback')
			->where("complaint.c_number",$mobilenumber)
			//->order_by("c_id", "DESC")
			//->join('account', 'account.account_id = feedback.account_id')
			->join('complaint', 'complaint.c_number = feedback.c_number');
			 $query = $this->db->get();
			  return $query->result();

		return array();
		
	}

	function upload($image_name){
	
			$config['upload_path'] = './uploads/profile/';
		
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '100000';
			$config['max_width']  = '10240';
			$config['max_height']  = '7680';
			$config['encrypt_name'] = true;
		
		$this->load->library('upload', $config);

		if ( !$this->upload->do_upload($image_name)){
		return false;
		}
		else{
		$data = array('upload_data' => $this->upload->data());
			return $data;
		}
	}
	function select_all_rec($table){
			$this->db
			->select("*")
			->from($table)
			->order_by("c_id", "DESC");
			$select_all_rec	=	$this->db->get();
			if($select_all_rec->num_rows() > 0){
				return $select_all_rec->result();
			}
			else{
				return array();
		}
	}
	function users_list_all($table){
			$this->db
			->select("*")
			->from($table);
			$users_list_all	=	$this->db->get();
			if($users_list_all->num_rows() > 0){
				return $users_list_all->result();
			}
			else{
				return array();
		}
	}
	function select_all_in_progress_list($table){
			$this->db
			->select("*")
			->from($table)
			->where("status","inprogress")
			->order_by("c_id", "DESC");
			$select_all_in_progress_list	=	$this->db->get();
			if($select_all_in_progress_list->num_rows() > 0){
				return $select_all_in_progress_list->result();
			}
			else{
				return array();
		}
	}
	function select_all_pending_list($table){
			$this->db
			->select("*")
			->from($table)
			->where("status","pendingreview")
			->order_by("c_id", "DESC");
			$select_all_pending_list	=	$this->db->get();
			if($select_all_pending_list->num_rows() > 0){
				return $select_all_pending_list->result();
			}
			else{
				return array();
		}
	}
	function select_all_under_review_list($table){
			$this->db
			->select("*")
			->from($table)
			->where("status","underreview")
			->order_by("c_id", "DESC");
			$select_all_under_review_list	=	$this->db->get();
			if($select_all_under_review_list->num_rows() > 0){
				return $select_all_under_review_list->result();
			}
			else{
				return array();
		}
	}
	
	function select_all_completed_list($table){
			$this->db
			->select("*")
			->from($table)
			->where("status","completed")
			->order_by("c_id", "DESC");
			$select_all_completed_list	=	$this->db->get();
			if($select_all_completed_list->num_rows() > 0){
				return $select_all_completed_list->result();
			}
			else{
				return array();
		}
	}
	function doUpdateSingleRecord($tableName,$feildId,$value,$listingData){
		$this->db
		->where($feildId, $value)
		->update($tableName, $listingData);
		return $this->db->affected_rows();
	}
	function doDeleteSingleRecord($tableName,$feildId,$value){
		$this->db
		->where($feildId, $value)
		->delete($tableName);
	}	
	function count_all_pending_status(){
		$this->db
		->select("*")
		->from("complaint")
		->where('status', 'pendingreview');
		echo $this->db->count_all_results(); 
		
	}

	function get_user_name_by_id($type,$type_id='',$field='fullname'){
			
			return	$this->db->get_where($type,array($type.'_id'=>$type_id))->row()->$field;

	}
	function get_all(){
			$this->db->select('*')
			 ->from('complaint')
			->order_by("c_id", "DESC")
			 ->join('account', 'account.account_id = complaint.account_id');
			 $query = $this->db->get();
			  return $query->result();

		return array();
		
	}
	// for account and complaint of single user...
	function get_single_account_complaint($c_id){
			$this->db->select('*')
			 ->from('complaint')
			 ->where('c_id',$c_id)
			 ->join('account', 'account.account_id = complaint.account_id');
			 $query = $this->db->get();
			  return $query->result();
		return array();
	}
	function get_my_complaint(){
		$mobilenumber = $this->input->post('mobilenumber'); 
		$this->db->select('*')
		 ->from('complaint')
		 ->where('mobilenumber',$mobilenumber)
		 ->join('account', 'account.account_id = complaint.account_id');
		 $query = $this->db->get();
		 return $query->result();
		return array();
	}
	
}

