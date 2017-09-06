<?php
class  user extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('user_info');
		$this->load->model('model_users');
		$this->load->library('session');
		$this->baseurl=dirname(dirname(base_url()));
	}
	  function members(){
		$data['content']='success';
		 $this->load->view('v_content',$data);
		}
	   function index(){
	
		// $this->load->view('registration_form');
		 	
		$data['content']='v_content';

		$this->load->view('template/header-custom', $data);
 		$this->load->view('template/menu');
    	$this->load->view('registration_form');
    	$this->load->view('template/footer-custom');
		//$this->load->view('registration_form',$data);
	
		}
		
		function registration(){
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required');
		$this->form_validation->set_rules(
        'mobilenumber', 'Mobile number',
        'required|is_unique[account.mobilenumber]',
        array(
                $this->form_validation->set_message('is_unique', 'This %s is already registered.')
        )
		);
		
		$this->form_validation->set_rules('roll', 'Roll', 'trim|required');
		$this->form_validation->set_rules('emailad', 'Email Address', 'trim|required|valid_email|is_unique[account.emailad]',
        array(
                $this->form_validation->set_message('is_unique', 'This %s is already registered.')
        ));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');
		//$this->form_validation->set_message('is_unique', 'This %s is already registered.');
			if($this->form_validation->run() == FALSE)
			{
				$this->index();
			}
			
			else
			{			
				if($query = $this->user_info->system_is_creating_user())
				{
					redirect("main/login_validation");
					//$this->members();	
				}
				else
				{
					$this->index();			
				}
			}
		}

		function registration_app(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('mobilenumber', 'Mobile number', 'required|is_unique[account.mobilenumber]');
		$this->form_validation->set_rules('roll', 'Roll', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');

			if($this->form_validation->run() == FALSE) {
				$data=array(
				'status' => 'Already Registered !',   
				);
				echo json_encode($data);
				return;
			}
			if($query = $this->user_info->system_is_creating_user_for_app()) {
				
				echo "done";
			}
		}

		
	}