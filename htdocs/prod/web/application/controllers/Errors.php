<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Errors extends CI_Controller {
    public function __construct() {
        parent::__construct(); 
    } 
 
    public function _404() { 
        $this->output->set_status_header('404'); 
        $this->load->view('header');
        $this->load->view('errors/404');
        $this->load->view('footer');
    } 
} 