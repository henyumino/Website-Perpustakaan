<?php

namespace Flare\Components;

use Flare\Network\Http\Error;

class Mail
{
	public $timezone        = '';
	public $senderName      = '';
	public $thesubject      = '';
	public $receiptEmail    = '';
	public $receiptName     = '';
	public $senderEmail     = '';
	public $senderPassword  = '';
	public $host_mail       = '';
	public $message         = '';
	public $error           = '';

	public function Send()
	{
		try 
		{
			if (empty($this->thesubject) OR is_null($this->thesubject))
			{
				throw new Error("Subject doesn't yet set");
			}
			else if (empty($this->receiptEmail) OR is_null($this->receiptEmail))
			{
				throw new Error("Receipt email doesn't yet set");	
			}	
			else if (empty($this->receiptName) OR is_null($this->receiptName))
			{
				throw new Error("Receipt name doesn't yet set");
			}
			else if (empty($this->senderEmail) OR is_null($this->senderEmail))
			{
				throw new Error("Email doesn't yet set");
			}
			else if (empty($this->senderPassword) OR is_null($this->senderPassword))
			{
				throw new Error("Password doesn't yet set");
			}
			else if (empty($this->host_mail) OR is_null($this->host_mail))
			{
				throw new Error("Host doesn't yet set");
			}
			else
			{
				switch ($this->host_mail) 
				{
					case 'smtp.gmail.com':
						$phpmailer = new \PHPMailer;
						date_default_timezone_set($this->timezone);
						$phpmailer->isSMTP();
						$phpmailer->SMTPDebug   = 0;
						$phpmailer->Host        = $this->host_mail;
						$phpmailer->SMTPOptions = array
												  (
    											    'ssl' => array
    											  		   (
        										  			 'verify_peer' => false,
      											  			 'verify_peer_name' => false,
										   	 	  			 'allow_self_signed' => true
    											           )
												  );
						$phpmailer->Port        = 587;
						$phpmailer->SMTPSecure  = 'tls';
						$phpmailer->SMTPAuth    = true;
						$phpmailer->Username    = $this->senderEmail;
						$phpmailer->Password    = $this->senderPassword;
						$phpmailer->setFrom($this->senderEmail, $this->senderName);
						$phpmailer->addAddress($this->receiptEmail);
						$phpmailer->Subject     = $this->thesubject;
						$phpmailer->isHTML(true);
						$phpmailer->MsgHTML($this->message);

						if ($phpmailer->Send())
						{
							return true;
						}
						else
						{
							$this->error = $phpmailer->ErrorInfo;
							return false;
						}
					break;
					
					default:
						throw new Error("Undefined host");
					break;
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}
}