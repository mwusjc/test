<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		date_default_timezone_set('America/Toronto');
		$dateNow = new DateTime("now");

		// This is the Date/Time for the Carousel update Cutover (currently Thursdays at 10pm).
		// Change this accordingly every week (before the actual cutover date).
		// For local testing, it is recommended that you set this time to something close to the
		// actual time. Test that both views are loaded correctly, both BEFORE the cutover time
		// and AFTER the cutover time. DO NOT forget to set the correct cutover Date/Time
		// before you push to the repo.
		$dateCarouselUpdate = new DateTime('2015-12-21 13:09:00');

    $this->load->view("header");

    // load the correct carousel view based on $dateCarouselUpdate cutover
    if ($dateNow < $dateCarouselUpdate) { // current Carousel BEFORE cutover
    	$this->load->view("home");
    } else { // updated carousel AFTER cutover
    	$this->load->view("home-after-cutover");
    }

		$this->load->view("footer");
	}
}
