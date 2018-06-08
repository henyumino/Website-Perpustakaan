<?php

namespace app\http\models;

use Flare\Network\Http\Error;

use Flare\Components\Database\QueryBuilder;

class Users extends QueryBuilder
{

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
				$data_table = $this->get(null, 'ID_Pengguna');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Pengguna'] == $Data)
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

	public function CheckEmail($Data = null)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckEmail() is empty");
			}
			else
			{
				if ($this->query("SELECT * FROM pengguna WHERE Email='$Data'")->num_rows > 0)
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
				throw new Error("Parameter method CheckPassword() is empty");
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

	public function CheckVerifCode($Data)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckVerifCode() is empty");
			}
			else
			{
				$data_table = $this->get(null, 'Kode_Verifikasi_Email');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['Kode_Verifikasi_Email'] == $Data)
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

	public function CheckAccess($Id)
	{
		try 
		{
			if (empty($Id) OR is_null($Id)) 
			{
				throw new Error("Parameter method CheckAccess() is empty");
			}
			else
			{
				$data_table = $this->where($Id)->get('Status_Akun', 'ID_Pengguna')->fetch();

				if ($data_table['Status_Akun'] == 'Belum Terverifikasi')
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

	public function CheckAccessVerifPage($Id, $Verifcode)
	{
		try 
		{
			if (empty($Id) OR is_null($Id) OR empty($Verifcode) OR is_null($Verifcode)) 
			{
				throw new Error("Parameter method CheckAccessVerifPage() is empty");
			}
			else
			{
				$data_table = $this->get(null, 'ID_Pengguna,Kode_Verifikasi_Email,Status_Akun');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Pengguna'] == $Id AND $data['Kode_Verifikasi_Email'] == $Verifcode AND $data['Status_Akun'] == 'Belum Terverifikasi')
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

				$this->table    = 'pengguna';

				$non_fetch_data = $this->where($Data)->get("*", "Email");

				while ($row = $non_fetch_data->fetch()) 
				{
					return $row['ID_Pengguna'];
				}

				$this->disconnect();
			}
		} 
		catch (Error $e) 
		{
			echo $e->print();
		}
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
				$data_table  = $this->get(null, 'ID_Pengguna,Kode_Atur_Ulang_Katasandi,Akses_Atur_Ulang_Katasandi');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Pengguna'] == $Id AND $data['Kode_Atur_Ulang_Katasandi'] == $ResetCode AND $data['Akses_Atur_Ulang_Katasandi'] == 'Aktif')
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

	public function getUsersData($ID)
	{
		$data_table  = $this->query("SELECT * FROM pengguna WHERE ID_Pengguna='$ID'");

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
}