<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Platters extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->data = new stdClass();
        $this->load->model("Platters_model","platters_model");
    }
    public function index()
    {
        $this->data->platters_categories = $this->platters_model->get_categories();
        $this->data->platters = $this->platters_model->get(null,null,'short');
        $this->load->view("header");
        $this->load->view("platters", $this->data);
        $this->load->view("footer");
    }
 
}
