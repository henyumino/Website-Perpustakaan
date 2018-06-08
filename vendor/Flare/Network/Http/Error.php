<?php

namespace Flare\Network\Http;

class Error extends \Exception 
{
	public function print()
	{
		$listenError = "<p><font style='color:red;font-weight:bold;'>Error</font> on line ".$this->getLine()." in ".$this->getFile()." [<strong>".$this->getMessage()."</strong>]</p>";

		return $listenError;
	}
}