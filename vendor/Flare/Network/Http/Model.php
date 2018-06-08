<?php

namespace Flare\Network\Http;

use Flare\Network\Http\Error;

use Flare\Network\Http\View;

class Model extends View 
{
	public function get($Action = NULL)
	{
		try 
		{
			if ($_SERVER['REQUEST_METHOD'] != 'GET')
			{
				self::error_404();
			}
			else if (empty($Action) OR is_null($Action))
			{
				throw new Error("Action parameter method view() is empty");
			}
			else
			{
				self::render($Action);
			}
		}	 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function post($Action = NULL)
	{
		
		try 
		{
			if ($_SERVER['REQUEST_METHOD'] != 'POST')
			{
				self::error_404();
			}
			else if (empty($Action) OR is_null($Action))
			{
				throw new Error("Action parameter method view() is empty");
			}
			else
			{
				self::render($Action);
			}
		}	 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}
}