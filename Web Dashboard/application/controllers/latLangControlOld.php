<?php
class latLangControl extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('getLatLong');
    }

    function index()
    {
        $data['base_url'] = base_url();
        $data['title'] = 'Google Map WSSP | Admin';
        $data['action']= site_url().'index/';

        $results = $this->getLatLong->get();
        $count = 0;
		//echo '<pre>';print_r($results->result());die;
        foreach($results->result() as $row)
        {
            $data['latlong'][$count]['lat'] = $row->lat;
            $data['latlong'][$count]['long'] = $row->lng;
			$data['latlong'][$count]['type'] = $row->type;
		/*	$data['latlong'][$count]['latitude'] = $row->latitude;
            $data['latlong'][$count]['longitude'] = $row->longitude;
			$data['latlong'][$count]['status'] = $row->status;
			$data['latlong'][$count]['image_path'] = $row->image_path;*/
            $count++;
        }
        $data['index']=$count;

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('map',$data);
        $this->load->view('template/footer');
    }

}
