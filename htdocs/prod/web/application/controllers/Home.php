<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		date_default_timezone_set('America/Toronto');

    $this->load->view("header");
    $this->load->view("home");
		$this->load->view("footer");
	}
}
