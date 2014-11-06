<?php

	class CEmailer extends PHPMailer {

		var $mFrom = "Digital Studio ";
		var $mFromAddress = "info@smldigitalstudio.com";

		/** comment here */
		function CEmailer() {
			if (defined("EMAIL_FROM_ADDRESS")) $this->mFromAddress = EMAIL_FROM_ADDRESS;
			if (defined("EMAIL_FROM_NAME")) $this->mFrom = EMAIL_FROM_NAME;
		}

		/** comment here */
		function send1($users, $subject, $msg) {
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-utf-8' . "\r\n";
			// Additional headers
			$headers .= 'From: '.$this->mFrom.'<'.$this->mFromAddress.'>' . "\r\n";

			$style = '
							div, p, span, table, td {font-size: 12px; color: #444; font-family: tahoma}
							a {font-size: 12px; color: #8e9fad; font-family: tahoma; text-decoration: none;}
							a:hover {color: #000; }
						';
			$msg = "<html><head><style>".$style."</style></head><body><div>".$msg."</div></body></html>";
			foreach ($users as $key=>$val) {
				mail($val, $subject, $msg, $headers);
			}
		}


		/** comment here */
		function send2($users, $subject, $msg, &$attachments) {

			$style = '
							div, p, span, table, td {font-size: 12px; color: #444; font-family: tahoma}
							a {font-size: 12px; color: #8e9fad; font-family: tahoma; text-decoration: none;}
							a:hover {color: #000; }
						';
			$msg = "<html><head><style>".$style."</style></head><body><div>".$msg."</div></body></html>";

			$this->From = $this->mFrom;
			$this->FromName = $this->mFrom;

			$this->Priority = 3;
			$this->IsHTML(true);
			foreach ($attachments as $key=>$val) {
				$this->AddStringAttachment($val[0], $val[1]);
			}

			$this->Subject = $subject;
			$this->Body    = $msg;
			$this->AltBody    = $msg;
			$this->AddReplyTo($this->mFromAddress, $this->mFromAddress);

			foreach ($users as $key=>$val) {
				$this->AddAddress($val,$val);
				$ret = $this->Send();
				$this->ClearAddresses();
			}
			Return $ret;
		}

	}

?>