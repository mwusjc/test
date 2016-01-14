<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopping extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->data = new stdClass();
    }
    public function index()
    {
        $this->data->items = $this->cart->contents();
        $this->load->view("header", array('title'=>'Shopping List | Add. Download. Print | Highland Farms', "desc" => "Add from our extensive range of fresh produce, meat, seafood, baked goods, prepared foods, party platters and more. Print before visiting one of our stores!"));
        $this->load->view("shopping/cart",$this->data);
        $this->load->view("footer");
    }

    public function add() {
        // $id = $_POST["id"];
        // $this->load->model("Products_model",'products_model');

        // $item =  $this->products_model->get($id)->$id;

        // die();
        // $data = array(
        //     "id" => $id,
        //     "qty" => 1,
        //     'price' => null,
        //     'name' => $item->name,
        //     'options' => array()
        // );
        // $insert = $this->cart->insert($data);

        // if($insert) {
        //     $this->output->set_status_header('200');
        //     die();
        // }
    }
}
