<?php

namespace Flare\Components\Database;

use Flare\Network\Http\View;

use Flare\Network\Http\Error;

class QueryBuilder extends View
{

	private static $dbsettings = array();

	private static $db         = null;

	public $table              = '';

	private $canUsefetch       = '';

	private $resultGet         = '';

	private $isWhereQuery      = false;

	private $whereData         = '';

	private $canUseNumRows     = false;

	public $num_rows           = '';

	public function settings(Array $SETTINGS = null)
	{
		try 
		{
			if (is_null($SETTINGS) OR is_array($SETTINGS) == false OR empty($SETTINGS))
			{
				throw new Error('Parameter method settings() is empty');
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}

		self::$dbsettings = $SETTINGS;
	}

	public function connect()
	{

		if (self::$viewflag == true)
		{
			include file_exists(self::$settings['config'].'config/database.php') ? self::$settings['config'].'config/database.php' : NULL;
		
			try 
			{
				if (!file_exists(self::$settings['config'].'config/database.php'))
				{
					throw new Error("Uncaught file database.php at config folder");
				}
				else if (empty(self::$dbsettings) OR is_array(self::$dbsettings) == false)
				{
					throw new Error("QueryBuilder doesn't yet set");
				}
			} 
			catch (Error $e) 
			{
				echo $e->print();
			}

			self::$db = new \mysqli(self::$dbsettings['Host'], self::$dbsettings['Username'], self::$dbsettings['Password'], self::$dbsettings['Database']);
		}
		else
		{
			include file_exists('../config/database.php') ? '../config/database.php' : NULL;
		
			try 
			{
				if (!file_exists('../config/database.php'))
				{
					throw new Error("Uncaught file database.php at config folder");
				}
				else if (empty(self::$dbsettings) OR is_array(self::$dbsettings) == false)
				{
					throw new Error("QueryBuilder doesn't yet set");
				}
			} 
			catch (Error $e) 
			{
				echo $e->print();
			}

			self::$db = new \mysqli(self::$dbsettings['Host'], self::$dbsettings['Username'], self::$dbsettings['Password'], self::$dbsettings['Database']);
		}
	}

	public function disconnect()
	{
		self::$db = null;
	}

	public function query($SQL = null)
	{
		try 
		{
			if (empty(self::$settings) OR is_array(self::$settings) == false)
			{
				throw new Error("QueryBuilder doesn't yet set");
			}
			else if (empty(self::$db) OR is_null(self::$db))
			{
				throw new Error("QueryBuilder doesn't connected to database");
			}
			else if (empty($SQL) OR is_null($SQL))
			{
				throw new Error('SQL parameter method query is empty');
			}
			else
			{
				if (self::$db->query($SQL))
				{
					return self::$db->query($SQL);	
				}
				else
				{
					throw new Error(self::$db->error);
				}
			}	
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}		
	}

	public function all()
	{
		try 
		{
			if (empty(self::$settings) OR is_array(self::$settings) == false)
			{
				throw new Error("QueryBuilder doesn't yet set");
			}
			else if (empty(self::$db) OR is_null(self::$db))
			{
				throw new Error("QueryBuilder doesn't connected to database");
			}
			else if (empty($this->table) OR is_null($this->table))
			{
				throw new Error("Table doesn't yet set");
			}
			else
			{
				if (self::$db->query("SELECT * FROM ".$this->table))
				{
					return self::$db->query("SELECT * FROM ".$this->table);
				}
				else
				{
					throw new Error(self::$db->error);
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}

	public function insert($Field = null, $Values = null)
	{
		try 
		{
			if (empty(self::$settings) OR is_array(self::$settings) == false)
			{
				throw new Error("QueryBuilder doesn't yet set");
			}
			else if (empty(self::$db) OR is_null(self::$db))
			{
				throw new Error("QueryBuilder doesn't connected to database");
			}
			else if (empty($this->table) OR is_null($this->table))
			{
				throw new Error("Table doesn't yet set");
			}
			else if (empty($Field) OR is_null($Field) OR empty($Values) OR is_null($Values))
			{
				throw new Error("Method update() parameter is empty");
			}
			else
			{
				if (self::$db->query("INSERT INTO ".$this->table." (".$Field.") VALUES (".$Values.")"))
				{
					return true;
				}
				else
				{
					$this->canUsefetch = false;
					
					throw new Error(self::$db->error);
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}

	public function get($Selection = null, $Field = null)
	{
		try 
		{
			if (empty(self::$settings) OR is_array(self::$settings) == false)
			{
				throw new Error("QueryBuilder doesn't yet set");
			}
			else if (empty(self::$db) OR is_null(self::$db))
			{
				throw new Error("QueryBuilder doesn't connected to database");
			}
			else if (empty($this->table) OR is_null($this->table))
			{
				throw new Error("Table doesn't yet set");
			}
			else if (empty($Field) OR is_null($Field))
			{
				throw new Error("Method get() parameter is empty");
			}
			else
			{
				if ($this->isWhereQuery == true)
				{
					if (empty($Selection) == false AND is_null($Selection) == false)
					{

						if (self::$db->query("SELECT ".$Selection." FROM ".$this->table." WHERE ".$Field."='".$this->whereData."'"))
						{
							$this->canUsefetch = true;

							$this->resultGet   = self::$db->query("SELECT ".$Selection." FROM ".$this->table." WHERE ".$Field."='".$this->whereData."'");
							
							$this->canUseNumRows = true;

							$this->num_rows    = self::$db->query("SELECT ".$Selection." FROM ".$this->table." WHERE ".$Field."='".$this->whereData."'")->num_rows;

							return $this;
						}
						else
						{
							$this->canUsefetch = false;

							throw new Error(self::$db->error);
						}
					}
					else
					{
						if (self::$db->query("SELECT ".$Field." FROM ".$this->table." WHERE ".$Field."=".$this->whereData.""))
						{
							$this->canUsefetch = true;

							$this->resultGet   = self::$db->query("SELECT ".$Field." FROM ".$this->table." WHERE ".$Field."='".$this->whereData."'");

							$this->canUseNumRows = true;

							$this->num_rows    = self::$db->query("SELECT ".$Field." FROM ".$this->table." WHERE ".$Field."='".$this->whereData."'")->num_rows;

							return $this;
						}
						else
						{
							$this->canUsefetch = false;

							throw new Error(self::$db->error);
						}
					}
				}
				else
				{
					if (self::$db->query("SELECT ".$Field." FROM ".$this->table))
					{
						$this->canUsefetch = true;

						$this->resultGet   = self::$db->query("SELECT ".$Field." FROM ".$this->table);

						$this->canUseNumRows = true;

						$this->num_rows    = self::$db->query("SELECT ".$Field." FROM ".$this->table)->num_rows;

						return $this;
					}
					else
					{
						$this->canUsefetch = false;

						throw new Error(self::$db->error);
					}
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}

	public function update($Selection = null, $Field = null)
	{
		try 
		{
			if (empty(self::$settings) OR is_array(self::$settings) == false)
			{
				throw new Error("QueryBuilder doesn't yet set");
			}
			else if (empty(self::$db) OR is_null(self::$db))
			{
				throw new Error("QueryBuilder doesn't connected to database");
			}
			else if (empty($this->table) OR is_null($this->table))
			{
				throw new Error("Table doesn't yet set");
			}
			else if (empty($Field) OR is_null($Field))
			{
				throw new Error("Method update() parameter is empty");
			}
			else
			{
				if ($this->isWhereQuery == true)
				{
					if (empty($Selection) == false AND is_null($Selection) == false)
					{

						if (self::$db->query("UPDATE ".$this->table." SET ".$Selection." WHERE ".$Field."='".$this->whereData."'"))
						{
							$this->canUsefetch = true;

							$this->resultGet   = self::$db->query("UPDATE ".$this->table." SET ".$Selection." WHERE ".$Field."='".$this->whereData."'");

							return $this;
						}
						else
						{
							$this->canUsefetch = false;

							throw new Error(self::$db->error);
						}
					}
					else
					{
						throw new Error("Undefined data want to update! Selection parameter is empty");
					}
				}
				else
				{
					if (self::$db->query("SELECT ".$Field." FROM ".$this->table))
					{
						$this->canUsefetch = true;

						$this->resultGet   = self::$db->query("SELECT ".$Field." FROM ".$this->table);

						return $this;
					}
					else
					{
						$this->canUsefetch = false;

						throw new Error(self::$db->error);
					}
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}

	public function delete($Field = null)
	{
		try 
		{
			if (empty(self::$settings) OR is_array(self::$settings) == false)
			{
				throw new Error("QueryBuilder doesn't yet set");
			}
			else if (empty(self::$db) OR is_null(self::$db))
			{
				throw new Error("QueryBuilder doesn't connected to database");
			}
			else if (empty($this->table) OR is_null($this->table))
			{
				throw new Error("Table doesn't yet set");
			}
			else if (empty($Field) OR is_null($Field))
			{
				throw new Error("Method delete() parameter is empty");
			}
			else
			{
				if ($this->isWhereQuery == true)
				{
					if (self::$db->query("DELETE FROM ".$this->table." WHERE ".$Field."='".$this->whereData."'"))
					{
						$this->canUsefetch = false;

						$this->resultGet   = self::$db->query("DELETE FROM ".$this->table." WHERE ".$Field."='".$this->whereData."'");

						if ($this->resultGet)
						{
							return true;
						}
					}
					else
					{
						$this->canUsefetch = false;

						throw new Error(self::$db->error);
					}
				}
				else
				{
					if (self::$db->query("SELECT ".$Field." FROM ".$this->table))
					{
						$this->canUsefetch = true;

						$this->resultGet   = self::$db->query("SELECT ".$Field." FROM ".$this->table);

						return $this;
					}
					else
					{
						$this->canUsefetch = false;

						throw new Error(self::$db->error);
					}
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}

	public function fetch()
	{
		try 
		{
			if (empty(self::$settings) OR is_array(self::$settings) == false)
			{
				throw new Error("QueryBuilder doesn't yet set");
			}
			else if (empty(self::$db) OR is_null(self::$db))
			{
				throw new Error("QueryBuilder doesn't connected to database");
			}
			else if (empty($this->table) OR is_null($this->table))
			{
				throw new Error("Table doesn't yet set");
			}
			else if (empty($this->canUsefetch) OR is_null($this->canUsefetch))
			{
				throw new Error("Can't use fethc() method you must use get() method first");
			}
			else
			{
				if ($this->canUsefetch == true AND empty($this->resultGet) == false)
				{
					return $this->resultGet->fetch_assoc();
				}
				else
				{
					throw new Error("Can't use fetch() method you must use get(Column) method first");
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}

	public function rows()
	{
		try 
		{
			if (empty(self::$settings) OR is_array(self::$settings) == false)
			{
				throw new Error("QueryBuilder doesn't yet set");
			}
			else if (empty(self::$db) OR is_null(self::$db))
			{
				throw new Error("QueryBuilder doesn't connected to database");
			}
			else if (empty($this->table) OR is_null($this->table))
			{
				throw new Error("Table doesn't yet set");
			}
			if (empty($this->num_rows) OR is_null($this->num_rows))
			{
				return false;
			}
			else
			{
				if ($this->canUseNumRows == true AND empty($this->canUseNumRows) == false)
				{
					return $this->num_rows;
				}
				else
				{
					throw new Error("Can't use fetch() method you must use get(Column) method first");
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();	
		}
	}

	public function where($Data = null)
	{
		try 
		{
			if (empty(self::$settings) OR is_array(self::$settings) == false)
			{
				throw new Error("QueryBuilder doesn't yet set");
			}
			else if (empty(self::$db) OR is_null(self::$db))
			{
				throw new Error("QueryBuilder doesn't connected to database");
			}
			else if (empty($this->table) OR is_null($this->table))
			{
				throw new Error("Table doesn't yet set");
			}
			else if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method where() is empty");
			}	
			else 
			{
				$this->isWhereQuery = true;

				$this->whereData    = $Data;

				return $this;
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}
}