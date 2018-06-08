<?php

namespace Flare\Components;

use Flare\Network\Http\View;

use Flare\Network\Http\Error;

class Loader extends View
{

	private static $list = array();

	private static $loaderflag = false;

	public function on()
	{
		if (file_exists('../config/loader.php'))
		{
			self::$loaderflag = true;
		}
		
		return self::$loaderflag != false ? include '../config/loader.php' : null;
	}

	public function off()
	{
		self::$loaderflag = false;
	}

	public function list(Array $LIST = null)
	{
		try 
		{
			if (self::$loaderflag == false)
			{
				throw new Error("loader is offline");
			}	
			else if (is_null($LIST) OR is_array($LIST) == false OR empty($LIST))
			{
				throw new Error('LIST parameter method list() is empty');
			}
			else
			{
				self::$list = $LIST;
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}

	public function control($File = NULL)
	{
		try 
		{
			if (self::$loaderflag== false)
			{
				throw new Error("loader is offline");
			}
			else if (empty(self::$list) OR is_array(self::$list) == false)
			{
				throw new Error("loader doesn't yet set");
			}
			else if (empty($File) OR is_null($File))	
			{
				throw new Error("File parameter method FilesControl() is empty");
			}
			else
			{
				if (array_key_exists($File, self::$list))
				{
					return self::$list;
				}
				else
				{
					self::error_404();
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function loader()
	{

		try 
		{
			$File = basename($_SERVER["REQUEST_URI"]);	

			if (empty($File) OR is_null($File))
			{
				throw new Error("File parameter method loader() is empty");
			}	
			else if (empty(self::$list) OR is_array(self::$list) == false)
			{
				throw new Error("loader doesn't yet set");
			}
			else if (self::control($File))
			{
				header("Content-type: ".self::control($File)[$File]['ContentType']);

				header("Content-Disposition: ".self::control($File)[$File]['ContentDisposition']);

				echo file_get_contents(self::control($File)[$File]['FileLocation']);
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}
}