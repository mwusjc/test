<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopping extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->data = new stdClass();
    }
    public function index()
    {
        $this->load->view("header");
        $this->load->view("shopping/cart",$this->data);
        $this->load->view("footer");
    }
}
