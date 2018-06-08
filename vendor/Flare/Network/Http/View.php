<?php

namespace Flare\Network\Http;

use Flare\Network\Http\Error;

class View
{

	protected static $settings;

	protected static $viewflag = false;

	public function setDirectory($DirSet = NULL)
	{
		if (empty($DirSet) == False OR is_null($DirSet) == False OR is_array($DirSet) == False)
		{
			self::$settings = $DirSet;

			self::$viewflag = true;
		}
	}


	public function render($Action = NULL, $Variable = NULL)
	{
		try 
		{
			if (empty($Action) OR is_null($Action))
			{
				throw new Error("Action parameter method view() is empty");
			}	
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}

		if (is_callable($Action))
		{
			$Action();
		}
		else if (strpos($Action, '#'))
		{
			$arr       = explode('#', $Action);

			$class     = $arr[0];

			$function  = $arr[1];

			if (self::$viewflag == True)
			{
				try 
				{
					if (!file_exists(self::$settings['controllers'].'app/http/controllers/'.$class.'.php'))
					{
						throw new Error("Class $class at app/http/controllers doesn't exit");
					}
				} 
				catch (Error $e) 
				{
					echo $e->print();
				}

				include self::$settings['controllers'].'app/http/controllers/'.$class.'.php';

				$class = new $class;

				$class->$function();
			}
			else
			{
				try 
				{
					if (!file_exists('../app/http/controllers/'.$class.'.php'))
					{
						throw new Error("Class $class at app/http/controllers doesn't exit");
					}
				} 
				catch (Error $e) 
				{
					echo $e->print();
				}

				include '../app/http/controllers/'.$class.'.php';

				$class = new $class;

				$class->$function();
			}
		}
		else
		{	
			try 
			{
				if (self::$viewflag == True)
				{
					if (empty(self::$settings['custom_resources']) == false OR is_null(self::$settings['custom_resources']) == false)
					{
						if (!file_exists(self::$settings['custom_resources'].$Action))
						{
							throw new Error("File $Action at public/resources folder doesn't exit");
						}
						else
						{
							include self::$settings['custom_resources'].$Action;

							if (empty($Variable) == FALSE OR is_null($Variable) == FALSE)
							{
								return $Variable;
							}
						}
					}
					else if (empty(self::$settings['resources']) == false OR is_null(self::$settings['resources']) == false)
					{
						if (!file_exists(self::$settings['resources'].'resources/'.$Action))
						{
							throw new Error("File $Action at public/resources folder doesn't exit");
						}
						else
						{
							include self::$settings['resources'].'resources/'.$Action;

							if (empty($Variable) == FALSE OR is_null($Variable) == FALSE)
							{
								return $Variable;
							}
						}
					}
				}
				else
				{
					if (!file_exists('resources/'.$Action))
					{
						throw new Error("File $Action at public/resources folder doesn't exit");
					}

					include 'resources/'.$Action;

					if (empty($Variable) == FALSE OR is_null($Variable) == FALSE)
					{
						return $Variable;
					}
				}
			} 
			catch (Error $e) 
			{
				echo $e->print();
			}
		}
	}

	public function error_404()
	{
		if (self::$viewflag == true)
		{
			try 
			{
				if (is_null(self::$settings['custom_errors']) == false OR empty(self::$settings['custom_errors']) == false)
				{
					if (!file_exists(self::$settings['custom_errors'].'404.php'))
					{
						throw new Error("File 404.php at public/resources/errors folder doesn't exit");
					}
					else
					{
						include self::$settings['custom_errors'].'404.php';
					}
				}
				else
				{
					throw new Error("custom_errors doesn't yet set");
				}	
			} 
			catch (Error $e) 
			{
				echO $e->print();
			}
		}
		else
		{
			if (!file_exists('resources/errors/404.php'))
			{
				throw new Error("File 404.php at public/resources/errors folder doesn't exit");
			}
			else
			{
				include 'resources/errors/404.php';
			}
		}
	}

	public function redirect($Action = NULL)
	{
		try 
		{
			if (empty($Action) OR is_null($Action))
			{
				throw new Error("Action parameter method view() is empty");
			}	
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}

		header('location:'. $Action.'');
	}

	public function securedView($Flags)
	{
		try 
		{
			if (is_null($Flags) OR empty($Flags))
			{
				throw new Error("parameter method securedView() is empty");
			}	
			else
			{
				if ($Flags == 'parts')
				{
					define('resources_header', true);

					define('resources_body', true);
		
					define('resources_footer', true);
				}
				else
				{
					define('resources', true);
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}
}