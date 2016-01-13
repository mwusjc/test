<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visit extends CI_Controller {

    public function index()
    {
	    $this->load->helper('email');
        $this->load->view("header", array('title'=>'Store Locations & Hours | Contact Us | Highland Farms'));
        $this->load->view("visit-us");
        $this->load->view("footer");

    }
}
