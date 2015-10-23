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
        $this->data->recipes_categories = $this->recipes_model->get_categories();
        $this->data->recipes = $this->recipes_model->get(null,null,'short');
        $this->load->view("header");
        $this->load->view("recipes", $this->data);
        $this->load->view("footer");
    }

    public function details($slug) {
        (int) $slug;
        if(empty($slug)) redirect("/recipes/");

        $this->data->recipe = $this->recipes_model->get($slug,null,"long")->{$slug};
        
        $this->data->recommended = $this->recipes_model->get_recommended($slug);

        $this->load->view("header");
        $this->load->view("recipe", $this->data);
        $this->load->view("footer"); 
    }
}
