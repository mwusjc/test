<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flyer extends CI_Controller {

    public function index()
    {
        $this->load->view("header", array('title' => "Highland Farms Flyer | Read. Download. Subscribe Online", "desc" => "Highland farms flyer brings fresh savings and awesome weekly deals on groceries, meat, fruits, vegetables and more. Subscribe to our e-flyer to read it first!"));
        $this->load->view("flyer");
        $this->load->view("footer");
    }
}
