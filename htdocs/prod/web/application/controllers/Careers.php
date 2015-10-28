<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Careers extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index()
    {	
    	
    	$str = file_get_contents('./assets/data/jobs/listing.json');
        $json = json_decode($str, true);
		
	   	$this->data['joblistings'] = $json;
        $this->load->view("header");
        $this->load->view("careers", $this->data);
        $this->load->view("footer");
    }

    public function details($slug) {
        (int) $slug;
        if(empty($slug)) redirect("/careers/");

        $data = array();
        $str = file_get_contents('./assets/data/jobs/listing.json');
        $json = json_decode($str, true);

        if ($json && isset($json[$slug])) {
        	$data = $json[$slug];
        }
        
        $this->data['details'] = $data;

		$this->load->helper('email');
        $this->load->view("header");
        $this->load->view("job", $this->data);
        $this->load->view("footer"); 
    }

}
