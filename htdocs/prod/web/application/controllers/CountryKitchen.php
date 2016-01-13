<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CountryKitchen extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->data = new stdClass();
        $this->load->model("Products_model","products_model");
    }
    public function index()
    {
        $this->data->products_categories = $this->products_model->get_categories();
        $this->data->products = $this->products_model->get(null,null,'short');
        $this->load->view("header", array('title'=>'Country Kitchen Label | Exclusive to Highland Farms'));
        $this->load->view("country-kitchen",$this->data);
        $this->load->view("footer");
    }
}
