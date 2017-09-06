<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class main extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		error_reporting(E_ALL);
		$this->load->model('user_info');
		$this->load->model('model_users');
		//$this->load->library('Push');
		$this->load->library('session');
		date_default_timezone_set("Asia/Karachi");
		$this->baseurl=dirname(dirname(base_url()));
	}
	public function index()
	{
	 	$this->login();
	}
  public function login()
	{
 		$this->load->view('login');
	}
	
  public function members(){
  $data['active']		=	'members';

   if($this->session->userdata('is_logged_in')){
	 
	   	$this->load->view('template/header-custom', $data);
 		$this->load->view('template/menu');
    	$this->load->view('members');
    	$this->load->view('template/footer-custom');
    }else{
		redirect('main/login_validation');
	  }
  }

   public function single_complaint_feedback(){
        //$mobilenumber = "03029155055";//$this->input->post('mobilenumber');
        $c_number = "21E3623"; //$this->input->post('c_number');
        $this->load->model('model_users');
   			//if($mobilenumber){
   			//$data=$this->model_users->getOne($mobilenumber);
			//echo json_encode($data);
   			//}else if($c_number){

        	$data=$this->model_users->get_One_Complaint_Feedback($c_number);
			echo json_encode($data);
        //}
  		//$data=$this->model_users->get_One_Complaint_Feedback($mobilenumber);
		// echo json_encode($data);
	   	
  }
 	
 	public function members_app(){
        $mobilenumber = $this->input->post('mobilenumber');
        $this->load->model('model_users');
        $data=$this->model_users->getOne($mobilenumber);
		echo json_encode($data);
	   	
  }
  public function add_comp($param1 = NULL, $param2 = NULL  ){
  	
		$data	=	'';
		switch($param1){
			
			case 'add':
			$view = 'add_comp';
				if($_POST){
					$increament = 1;
				    $data['c_number'] =$this->input->post('c_number');
				    $data['account_id'] = $this->input->post('account_id');
				   
				    $data['c_details']   = $this->input->post('c_details');
					$decoded_string = base64_decode($this->input->post('image_path'));
					$image_path = './uploads/map/'.$data['c_number'].'.jpeg';
					$data['image_path'] = $image_path; 
					file_put_contents($image_path, $decoded_string);

				    $data['longitude']   = $this->input->post('longitude');
				    $data['latitude']  = $this->input->post('latitude');
				    $data['bin_address']  = $this->input->post('bin_address');
					$data['status']  	= $this->input->post('status');
				    $data['c_date']  = date("Y-m-d");
				    $data['c_date_time']  = date("Y-m-d h:i:sa"); //$this->input->post('c_date_time');
				    $data['c_time']  = date("h:i:sa");
				    $data['c_type']  = $this->input->post('c_type');

					$query = $this->db->insert('complaint',$data);
					//$insert_id = $this->db->insert_id();
					$data=array(
						'status' => 'Successfully Registered!',   
						//'c_number'=>$data['account_id'].$insert_id,
					);
					if($query){
						echo json_encode($data);
					   }
					   else{
						echo json_encode("Complaint Faild");   
					   }
				}
			
			break;
			case 'feedback':
			
				if($_POST){
					
					$data['c_number']   	= $this->input->post('c_number');
				    $data['account_id']   	= $this->input->post('account_id');
				    $data['feedback'] 		= $this->input->post('feedback');
				    $query = $this->db->insert('feedback',$data);
					$data=array(
						'status' => 'Successfully Delivered !',   
					);
					if($query){
						echo json_encode($data);
					   }
					   else{
						echo json_encode("Complaint Faild");
					   }
					}
			break;
			case 'delete':
			$view = "list";
			$this->model_users->doDeleteSingleRecord('complaint','c_id', $param2);
			
				//redirect('main/add_comp/list');
			break;
			
			case 'list':
			$view = "list";
			//$data['multiListingData']	=	$this->model_users->get_all();
			$data['multiListingData']	=	$this->model_users->get_my_complaint();
			
			echo json_encode($data['multiListingData']);
			break;
			
			default:
			$view = "list";
			// $data['multiListingData']	=	$this->model_users->get_all();
			// echo '<pre>';print_r($data['multiListingData']);die;
			$data['multiListingData']	=	$this->model_users->select_all_rec("complaint");
			//echo json_encode($data['multiListingData']);		
			echo '<pre>'; echo print_r($data['multiListingData']);
			break;
			
		}

		
        //$this->load->view('template/header',$data);
        //$this->load->view('comp/'.$view);
        //$this->load->view('template/footer');
}
  public function web_comp($param1 = NULL, $param2 = NULL  ){
 if($this->session->userdata('is_logged_in')){
		$data	=	'';
		//$data['active']		=	'web_comp';
		
		switch($param1){
			
			case 'add':
			$view = 'add_comp';
			//$data1['active']		=	'web_comp';
				if($_POST){
				    $data['c_number'] = $this->input->post('c_number');
				    $data['c_details']   = $this->input->post('c_details');
					$decoded_string = base64_decode($this->input->post('image_path'));
					$image_path = './uploads/map/'.$data['c_number'].'.jpeg';
					$data['image_path'] = $image_path; //$this->model_users->upload('image_path');
					file_put_contents($image_path, $decoded_string);
				    $data['longitude']   = $this->input->post('longitude');
				    $data['latitude']  = $this->input->post('latitude');
				    $data['bin_address']  = $this->input->post('bin_address');
					$data['status']  	= "pendingreview";//$this->input->post('status');
				    $data['c_date']  = date("Y-m-d");
				    $data['c_time']  = date("h:i:sa");
				    $data['c_type']  = $this->input->post('c_type');
					if($this->db->insert('complaint',$data)){
						echo json_encode("Successfully Registered");
					   }
					   else{
						echo json_encode("Complaint Faild");   
					   }
				}
			
			break;
			case 'edit':
			$view = "update_comp";
			
			$complaint	=	$this->model_users->get_single_account_complaint($param2);
						
			$data['c_number']		=	$complaint[0]->c_number;
			$data['c_details']		=	$complaint[0]->c_details;
			$data['image_path']		=	$complaint[0]->image_path;
			$data['longitude']		=	$complaint[0]->longitude;
			$data['latitude']		=	$complaint[0]->latitude;
			$data['bin_address']	=	$complaint[0]->bin_address;
			$data['c_time']			=	$complaint[0]->c_time;
			$data['c_type']			=	$complaint[0]->c_type;
			$data['c_date']			=	$complaint[0]->c_date;
			$data['status']			=	$complaint[0]->status;
			$data['token_id'] 		= 	$complaint[0]->token_id;

				if($_POST){
				
				    $data['c_number'] 		= $this->input->post('c_number');
				    $data['c_details']   	= $this->input->post('c_details');
					$upload_map_image 		=$this->model_users->upload('image_path');
						if($upload_map_image)
						$data['image_path'] = $upload_map_image['upload_data']['file_name'];
				    $data['longitude']   	= $this->input->post('longitude');
				    $data['latitude']  		= $this->input->post('latitude');
				    $data['bin_address']  	= $this->input->post('bin_address');
					$data['status']  	= $this->input->post('status');
				    $data['c_date']  = date("Y-m-d");
				    $data['c_time']  = date("h:i:sa");
				    $data['c_type']  = $this->input->post('c_type');
				    
			// status

			// idate(format)// 
			$this->load->library('Push');
			$this->load->library('Firebase');
			$Push = new Push();
			$Firebase = new Firebase();

        $payload = array();
        $payload['team'] = 'PK';
        $payload['score'] = '5.6';

        $title = isset($_POST['c_number']) ? $_POST['c_number'] : '';
        
        $message = isset($_POST['status']) ? $_POST['status'] : '';
        
        $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
        
        $include_image = isset($_POST['include_image']) ? TRUE : FALSE;

        $Push->setTitle($title);
        $Push->setMessage($message);
        if ($include_image) {
            $Push->setImage('http://api.androidhive.info/images/minion.jpg');
        } else {
            $Push->setImage('');
        }
        $Push->setIsBackground(FALSE);
        $Push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $Push->getPush();
            $response = $Firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $Push->getPush();
            $regId = isset($_POST['token_id']) ? $_POST['token_id'] : '';
            $response = $Firebase->send($regId, $json);
        }
			$data = array();
		        $data['status'] = $this->input->post('status');
		        $data['token_id'] = $complaint[0]->token_id;
		        
				$this->model_users->doUpdateSingleRecord('complaint','c_id', $param2, $data);
				$Push->setMessage($data);
				$Firebase->send($data['token_id'],$data['status']);
						redirect('main/web_comp/list');
				}
			break;

			case 'pedit':
			$view = "update_comp";
			
			$complaint	=	$this->model_users->get_single_account_complaint($param2);
			
			$data['c_number']		=	$complaint[0]->c_number;
			$data['c_details']		=	$complaint[0]->c_details;
			$data['image_path']		=	$complaint[0]->image_path;
			$data['longitude']		=	$complaint[0]->longitude;
			$data['latitude']		=	$complaint[0]->latitude;
			$data['bin_address']	=	$complaint[0]->bin_address;
			$data['c_time']			=	$complaint[0]->c_time;
			$data['c_type']			=	$complaint[0]->c_type;
			$data['c_date']			=	$complaint[0]->c_date;
			$data['status']			=	$complaint[0]->status;
			$data['token_id'] 		= $complaint[0]->token_id;
				if($_POST){
				    $data['c_number'] 		= $this->input->post('c_number');
				    $data['c_details']   	= $this->input->post('c_details');
					$upload_map_image 		=$this->model_users->upload('image_path');
						if($upload_map_image)
						$data['image_path'] = $upload_map_image['upload_data']['file_name'];
				    $data['longitude']   	= $this->input->post('longitude');
				    $data['latitude']  		= $this->input->post('latitude');
				    $data['bin_address']  	= $this->input->post('bin_address');
					$data['status']  	= $this->input->post('status');
				    $data['c_date']  = date("Y-m-d");
				    $data['c_time']  = date("h:i:sa");
				    $data['c_type']  = $this->input->post('c_type');
				 		
			// idate(format)// 
			$this->load->library('Push');
			$this->load->library('Firebase');
			$Push = new Push();
			$Firebase = new Firebase();

        $payload = array();
        $payload['team'] = 'PK';
        $payload['score'] = '5.6';

        $title = isset($_POST['title']) ? $_POST['title'] : '';
        
        $message = isset($_POST['status']) ? $_POST['status'] : '';
        
        $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
        
        $include_image = isset($_POST['include_image']) ? TRUE : FALSE;

        $Push->setTitle($title);
        $Push->setMessage($message);
        if ($include_image) {
            $Push->setImage('http://api.androidhive.info/images/minion.jpg');
        } else {
            $Push->setImage('');
        }
        $Push->setIsBackground(FALSE);
        $Push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $Push->getPush();
            $response = $Firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $Push->getPush();
            $regId = isset($_POST['token_id']) ? $_POST['token_id'] : '';
            $response = $Firebase->send($regId, $json);
        }
			$data = array();
		        $data['status'] = $this->input->post('status');
		        $data['token_id'] = $complaint[0]->token_id;
		       
				$this->model_users->doUpdateSingleRecord('complaint','c_id', $param2, $data);
				$Push->setMessage($data);
				$Firebase->send($data['token_id'],$data['status']);			 
						redirect('main/web_comp/pending');
				
				}
			break;

			case 'iedit':
			$view = "update_comp";

			$complaint	=	$this->model_users->get_single_account_complaint($param2);
			
			$data['c_number']		=	$complaint[0]->c_number;
			$data['c_details']		=	$complaint[0]->c_details;
			$data['image_path']		=	$complaint[0]->image_path;
			$data['longitude']		=	$complaint[0]->longitude;
			$data['latitude']		=	$complaint[0]->latitude;
			$data['bin_address']	=	$complaint[0]->bin_address;
			$data['c_time']			=	$complaint[0]->c_time;
			$data['c_type']			=	$complaint[0]->c_type;
			$data['c_date']			=	$complaint[0]->c_date;
			$data['status']			=	$complaint[0]->status;
			$data['token_id'] 		= $complaint[0]->token_id;
				if($_POST){
					
				    $data['c_number'] 		= $this->input->post('c_number');
				    $data['c_details']   	= $this->input->post('c_details');
					$upload_map_image 		=$this->model_users->upload('image_path');
						if($upload_map_image)
						$data['image_path'] = $upload_map_image['upload_data']['file_name'];
				    $data['longitude']   	= $this->input->post('longitude');
				    $data['latitude']  		= $this->input->post('latitude');
				    $data['bin_address']  	= $this->input->post('bin_address');
					$data['status']  	= $this->input->post('status');
				    $data['c_date']  = date("Y-m-d");
				    $data['c_time']  = date("h:i:sa");
				    $data['c_type']  = $this->input->post('c_type');
				 
			// idate(format)// 
			$this->load->library('Push');
			$this->load->library('Firebase');
			$Push = new Push();
			$Firebase = new Firebase();

        $payload = array();
        $payload['team'] = 'PK';
        $payload['score'] = '5.6';

        $title = isset($_POST['title']) ? $_POST['title'] : '';
        
        $message = isset($_POST['status']) ? $_POST['status'] : '';
        
        $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
        
        $include_image = isset($_POST['include_image']) ? TRUE : FALSE;

        $Push->setTitle($title);
        $Push->setMessage($message);
        if ($include_image) {
            $Push->setImage('http://api.androidhive.info/images/minion.jpg');
        } else {
            $Push->setImage('');
        }
        $Push->setIsBackground(FALSE);
        $Push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $Push->getPush();
            $response = $Firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $Push->getPush();
            $regId = isset($_POST['token_id']) ? $_POST['token_id'] : '';
            $response = $Firebase->send($regId, $json);
        }
			$data = array();
		        $data['status'] = $this->input->post('status');
		        $data['token_id'] = $complaint[0]->token_id;
		        
				$this->model_users->doUpdateSingleRecord('complaint','c_id', $param2, $data);
				$Push->setMessage($data);
				$Firebase->send($data['token_id'],$data['status']);				 
						redirect('main/web_comp/in_progress');
					
				}
			break;

			case 'uedit':
			$view = "update_comp";
			
			$complaint	=	$this->model_users->get_single_account_complaint($param2);
			
			$data['c_number']		=	$complaint[0]->c_number;
			$data['c_details']		=	$complaint[0]->c_details;
			$data['image_path']		=	$complaint[0]->image_path;
			$data['longitude']		=	$complaint[0]->longitude;
			$data['latitude']		=	$complaint[0]->latitude;
			$data['bin_address']	=	$complaint[0]->bin_address;
			$data['c_time']			=	$complaint[0]->c_time;
			$data['c_type']			=	$complaint[0]->c_type;
			$data['c_date']			=	$complaint[0]->c_date;
			$data['status']			=	$complaint[0]->status;
			$data['token_id'] 		=   $complaint[0]->token_id;
				if($_POST){
					
				    $data['c_number'] 		= $this->input->post('c_number');
				    $data['c_details']   	= $this->input->post('c_details');
					$upload_map_image 		=$this->model_users->upload('image_path');
						if($upload_map_image)
						$data['image_path'] = $upload_map_image['upload_data']['file_name'];
				    $data['longitude']   	= $this->input->post('longitude');
				    $data['latitude']  		= $this->input->post('latitude');
				    $data['bin_address']  	= $this->input->post('bin_address');
					$data['status']  	= $this->input->post('status');
				    $data['c_date']  = date("Y-m-d");
				    $data['c_time']  = date("h:i:sa");
				    $data['c_type']  = $this->input->post('c_type');
				 
			// idate(format)// 
			$this->load->library('Push');
			$this->load->library('Firebase');
			$Push = new Push();
			$Firebase = new Firebase();

        $payload = array();
        $payload['team'] = 'PK';
        $payload['score'] = '5.6';

        $title = isset($_POST['title']) ? $_POST['title'] : '';
        
        $message = isset($_POST['status']) ? $_POST['status'] : '';
        
        $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
        
        $include_image = isset($_POST['include_image']) ? TRUE : FALSE;

        $Push->setTitle($title);
        $Push->setMessage($message);
        if ($include_image) {
            $Push->setImage('http://api.androidhive.info/images/minion.jpg');
        } else {
            $Push->setImage('');
        }
        $Push->setIsBackground(FALSE);
        $Push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $Push->getPush();
            $response = $Firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $Push->getPush();
            $regId = isset($_POST['token_id']) ? $_POST['token_id'] : '';
            $response = $Firebase->send($regId, $json);
        }
				$data = array();
		        $data['status'] = $this->input->post('status');
		        $data['token_id'] = $complaint[0]->token_id;
		        
				$this->model_users->doUpdateSingleRecord('complaint','c_id', $param2, $data);
				$Push->setMessage($data);
				$Firebase->send($data['token_id'],$data['status']);				 
						redirect('main/web_comp/under_review_list');
				}
			break;

			case 'delete':
			$view = "list";
			$this->model_users->doDeleteSingleRecord('complaint','c_id', $param2);
				redirect('main/web_comp/list');
			break;
			case 'cdelete':
			$view = "list";
			$this->model_users->doDeleteSingleRecord('complaint','c_id', $param2);
				redirect('main/web_comp/completed');
			break;
			case 'pdelete':
			$view = "list";
			$this->model_users->doDeleteSingleRecord('complaint','c_id', $param2);
				redirect('main/web_comp/pending');
			break;
			case 'idelete':
			$view = "list";
			$this->model_users->doDeleteSingleRecord('complaint','c_id', $param2);
				redirect('main/web_comp/in_progress');
			break;
			case 'udelete':
			$view = "list";
			$this->model_users->doDeleteSingleRecord('complaint','c_id', $param2);
				redirect('main/web_comp/under_review');
			break;
			
			case 'deleteuser':
			$this->model_users->doDeleteSingleRecord('account','account_id', $param2);
				redirect('main/all_users');
			break;

			case 'list':
			$view = "list";
			$data['multiListingData']	=	$this->model_users->get_all();
			//echo '<pre>';print_r($data['multiListingData']);die;
			break;
			
			case 'in_progress':
			$view = "in_progress_list";
			$data['multiListingData']	=	$this->model_users->select_all_in_progress_list("complaint");	
			
			break;
			
			case 'completed':
			$view = "completed_list";
			$data['multiListingData']	=	$this->model_users->select_all_completed_list("complaint");	
			
			break;
			
			case 'pending':
			$view = "pending_list";
			$data['multiListingData']	=	$this->model_users->select_all_pending_list("complaint");	
				
			break;

			case 'under_review':
			$view = "under_review_list";
			$data['multiListingData']	=	$this->model_users->select_all_under_review_list("complaint");	
				
			break;
			
			default:
			$view = "list";
			$data['multiListingData']	=	$this->model_users->get_all();
			
			break;
			
		}
		
        $this->load->view('template/header',$data);
        $this->load->view('user/'.$view);
        $this->load->view('template/footer-custom');
        }else{
		redirect('main/login_validation');
	  }
}

public function admin_complaint($param1 = NULL, $param2 = NULL  ){
 if($this->session->userdata('is_logged_in')){
		$data	=	'';
		//$data['active']		=	'web_comp';
		
		switch($param1){
			
			case 'add':
			$view = 'add_comp';
			//$data1['active']		=	'web_comp';
				if($_POST){
				    $data['c_number'] = $this->input->post('c_number');
				    $data['c_details']   = $this->input->post('c_details');
					$decoded_string = base64_decode($this->input->post('image_path'));
					$image_path = './uploads/map/'.$data['c_number'].'.jpeg';
					$data['image_path'] = $image_path; //$this->model_users->upload('image_path');
					file_put_contents($image_path, $decoded_string);
				    $data['longitude']   = $this->input->post('longitude');
				    $data['latitude']  = $this->input->post('latitude');
				    $data['bin_address']  = $this->input->post('bin_address');
					$data['status']  	= "pendingreview";//$this->input->post('status');
				    $data['c_date']  = date("Y-m-d");
				    $data['c_time']  = date("h:i:sa");
				    $data['c_type']  = $this->input->post('c_type');
					if($this->db->insert('complaint',$data)){
						echo json_encode("Successfully Registered");
					   }
					   else{
						echo json_encode("Complaint Faild");   
					   }
				}
			
			break;
			case 'edit':
			$view = "update_comp";
			
			$complaint	=	$this->model_users->get_single_account_complaint($param2);
						
			$data['c_number']		=	$complaint[0]->c_number;
			$data['c_details']		=	$complaint[0]->c_details;
			$data['image_path']		=	$complaint[0]->image_path;
			$data['longitude']		=	$complaint[0]->longitude;
			$data['latitude']		=	$complaint[0]->latitude;
			$data['bin_address']	=	$complaint[0]->bin_address;
			$data['c_time']			=	$complaint[0]->c_time;
			$data['c_type']			=	$complaint[0]->c_type;
			$data['c_date']			=	$complaint[0]->c_date;
			$data['status']			=	$complaint[0]->status;
			$data['token_id'] 		= 	$complaint[0]->token_id;

				if($_POST){
				
				    $data['c_number'] 		= $this->input->post('c_number');
				    $data['c_details']   	= $this->input->post('c_details');
					$upload_map_image 		=$this->model_users->upload('image_path');
						if($upload_map_image)
						$data['image_path'] = $upload_map_image['upload_data']['file_name'];
				    $data['longitude']   	= $this->input->post('longitude');
				    $data['latitude']  		= $this->input->post('latitude');
				    $data['bin_address']  	= $this->input->post('bin_address');
					$data['status']  	= $this->input->post('status');
				    $data['c_date']  = date("Y-m-d");
				    $data['c_time']  = date("h:i:sa");
				    $data['c_type']  = $this->input->post('c_type');
				    
			// status

			// idate(format)// 
			$this->load->library('Push');
			$this->load->library('Firebase');
			$Push = new Push();
			$Firebase = new Firebase();

        $payload = array();
        $payload['team'] = 'PK';
        $payload['score'] = '5.6';

        $title = isset($_POST['c_number']) ? $_POST['c_number'] : '';
        
        $message = isset($_POST['status']) ? $_POST['status'] : '';
        
        $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
        
        $include_image = isset($_POST['include_image']) ? TRUE : FALSE;

        $Push->setTitle($title);
        $Push->setMessage($message);
        if ($include_image) {
            $Push->setImage('http://api.androidhive.info/images/minion.jpg');
        } else {
            $Push->setImage('');
        }
        $Push->setIsBackground(FALSE);
        $Push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $Push->getPush();
            $response = $Firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $Push->getPush();
            $regId = isset($_POST['token_id']) ? $_POST['token_id'] : '';
            $response = $Firebase->send($regId, $json);
        }
			$data = array();
		        $data['status'] = $this->input->post('status');
		        $data['token_id'] = $complaint[0]->token_id;
		        
				$this->model_users->doUpdateSingleRecord('complaint','c_id', $param2, $data);
				$Push->setMessage($data);
				$Firebase->send($data['token_id'],$data['status']);
						redirect('main/web_comp/list');
				}
			break;

			case 'pedit':
			$view = "update_comp";
			
			$complaint	=	$this->model_users->get_single_account_complaint($param2);
			
			$data['c_number']		=	$complaint[0]->c_number;
			$data['c_details']		=	$complaint[0]->c_details;
			$data['image_path']		=	$complaint[0]->image_path;
			$data['longitude']		=	$complaint[0]->longitude;
			$data['latitude']		=	$complaint[0]->latitude;
			$data['bin_address']	=	$complaint[0]->bin_address;
			$data['c_time']			=	$complaint[0]->c_time;
			$data['c_type']			=	$complaint[0]->c_type;
			$data['c_date']			=	$complaint[0]->c_date;
			$data['status']			=	$complaint[0]->status;
			$data['token_id'] 		= $complaint[0]->token_id;
				if($_POST){
				    $data['c_number'] 		= $this->input->post('c_number');
				    $data['c_details']   	= $this->input->post('c_details');
					$upload_map_image 		=$this->model_users->upload('image_path');
						if($upload_map_image)
						$data['image_path'] = $upload_map_image['upload_data']['file_name'];
				    $data['longitude']   	= $this->input->post('longitude');
				    $data['latitude']  		= $this->input->post('latitude');
				    $data['bin_address']  	= $this->input->post('bin_address');
					$data['status']  	= $this->input->post('status');
				    $data['c_date']  = date("Y-m-d");
				    $data['c_time']  = date("h:i:sa");
				    $data['c_type']  = $this->input->post('c_type');
				 		
			// idate(format)// 
			$this->load->library('Push');
			$this->load->library('Firebase');
			$Push = new Push();
			$Firebase = new Firebase();

        $payload = array();
        $payload['team'] = 'PK';
        $payload['score'] = '5.6';

        $title = isset($_POST['title']) ? $_POST['title'] : '';
        
        $message = isset($_POST['status']) ? $_POST['status'] : '';
        
        $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
        
        $include_image = isset($_POST['include_image']) ? TRUE : FALSE;

        $Push->setTitle($title);
        $Push->setMessage($message);
        if ($include_image) {
            $Push->setImage('http://api.androidhive.info/images/minion.jpg');
        } else {
            $Push->setImage('');
        }
        $Push->setIsBackground(FALSE);
        $Push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $Push->getPush();
            $response = $Firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $Push->getPush();
            $regId = isset($_POST['token_id']) ? $_POST['token_id'] : '';
            $response = $Firebase->send($regId, $json);
        }
			$data = array();
		        $data['status'] = $this->input->post('status');
		        $data['token_id'] = $complaint[0]->token_id;
		       
				$this->model_users->doUpdateSingleRecord('complaint','c_id', $param2, $data);
				$Push->setMessage($data);
				$Firebase->send($data['token_id'],$data['status']);			 
						redirect('main/web_comp/pending');
				
				}
			break;

			case 'iedit':
			$view = "update_comp";

			$complaint	=	$this->model_users->get_single_account_complaint($param2);
			
			$data['c_number']		=	$complaint[0]->c_number;
			$data['c_details']		=	$complaint[0]->c_details;
			$data['image_path']		=	$complaint[0]->image_path;
			$data['longitude']		=	$complaint[0]->longitude;
			$data['latitude']		=	$complaint[0]->latitude;
			$data['bin_address']	=	$complaint[0]->bin_address;
			$data['c_time']			=	$complaint[0]->c_time;
			$data['c_type']			=	$complaint[0]->c_type;
			$data['c_date']			=	$complaint[0]->c_date;
			$data['status']			=	$complaint[0]->status;
			$data['token_id'] 		= $complaint[0]->token_id;
				if($_POST){
					
				    $data['c_number'] 		= $this->input->post('c_number');
				    $data['c_details']   	= $this->input->post('c_details');
					$upload_map_image 		=$this->model_users->upload('image_path');
						if($upload_map_image)
						$data['image_path'] = $upload_map_image['upload_data']['file_name'];
				    $data['longitude']   	= $this->input->post('longitude');
				    $data['latitude']  		= $this->input->post('latitude');
				    $data['bin_address']  	= $this->input->post('bin_address');
					$data['status']  	= $this->input->post('status');
				    $data['c_date']  = date("Y-m-d");
				    $data['c_time']  = date("h:i:sa");
				    $data['c_type']  = $this->input->post('c_type');
				 
			// idate(format)// 
			$this->load->library('Push');
			$this->load->library('Firebase');
			$Push = new Push();
			$Firebase = new Firebase();

        $payload = array();
        $payload['team'] = 'PK';
        $payload['score'] = '5.6';

        $title = isset($_POST['title']) ? $_POST['title'] : '';
        
        $message = isset($_POST['status']) ? $_POST['status'] : '';
        
        $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
        
        $include_image = isset($_POST['include_image']) ? TRUE : FALSE;

        $Push->setTitle($title);
        $Push->setMessage($message);
        if ($include_image) {
            $Push->setImage('http://api.androidhive.info/images/minion.jpg');
        } else {
            $Push->setImage('');
        }
        $Push->setIsBackground(FALSE);
        $Push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $Push->getPush();
            $response = $Firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $Push->getPush();
            $regId = isset($_POST['token_id']) ? $_POST['token_id'] : '';
            $response = $Firebase->send($regId, $json);
        }
			$data = array();
		        $data['status'] = $this->input->post('status');
		        $data['token_id'] = $complaint[0]->token_id;
		        
				$this->model_users->doUpdateSingleRecord('complaint','c_id', $param2, $data);
				$Push->setMessage($data);
				$Firebase->send($data['token_id'],$data['status']);				 
						redirect('main/web_comp/in_progress');
					
				}
			break;

			case 'uedit':
			$view = "update_comp";
			
			$complaint	=	$this->model_users->get_single_account_complaint($param2);
			
			$data['c_number']		=	$complaint[0]->c_number;
			$data['c_details']		=	$complaint[0]->c_details;
			$data['image_path']		=	$complaint[0]->image_path;
			$data['longitude']		=	$complaint[0]->longitude;
			$data['latitude']		=	$complaint[0]->latitude;
			$data['bin_address']	=	$complaint[0]->bin_address;
			$data['c_time']			=	$complaint[0]->c_time;
			$data['c_type']			=	$complaint[0]->c_type;
			$data['c_date']			=	$complaint[0]->c_date;
			$data['status']			=	$complaint[0]->status;
			$data['token_id'] 		=   $complaint[0]->token_id;
				if($_POST){
					
				    $data['c_number'] 		= $this->input->post('c_number');
				    $data['c_details']   	= $this->input->post('c_details');
					$upload_map_image 		=$this->model_users->upload('image_path');
						if($upload_map_image)
						$data['image_path'] = $upload_map_image['upload_data']['file_name'];
				    $data['longitude']   	= $this->input->post('longitude');
				    $data['latitude']  		= $this->input->post('latitude');
				    $data['bin_address']  	= $this->input->post('bin_address');
					$data['status']  	= $this->input->post('status');
				    $data['c_date']  = date("Y-m-d");
				    $data['c_time']  = date("h:i:sa");
				    $data['c_type']  = $this->input->post('c_type');
				 
			// idate(format)// 
			$this->load->library('Push');
			$this->load->library('Firebase');
			$Push = new Push();
			$Firebase = new Firebase();

        $payload = array();
        $payload['team'] = 'PK';
        $payload['score'] = '5.6';

        $title = isset($_POST['title']) ? $_POST['title'] : '';
        
        $message = isset($_POST['status']) ? $_POST['status'] : '';
        
        $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
        
        $include_image = isset($_POST['include_image']) ? TRUE : FALSE;

        $Push->setTitle($title);
        $Push->setMessage($message);
        if ($include_image) {
            $Push->setImage('http://api.androidhive.info/images/minion.jpg');
        } else {
            $Push->setImage('');
        }
        $Push->setIsBackground(FALSE);
        $Push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $Push->getPush();
            $response = $Firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $Push->getPush();
            $regId = isset($_POST['token_id']) ? $_POST['token_id'] : '';
            $response = $Firebase->send($regId, $json);
        }
				$data = array();
		        $data['status'] = $this->input->post('status');
		        $data['token_id'] = $complaint[0]->token_id;
		        
				$this->model_users->doUpdateSingleRecord('complaint','c_id', $param2, $data);
				$Push->setMessage($data);
				$Firebase->send($data['token_id'],$data['status']);				 
						redirect('main/web_comp/under_review_list');
				}
			break;

			case 'delete':
			$view = "list";
			$this->model_users->doDeleteSingleRecord('complaint','c_id', $param2);
				redirect('main/web_comp/list');
			break;
			case 'cdelete':
			$view = "list";
			$this->model_users->doDeleteSingleRecord('complaint','c_id', $param2);
				redirect('main/web_comp/completed');
			break;
			case 'pdelete':
			$view = "list";
			$this->model_users->doDeleteSingleRecord('complaint','c_id', $param2);
				redirect('main/web_comp/pending');
			break;
			case 'idelete':
			$view = "list";
			$this->model_users->doDeleteSingleRecord('complaint','c_id', $param2);
				redirect('main/web_comp/in_progress');
			break;
			case 'udelete':
			$view = "list";
			$this->model_users->doDeleteSingleRecord('complaint','c_id', $param2);
				redirect('main/web_comp/under_review');
			break;
			
			case 'deleteuser':
			$this->model_users->doDeleteSingleRecord('account','account_id', $param2);
				redirect('main/all_users');
			break;

			case 'list':
			$view = "list";
			$data['multiListingData']	=	$this->model_users->get_all();
			//echo '<pre>';print_r($data['multiListingData']);die;
			break;
			
			case 'in_progress':
			$view = "in_progress_list";
			$data['multiListingData']	=	$this->model_users->select_all_in_progress_list("complaint");	
			
			break;
			
			case 'completed':
			$view = "completed_list";
			$data['multiListingData']	=	$this->model_users->select_all_completed_list("complaint");	
			
			break;
			
			case 'pending':
			$view = "pending_list";
			$data['multiListingData']	=	$this->model_users->select_all_pending_list("complaint");	
				
			break;

			case 'under_review':
			$view = "under_review_list";
			$data['multiListingData']	=	$this->model_users->select_all_under_review_list("complaint");	
				
			break;
			
			default:
			$view = "list";
			$data['multiListingData']	=	$this->model_users->get_all();
			
			break;
			
		}
		
        $this->load->view('template/header',$data);
        $this->load->view('admin/'.$view);
        $this->load->view('template/footer-custom');
        }else{
		redirect('main/login_validation_admin');
	  }
}
  
    public function restricted(){   
	$this->load->view('template/header-custom');
	$this->load->view('template/menu');
	$this->load->view('restricted');
	$this->load->view('template/footer');
   
   }
   public function signup(){
   
   	redirect('user/registration');

   }
   public function all_users($param1 = NULL, $param2 = NULL ){
 	if($this->session->userdata('is_logged_in')){
	switch ($param1) {
		case 'deleteuser':
			# code...
		$view = 'users';
			$this->model_users->doDeleteSingleRecord('account','account_id', $param2);
				redirect('main/all_users');
			break;
		
		default:
			# code...
		$view = 'users';
			$data['multiListingData']	=	$this->model_users->users_list_all("account");
			break;
	}
	
	//print_r($data['multiListingData'])
    $this->load->view('template/header',$data);
    $this->load->view($view);
    $this->load->view('template/footer-custom'); 
   }else{
		redirect('main/login_validation');
	  }
	}
	public function login_validations(){
   
   $this->load->library('form_validation');
   $this->form_validation->set_rules('mobilenumber','Mobile','required|trim|xss_clean|callback_validate_credentials');
   $this->form_validation->set_rules('password','Password','required|sha1|trim');
   $this->db->where('roll',0);
   if($this->form_validation->run()){
	   $data=array(
	   	   'status' => 'Success',   
		   'mobilenumber'=>$this->input->post('mobilenumber'),
		   'is_logged_in'=>1,
       	   'roll'=>0
       );
     	if($data['roll'] == 0){
     		// update Token ID
     		$update['token_id'] = $this->input->post('token_id');
			$update['mobilenumber'] = $this->input->post('mobilenumber'); 
			$this->model_users->doUpdateSingleRecord('account','mobilenumber', $this->input->post('mobilenumber'), $update);
			    
 		 echo json_encode($data);
	      //$this->session->set_userdata($data);
	      //redirect('main/members');
	  }else{
	  	redirect('main/login_validation');
	  }
	
   }else{
	   $data=array(
	   	   'status' => 'Incorrect Phone Number or Password',   
		   'is_logged_in'=>0
       );
    	echo json_encode($data);
    	return false;
   }
   
 }

 public function validate_credentials(){

  $this->load->model('model_users');
   if($this->model_users->can_log_ins()){
     return true;
   }else{
    return false;
   }
 }
  public function login_validation(){
   
   $this->load->library('form_validation');
   $this->form_validation->set_rules('mobilenumber','Mobile','required|trim|xss_clean|callback_validate_credentials');
   $this->form_validation->set_rules('password','Password','required|sha1|trim');
   $this->db->where('roll',1);
  
   if($this->form_validation->run()){
     $data=array(
     'mobilenumber'=>$this->input->post('mobilenumber'),
     'is_logged_in'=>1,
     'roll'=>1
       );
     	if($data['roll'] == 1 ){
 		 echo json_encode($data);
	      $this->session->set_userdata($data);
	      redirect('main/members');
	  }else{
	  	redirect('main/login_validation');
	  }
   
   }else{
    $this->load->view('login');
   }
   
 }

 public function login_validation_admin(){
   
   $this->load->library('form_validation');
   $this->form_validation->set_rules('mobilenumber','Mobile','required|trim|xss_clean|callback_validate_credentials');
   $this->form_validation->set_rules('password','Password','required|sha1|trim');
   $this->db->where('roll',2);
  
   if($this->form_validation->run()){
     $data=array(
     'mobilenumber'=>$this->input->post('mobilenumber'),
     'is_logged_in'=>1,
     'roll'=>2
       );
     	if($data['roll'] == 2 ){
 		
	      	$this->load->view('template/header-custom', $data);
	 		$this->load->view('template/menu');
	    	$this->load->view('members');
	    	$this->load->view('template/footer-custom');
	  }else{
	  	redirect('main/login_validation_admin');
	  }
   
   }else{
    $this->load->view('login');
   }
   
 }

 
 public function validate_credential(){
 
  $this->load->model('model_users');
   if($this->model_users->can_log_in()){
     return true;
   }else{
  
  $this->form_validation->set_message('validate_credentials','Incorrect Mobile Number or password');
    return false;
   }
 }

  public function logout(){
	
	$this->session->sess_destroy();
	redirect('main/login_validation');
	}
   

}

