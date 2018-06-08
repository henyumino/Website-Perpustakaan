<?php

namespace Flare\Components;

use Flare\Network\Http\Error;

class Validation
{
	public function isEmpty($Data = null)
	{
		try 
		{
			if (is_null($Data))
			{
				throw new Error("Parameter method isEmpty() is empty");
			}	
			else
			{
				if (empty($Data))
				{
					return TRUE;
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}

	public function Regex($Pattern = null, $Data = null)
	{
		try 
		{
			if (is_null($Pattern) OR empty($Pattern) OR is_null($Data) OR empty($Data))
			{
				throw new Error("Parameter method Regex() is empty");
			}
			else
			{
				if (preg_match($Pattern, $Data))
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function Minimum($Length = null, $Data = null)
	{
		try 
		{
			if (is_null($Length) OR empty($Length) OR is_null($Data) OR empty($Data))
			{
				throw new Error("Parameter method Minimum() is empty");
			}	
			else
			{
				if (strlen($Data) < $Length)
				{
					return FALSE;
				}
				else
				{
					return TRUE;
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function Maximum($Length = null, $Data = null)
	{
		try 
		{
			if (is_null($Length) OR empty($Length) OR is_null($Data) OR empty($Data))
			{
				throw new Error("Parameter method Maximum() is empty");
			}
			else
			{
				if (strlen($Data) > $Length)
				{
					return FALSE;
				}
				else
				{
					return TRUE;
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function SecureInput($Data = null)
	{
		try 
		{
			if (is_null($Data) OR empty($Data))
			{
				throw new Error("Parameter method SecureInput() is empty");
			}
			else
			{
				$Data 		 = htmlspecialchars($Data);

				$Data 		 = trim($Data);

				$Data 		 = stripcslashes($Data);

				$blacklist[] = "'";
				
				$blacklist[] = '"';

				$newData     = str_replace($blacklist, "", $Data);

				return $newData;
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}
}