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
               'field'   => 'subject',
               'label'   => 'Subject Line',
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

    $this->load->view("header", array('title'=>'Store Locations & Hours | Contact Us | Highland Farms', "desc" => "Directions, maps and contact details for Highland Farms stores in Scarborough, Vaughan and Mississauga." ));

    if ($this->form_validation->run())  {

      $to = "customerservice@highlandfarms.on.ca";
      $from = htmlspecialchars($_POST['email']);
      $first = htmlspecialchars($_POST['first']);
      $last = htmlspecialchars($_POST['last']);
      $subject = htmlspecialchars($_POST['subject']);
      $phone = htmlspecialchars($_POST['phone']);
      $message = htmlspecialchars($_POST['message']);

      $email = "From: $first $last<br/>
              Email: $from<br/>
              Phone: $phone<br/>
              Message: " . nl2br(htmlspecialchars($message));

      send_ses_email($to, $subject, $email);

      $this->load->view("visit-success");
    }
        $this->load->view("visit-us");
    $this->load->view("footer");

    }
}
