<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recipes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->data = new stdClass();
        $this->load->model("Recipes_model","recipes_model");
    }

    public function index()
    {
        $this->load->view("header");
        $this->load->view("recipesjson");
        $this->load->view("footer");
    }

    public function details($slug) {

        $this->load->view("header");
        $this->load->view("recipejson");
        $this->load->view("footer");
    }
}
