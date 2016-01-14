<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flyer extends CI_Controller {

    public function index()
    {
        $this->load->view("header", array('title' => "Highland Farms Flyer | Read. Download. Subscribe Online"));
        $this->load->view("flyer");
        $this->load->view("footer");
    }
}
