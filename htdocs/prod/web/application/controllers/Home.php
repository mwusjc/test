<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		date_default_timezone_set('America/Toronto');

    $this->load->view("header", array('title'=>'Highland Farms | Fresh Produce Supermarkets in Toronto', "desc" => "Freshness down every aisle: Fresh produce, meat, seafood, baked goods, prepared foods, organic and natural alternatives. Visit one of our locations today!"));
    $this->load->view("home");
		$this->load->view("footer");
	}
}
