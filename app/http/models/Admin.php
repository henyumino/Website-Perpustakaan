<?php

namespace app\http\models;

use Flare\Network\Http\Error;

use Flare\Components\Database\QueryBuilder;

class Admin extends QueryBuilder
{
	public function CheckEmail($DataDB, $Data)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckEmail() is empty");
			}	
			else if (empty($DataDB))
			{
				return false;
			}
			else
			{
				while ($newData = $DataDB) 
				{
					if ($newData['Email'] == $Data)
					{
						return true;
					}
					else
					{
						return false;
					}
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function CheckPassword($DataDB, $Data)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckLoginData() is empty");
			}	
			else if (empty($DataDB))
			{
				return false;
			}
			else
			{
				while ($newData = $DataDB) 
				{
					if (password_verify($Data, $newData['Katasandi']))
					{
						return true;
					}
					else
					{
						return false;
					}
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function CheckID($Data)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckID() is empty");
			}	
			else
			{
				$data_table = $this->get(null, 'ID_Pemilik');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Pemilik'] == $Data)
						{
							return true;

							break;
						}
					}
				}
				else
				{
					return false;
				}
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function getId($Data)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method getId() is empty");
			}	
			else
			{
				$this->connect();

				$this->table    = 'pemilik';

				$non_fetch_data = $this->where($Data)->get("*", "Email");

				while ($row = $non_fetch_data->fetch()) 
				{
					return $row['ID_Pemilik'];
				}

				$this->disconnect();
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function getAdminData($ID)
	{
		$data_table  = $this->query("SELECT * FROM pemilik WHERE ID_Pemilik='$ID'");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			return $array_data = $data_table->fetch_assoc();
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function checkRowsTableSecretary()
	{
		$data_table  = $this->query("SELECT * FROM sekretaris");

		if ($data_table->num_rows > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getRowsTableSecretary()
	{
		$data_table = $this->query("SELECT * FROM sekretaris");

		if ($data_table->num_rows > 0)
		{
			$num_rows = $data_table->num_rows;

			return $num_rows;
		}
		else
		{
			return 0;
		}
	}

	public function getDataSecretary($start, $end)
	{
		$data_table  = $this->query("SELECT ID_Sekretaris,Nama FROM sekretaris ORDER BY NOW() DESC LIMIT $start,$end");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Sekretaris' => $data_fetch['ID_Sekretaris'], 'Nama_Sekretaris' => $data_fetch['Nama']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function checkRowsTableTreasurer()
	{
		$data_table  = $this->query("SELECT * FROM bendahara");

		if ($data_table->num_rows > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getRowsTableTreasurer()
	{
		$data_table = $this->query("SELECT * FROM bendahara");

		if ($data_table->num_rows > 0)
		{
			$num_rows = $data_table->num_rows;

			return $num_rows;
		}
		else
		{
			return 0;
		}
	}

	public function getDataTreasurer($start, $end)
	{
		$data_table  = $this->query("SELECT ID_Bendahara,Nama FROM bendahara ORDER BY NOW() DESC LIMIT $start,$end");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Bendahara' => $data_fetch['ID_Bendahara'], 'Nama_Bendahara' => $data_fetch['Nama']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function getRowsTableAllRole()
	{
		$data_table = $this->query("SELECT sekretaris.ID_Sekretaris,sekretaris.Nama,bendahara.ID_Bendahara,bendahara.Nama FROM sekretaris CROSS JOIN bendahara ORDER BY NOW()");

		if ($data_table->num_rows > 0)
		{
			$num_rows = $data_table->num_rows;

			return $num_rows;
		}
		else
		{
			return 0;
		}
	}

	public function getDataAllRole($start, $end)
	{
		$data_table  = $this->query("SELECT sekretaris.ID_Sekretaris,sekretaris.Nama As NamaSekretaris,bendahara.ID_Bendahara,bendahara.Nama as NamaBendahara FROM sekretaris CROSS JOIN bendahara ORDER BY NOW() DESC LIMIT $start,$end");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Sekretaris' => $data_fetch['ID_Sekretaris'], 'Nama_Sekretaris' => $data_fetch['NamaSekretaris'], 'ID_Bendahara' => $data_fetch['ID_Bendahara'], 'Nama_Bendahara' => $data_fetch['NamaBendahara']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function searchMemberSecretary($keyword)
	{
		$data_table  = $this->query("SELECT ID_Sekretaris,Nama FROM sekretaris WHERE Nama LIKE '%$keyword%'");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Sekretaris' => $data_fetch['ID_Sekretaris'], 'Nama_Sekretaris' => $data_fetch['Nama']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function searchMemberTreasurer($keyword)
	{
		$data_table  = $this->query("SELECT ID_Bendahara,Nama FROM bendahara WHERE Nama LIKE '%$keyword%'");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Bendahara' => $data_fetch['ID_Bendahara'], 'Nama_Bendahara' => $data_fetch['Nama']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}
}