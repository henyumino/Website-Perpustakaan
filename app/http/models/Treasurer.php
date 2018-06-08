<?php

namespace app\http\models;

use Flare\Network\Http\Error;

use Flare\Components\Database\QueryBuilder;

class Treasurer extends QueryBuilder
{
	public function CheckEmail($Data)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckEmail() is empty");
			}
			else
			{
				if ($this->query("SELECT * FROM bendahara WHERE Email='$Data'")->num_rows > 0)
				{
					return true;
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
				$data_table = $this->get(null, 'ID_Bendahara');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Bendahara'] == $Data)
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

	public function CheckSetupCode($Data)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckSetupCode() is empty");
			}
			else
			{
				if ($this->query("SELECT * FROM bendahara WHERE Kode_Konfigurasi_Akun='$Data'")->num_rows > 0)
				{
					return true;
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

	public function CheckAccess($Data)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckAccess() is empty");
			}
			else
			{
				$data_table = $this->where($Data)->get('Status_Akun', 'ID_Bendahara');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['Status_Akun'] == 'Belum Terverifikasi')
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

	public function CheckAccessSetupPage($Id, $Verifcode)
	{
		try 
		{
			if (empty($Id) OR is_null($Id) OR empty($Verifcode) OR is_null($Verifcode)) 
			{
				throw new Error("Parameter method CheckAccessSetupPage() is empty");
			}
			else
			{
				$data_table = $this->get(null, 'ID_Bendahara,Kode_Konfigurasi_Akun,Status_Akun');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Bendahara'] == $Id AND $data['Kode_Konfigurasi_Akun'] == $Verifcode AND $data['Status_Akun'] == 'Belum Terverifikasi')
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

				$this->table    = 'bendahara';

				$non_fetch_data = $this->where($Data)->get("*", "Email");

				while ($row = $non_fetch_data->fetch()) 
				{
					return $row['ID_Bendahara'];
				}

				$this->disconnect();
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
	}

	public function getTreasurerData($ID)
	{
		$data_table  = $this->query("SELECT * FROM bendahara WHERE ID_Bendahara='$ID'");

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

	public function CheckAccess2($Id, $ResetCode)
	{
		try 
		{
			if (empty($Id) OR is_null($Id) OR empty($ResetCode) OR is_null($ResetCode))
			{
				throw new Error("Parameter method CheckAccess2() is empty");
			}	
			else
			{
				$data_table  = $this->get(null, 'ID_Bendahara,Kode_Atur_Ulang_Katasandi,Akses_Atur_Ulang_Katasandi');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Bendahara'] == $Id AND $data['Kode_Atur_Ulang_Katasandi'] == $ResetCode AND $data['Akses_Atur_Ulang_Katasandi'] == 'Aktif')
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

	public function DeleteTreasurer($id)
	{
		if ($this->query("DELETE FROM bendahara WHERE ID_Bendahara='$id'"))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}