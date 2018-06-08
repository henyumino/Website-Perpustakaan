<?php

namespace Flare\Components;

use Flare\Network\Http\View;

use Flare\Network\Http\Error;

class Environment extends View
{

	private static $list = array();

	private static $envflag = false;

	private static $dir;

	public function include()
	{
		if (self::$viewflag == true)
		{
			try
		    {

				if (file_exists(self::$settings['config'].'config/environment.php'))
				{
					self::$envflag = true;
				}
				else
				{
					throw new Error('Uncaught file environment.php at folder config');
				}
			}
			catch (Error $e) 
			{
				echo $e->print();	
			}
			
			return self::$envflag != false ? include self::$settings['config'].'config/environment.php' : null;
		}
		else
		{
			try
		    {

				if (file_exists('../config/environment.php'))
				{
					self::$envflag = true;
				}
				else
				{
					throw new Error('Uncaught file environment.php at folder config');
				}
			}
			catch (Error $e) 
			{
				echo $e->print();	
			}
		
			return self::$envflag != false ? include '../config/environment.php' : null;
		}	
	}

	public function listen(Array $LIST = null)
	{
		try 
		{
			if (self::$envflag == false)
			{
				throw new Error("Environment doesn't include");
			}	
			else if (is_null($LIST) OR is_array($LIST) == false OR empty($LIST))
			{
				throw new Error('LIST parameter method listen() is empty');
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

	public function get($KeyData = NULL)
	{
		try 
		{
			if (self::$envflag == false)
			{
				throw new Error("Environment doesn't include");
			}
			else if (empty(self::$list) OR is_array(self::$list) == false)
			{
				throw new Error("Environment doesn't yet set");
			}
			else if (empty($KeyData) OR is_null($KeyData))	
			{
				throw new Error("key data parameter method get() is empty");
			}
			else
			{
				if (array_key_exists($KeyData, self::$list))
				{
					return self::$list[$KeyData];
				}
				else
				{
					throw new Error("Undefined environment key");
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function print($KeyData = NULL)
	{
		try 
		{
			if (self::$envflag == false)
			{
				throw new Error("Environment doesn't include");
			}
			else if (empty(self::$list) OR is_array(self::$list) == false)
			{
				throw new Error("Environment doesn't yet set");
			}
			else if (empty($KeyData) OR is_null($KeyData))	
			{
				throw new Error("key data parameter method get() is empty");
			}
			else
			{
				
				if (array_key_exists($KeyData, self::$list))
				{
					echo self::$list[$KeyData];
				}
				else
				{
					throw new Error("Undefined environment key");
				}
				
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}
}