<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vaughan extends CI_Controller {

    public function index()
    {

        $this->load->view("header", array('title' => "A Fresh Look At All Our Store Departments | Highland Farms", "desc" => "Every shopping trip is a flavour adventure, with shelves and counters fully stocked with favourites from around the world. Our deli & meat counter is legendary!"));
        $this->load->view("vaughan-2");
        $this->load->view("footer");
    }
}
