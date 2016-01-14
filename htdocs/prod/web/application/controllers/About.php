<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

    public function index()
    {
        $this->load->view("header", array('title'=> 'About Us | It Starts With Freshness | Highland Farms'));
        $this->load->view("about");
        $this->load->view("footer");
    }

    public function privacy_policy() {
        $this->load->view("header", array('title'=>'Privacy Policy | Highland Farms'));
        $this->load->view("privacy-policy");
        $this->load->view("footer");
    }
    public function disclaimer() {
        $this->load->view("header", array('title'=>'Disclaimer | Highland Farms'));
        $this->load->view("disclaimer");
        $this->load->view("footer");
    }
    public function accessibility() {
        $this->load->view("header", array('title'=>'Accessible Customer Service Policy | Highland Farms'));
        $this->load->view("accessibility");
        $this->load->view("footer");
    }

    public function originals() {
        $this->load->view("header");
        $this->load->view("originals");
        $this->load->view("footer");
    }
}
