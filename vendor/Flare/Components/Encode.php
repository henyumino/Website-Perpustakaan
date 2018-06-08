<?php

namespace Flare\Components;

use Flare\Network\Http\Error;

class Encode
{
	public $key      = "";

	public function protect($Data)
	{
		try 
		{
			if (empty($this->key) OR is_null($this->key))
			{
				throw new Error("Key doesn't yet set");
			}
			else if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method protected() is empty");
				
			}
			else
			{
				return strtr($Data, $this->key);
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}

	public function unprotected($Data)
	{
		try 
		{
			if (empty($this->key) OR is_null($this->key))
			{
				throw new Error("Key doesn't yet set");
			}
			else if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method unprotected() is empty");
				
			}
			else
			{
				return str_replace(array_values($this->key), array_keys($this->key), $Data);
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}


}