<?php

namespace Flare\Network\Http;

use Flare\Network\Http\Error;

class Cookie
{
    public $name = "";

	public $use  = "";        

	private $isGiving = false;

	public function give()
	{
		try 
		{
			if (empty($this->name) OR is_null($this->name))
			{
				throw new Error("Cookie name doesn't yet set");
			}	
			else
			{
				if (empty($use) == false AND is_null($use) == false)
				{
					$this->isGiving = true;

					return setcookie($this->name, $this->use, time() + (86400 * 30), "/");
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
				throw new Error("Cookie name doesn't yet set");
			}
			else if (empty($use) == false AND is_null($use) == false)
			{
				throw new Error("Use variable has been yet set. Just use method give if you set the value at variable use.");
			}
			else if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method use() is empty");
				
			}
			else
			{
				return setcookie($this->name, $Data, time() + (86400 * 30), "/");
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
				if (isset($_COOKIE[$Name]))
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
				if (isset($_COOKIE[$Name]))
				{
					return setcookie($Name, null, 0, "/");
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
				if (isset($_COOKIE[$Name]))
				{
					return $_COOKIE[$Name];
				}
			}	
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}
}