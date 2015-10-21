<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flyer extends CI_Controller {

    public function index()
    {
        $this->load->view("header");
        $this->load->view("flyer");
        $this->load->view("footer");
    }
}
