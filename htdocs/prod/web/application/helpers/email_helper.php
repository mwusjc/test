<?php

function send_ses_email($to, $subject, $message, $attachments = array()) {
	$CI =& get_instance();
    $CI->load->library('email');
	$config = array(
	    'protocol' => 'smtp',
	    'smtp_host' => 'ssl://email-smtp.us-east-1.amazonaws.com',
	    'smtp_user' => 'AKIAJIC3P5BZFPDRU65A',
	    'smtp_pass' => 'ApnJyiliSEvWJuXXghwZAKFayUyaT9OHSVT8orKxhqaV',
	    'smtp_port' => 465,
	    'mailtype' => 'html'
	);
// 	var_dump("here");	
	$CI->email->initialize($config);
	$CI->email->print_debugger();
	
	$CI->email->from('daemon@highlandfarms.ca', 'Highland Farms Email Service');
	$CI->email->to($to);
	$CI->email->subject($subject);
	$CI->email->message($message);
	$CI->email->set_newline("\r\n");
	if (isset($attachments['attachments']['tmp_name'])) {
		foreach ($attachments['attachments']['tmp_name'] as $k=>$a) {
			if ($a) {
				$CI->email->attach($a,'attachment',$attachments['attachments']['name'][$k]);
			}
		}
	}
	
	if($CI->email->send()) {
    	return true;
    } else {
        print show_error($CI->email->print_debugger());
      	return show_error($CI->email->print_debugger());
    }
}
	
?>