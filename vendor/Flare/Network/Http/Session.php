<?php

namespace Flare\Network\Http;

use Flare\Network\Http\Error;

class Session
{
	public $name = "";

	public $use  = "";        

	private $isGiving = false;

	public function start()
	{
	   return session_start();
	}

	public function give()
	{
		try 
		{
			if (empty($this->name) OR is_null($this->name))
			{
				throw new Error("Session name doesn't yet set");
			}	
			else
			{
				if (empty($use) == false AND is_null($use) == false)
				{
					$this->isGiving = true;

					return $_SESSION[$this->name] = $this->use;
				}
				else 
				{
					$this->isGiving = true;

					return $this;
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function use($Data = null)
	{
		try 
		{
			if ($this->isGiving == false)
			{
				throw new Error("Can't use method use() first you need to use method give()");
			}	
			else if (empty($this->name) OR is_null($this->name))
			{
				throw new Error("Session name doesn't yet set");
			}
			else if (empty($use) == false AND is_null($use) == false)
			{
				throw new Error("Use variable has been yet set. Just use method give if you set the use method at variable use.");
				
			}
			else if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method use() is empty");
				
			}
			else
			{
				return $_SESSION[$this->name] = $Data;
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}

	public function check($Name = null)
	{
		try 
		{
			if (empty($Name) OR is_null($Name))
			{
				throw new Error("Parameter method check() is empty");
			}
			else
			{
				if (isset($_SESSION[$Name]))
            	{
              		return true;
            	}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}

	public function take($Name = null)
	{
		try 
		{
			if (empty($Name) OR is_null($Name))
			{
				throw new Error("Parameter method take() is empty");
			}
			else
			{
				if (isset($_SESSION[$Name]))
				{
					return session_destroy();
				}
			}	
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function value($Name = null)
	{
		try 
		{
			if (empty($Name) OR is_null($Name))
			{
				throw new Error("Parameter method take() is empty");
			}
			else
			{
				if (isset($_SESSION[$Name]))
				{
					return $_SESSION[$Name];
				}
			}	
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}
}