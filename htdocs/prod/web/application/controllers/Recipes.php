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
    		// echo $slug; die();
      //   (int) $slug;
      //   if(empty($slug)) redirect("/recipes/");

      //   $this->data->recipe = $this->recipes_model->get($slug,null,"long")->{$slug};

      //   $recipe = $this->recipes_model->get($slug)->{$slug};
      //   $currentCategory = $recipe->CategoryID;
      //   $this->data->recommended = $this->recipes_model->get_related($slug, $currentCategory);

        $this->load->view("header");
        $this->load->view("recipejson");
        $this->load->view("footer");
    }
}
