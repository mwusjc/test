<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visit extends CI_Controller {

    public function index()
    {
	    $this->load->helper('email');

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
							 'field'   => 'message',
							 'label'   => 'Message',
							 'rules'   => 'required'
						  )
					);

		$this->form_validation->set_rules($config);


        $this->load->view("header", array('title'=>'Store Locations & Hours | Contact Us | Highland Farms', "desc" => "Directions, maps and contact details for Highland Farms stores in Scarborough and Mississauga." ));

		if ($this->form_validation->run())	{

			$to = "customerservice@highlandfarms.on.ca";
			$from = $_POST['email'];
			$first = $_POST['first'];
			$last = $_POST['last'];
			$phone = $_POST['phone'];
			$message = $_POST['message'];

			$email = "From: $first $last<br/>
							Email: $from<br/>
							Phone: $phone<br/>
							Message: " . nl2br($message);

			send_ses_email($to, "VISIT US: Submission", $email);

			$this->load->view("visit-success");
		}
        $this->load->view("visit-us");
		$this->load->view("footer");

    }
}
