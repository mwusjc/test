<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CountryKitchen extends CI_Controller {

    public function index()
    {
        $this->load->view("header");
        $this->load->view("country-kitchen");
        $this->load->view("footer");
    }
}
