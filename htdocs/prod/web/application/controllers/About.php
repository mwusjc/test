<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

    public function index()
    {
        $this->load->view("header", array('title'=> 'About Us | It Starts With Freshness | Highland Farms', "desc" => "Since we first opened the doors in 1963, our family has proudly offered a huge selection of quality products and a firm commitment to customer service."));
        $this->load->view("about");
        $this->load->view("footer");
    }

    public function privacy_policy() {
        $this->load->view("header", array('title'=>'Privacy Policy | Highland Farms', "desc" => "Protecting the privacy and confidentiality of your personal information has always been a fundamental principle in our relationship with you."));
        $this->load->view("privacy-policy");
        $this->load->view("footer");
    }
    public function disclaimer() {
        $this->load->view("header", array('title'=>'Disclaimer | Highland Farms', "desc" => "This Website is owned and provided by Highland Farms, and is prepared solely for your interest, information and education."));
        $this->load->view("disclaimer");
        $this->load->view("footer");
    }
    public function accessibility() {
        $this->load->view("header", array('title'=>'Accessible Customer Service Policy | Highland Farms', "desc" => "Highland Farms is committed to providing exceptional and accessible service for its customers. "));
        $this->load->view("accessibility");
        $this->load->view("footer");
    }

    public function originals() {
        $this->load->view("header");
        $this->load->view("originals");
        $this->load->view("footer");
    }
}
