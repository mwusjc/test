<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		date_default_timezone_set('America/Toronto');

    $this->load->view("header", array('title'=>'Highland Farms | Fresh Produce Supermarkets in Toronto'));
    $this->load->view("home");
		$this->load->view("footer");
	}
}
