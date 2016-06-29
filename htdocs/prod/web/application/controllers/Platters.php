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
        $plattersFile = @file_get_contents("assets/data/platters/platters.json");
        $this->data->platters = json_encode($plattersFile);
        $this->load->view("header", array('title'=>'Platters & Gifts For Your Next Event | Highland Farms', "desc" => "You have enough to worry about with your upcoming party. Leave the finger food to us. Ask in store for details."));
        $this->load->view("platters", $this->data);
        $this->load->view("footer");
    }

}
