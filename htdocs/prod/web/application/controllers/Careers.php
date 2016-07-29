<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Careers extends CI_Controller {

    protected $jsonData;
    protected $jsonDataEncoded;

    public function __construct()
    {
        parent::__construct();        
        $this->jsonData = "[]"; //@file_get_contents('http://localhost:10010/v1/jobs');
        $this->jsonDataEncoded = json_encode($this->jsonData);
    }

    public function index()
    {
	   	$this->data['joblistings'] = $this->jsonDataEncoded;
      $this->load->view("header", array('title'=>'Join Us | Start Fresh With a Career at Highland Farms', "desc" => "We are always looking for driven individuals to join our team. Working at one of our stores is more than a job. It's an opportunity to learn and grow."));
      $this->load->view("careers", $this->data);
      $this->load->view("footer");
    }

    public function details($slug)
    {

  		$this->load->helper(array('form', 'url'));

      (int) $slug;
      if(empty($slug)) redirect("/careers/");

      $this->data['details'] = $this->jsonFileEncoded;

  		$this->load->view("header");
  		$this->load->view("job", $this->data);
  		$this->load->view("footer");


    }

}
