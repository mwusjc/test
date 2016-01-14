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
        $recipesFile = @file_get_contents("assets/data/recipes/recipes.json");
        $this->data->recipes = json_encode($recipesFile);
        $this->load->view("header", array('title' => "Get Fresh Recipe Ideas Every Week | Highland Farms"));
        $this->load->view("recipesjson", $this->data);
        $this->load->view("footer");
    }

    public function details($slug)
    {
        $recipesFile = @file_get_contents("assets/data/recipes/recipes.json");
        $this->data->recipes = json_encode($recipesFile);
        $this->load->view("header");
        $this->load->view("recipejson", $this->data);
        $this->load->view("footer");
    }
}
