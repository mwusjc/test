<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InsideStore extends CI_Controller {

    public function index()
    {

        $this->load->view("header", ['title' => "A Fresh Look At All Our Store Departments | Highland Farms"]);
        $this->load->view("inside-store");
        $this->load->view("footer");
    }
}
