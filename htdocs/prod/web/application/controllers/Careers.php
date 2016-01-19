<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Careers extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index()
    {

    	$str = file_get_contents('./assets/data/jobs/listing.json');
        $json = json_decode($str, true);

	   	$this->data['joblistings'] = $json;
        $this->load->view("header", array('title'=>'Join Us | Start Fresh With a Career at Highland Farms', "desc" => "We are always looking for driven individuals to join our team. Working at one of our stores is more than a job. It's an opportunity to learn and grow."));
        $this->load->view("careers", $this->data);
        $this->load->view("footer");
    }

    public function details($slug) {

		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$config = array(
					   array(
							 'field'   => 'first',
							 'label'   => 'First Name',
							 'rules'   => 'required'
						  ),
					   array(
							 'field'   => 'last',
							 'label'   => 'Last Name',
							 'rules'   => 'required'
						  ),
					  array(
							 'field'   => 'email',
							 'label'   => 'Email',
							 'rules'   => 'required|valid_email'
						  ),
					   array(
							 'field'   => 'phone',
							 'label'   => 'Phone Number',
							 'rules'   => 'required'
						  ),
					   array(
							 'field'   => 'file_resume_val',
							 'label'   => 'Resume',
							 'rules'   => 'required'
						  )
					);

		$this->form_validation->set_rules($config);


        (int) $slug;
        if(empty($slug)) redirect("/careers/");

        $data = array();
        $str = file_get_contents('./assets/data/jobs/listing.json');
        $json = json_decode($str, true);

        if ($json && isset($json[$slug])) {
        	$data = $json[$slug];
        }

        $this->data['details'] = $data;

		$this->load->helper('email');
		$this->load->view("header");

		if ($this->form_validation->run())	{

			$to = "jobs@highlandfarms.on.ca";
			$from = $_POST['email'];
			$first = $_POST['first'];
			$last = $_POST['last'];
			$phone = $_POST['phone'];
			$location = $_POST['location'];
			$title = $_POST['title'];
			$id = $_POST['id'];
			$resume = isset($_POST['file_resume_val']) ? $_POST['file_resume_val'] : "";
			$coverletter = isset($_POST['file_coverletter_val']) ? $_POST['file_coverletter_val'] : "";

			$email = "Job application submission:<br/><br/>
							Job: $id - $title - $location<br/>
							Name: $first $last<br/>
							Email: $from<br/>
							Phone: $phone<br/><br/>
							Resume/Coverletter attached.

			";
			send_ses_email($to, "JOB APPLICATION: Submission", $email, $_FILES);

			$this->load->view("job-success", $this->data);
		}
		$this->load->view("job", $this->data);

		$this->load->view("footer");


    }

}
