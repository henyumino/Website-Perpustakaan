<?php

namespace Flare\Network\Http;

use Flare\Network\Http\Error;

class Ajax 
{
	public function check()
	{
		if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) == FALSE && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
		{
			return TRUE;
		}
	}

	public function json_response(Array $array = null)
	{
		try 
		{
			if (is_null($array) OR empty($array))
			{
				throw new Error('Array parameter method json_response() is empty');
			}
			else
			{
				echo json_encode($array);
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function AngularInput()
	{
		return json_decode(file_get_contents("php://input"));
	}
}