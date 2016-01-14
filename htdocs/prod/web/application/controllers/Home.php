<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		date_default_timezone_set('America/Toronto');

    $recipesFile = @file_get_contents("assets/data/recipes/recipes.json");
    $recipes = json_encode($recipesFile);
    $this->load->view("header", array('title'=>'Highland Farms | Fresh Produce Supermarkets in Toronto'));
    $this->load->view("home", array('recipes'=>$recipes));
		$this->load->view("footer");
	}
}
