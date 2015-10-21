<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

    public function index()
    {
        $this->load->view("header");
        $this->load->view("about");
        $this->load->view("footer");
    }

    public function privacy_policy() {
        $this->load->view("header");
        $this->load->view("privacy-policy");
        $this->load->view("footer");
    }
    public function disclaimer() {
        $this->load->view("header");
        $this->load->view("disclaimer");
        $this->load->view("footer");
    }
    public function accessibility() {
        $this->load->view("header");
        $this->load->view("accessibility");
        $this->load->view("footer");
    }
}
