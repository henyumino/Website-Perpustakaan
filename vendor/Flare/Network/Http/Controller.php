<?php

namespace Flare\Network\Http;

use Flare\Network\Http\View;

use Flare\Network\Http\Error;

class Controller extends View 
{
	public function load($File = NULL, $Variable = NULL)
	{
		try 
		{
			if (empty($File) OR is_null($File))
			{
				throw new Error("File parameter method load() is empty");
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}

		if (empty($Variable) == FALSE OR is_null($Variable) == FALSE)
		{
			self::render($File, $Variable);
		}
		else
		{
			self::render($File);
		}
	}
}