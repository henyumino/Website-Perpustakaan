<?php

namespace app\http\models;

use Flare\Components\Database\QueryBuilder;

class Finance extends QueryBuilder
{
	public function CheckID($Data = null)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckID() is empty");
			}
			else
			{
				$data_table = $this->get(null, 'ID_Laporan');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Laporan'] == $Data)
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

	public function convertNumberToIDRFormat($Number)
	{
		$result_convert = "Rp " . number_format($Number,2,',','.');

		return $result_convert;
	}

	public function getTotalRows()
	{
		return $this->get(null, '*')->rows();
	}

	public function getReports($start, $end)
	{
		$data_table  = $this->query("SELECT * FROM statistik_keuangan ORDER BY Waktu DESC LIMIT $start,$end");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Laporan' => $data_fetch['ID_Laporan'], 'Waktu' => date("d-m-Y H:i", strtotime($data_fetch['Waktu'])), 'Dana_Masuk' => $this->convertNumberToIDRFormat($data_fetch['Dana_Masuk']), 'Dana_Keluar' => $this->convertNumberToIDRFormat($data_fetch['Dana_Keluar']), 'Keterangan' => $data_fetch['Keterangan'], 'ID_Bendahara' => $data_fetch['ID_Bendahara'], 'Nama_Bendahara' => $data_fetch['Nama_Bendahara']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function getEditData($Data)
	{
		$data_table  = $this->query("SELECT * FROM statistik_keuangan WHERE ID_Laporan='$Data'");

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

	public function searchReport($Month, $Year)
	{
		$data_table  = $this->query("SELECT * FROM statistik_keuangan WHERE MONTH(Waktu) = $Month AND YEAR(Waktu) = $Year");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Laporan' => $data_fetch['ID_Laporan'], 'Waktu' => $data_fetch['Waktu'], 'Dana_Masuk' => $this->convertNumberToIDRFormat($data_fetch['Dana_Masuk']), 'Dana_Keluar' => $this->convertNumberToIDRFormat($data_fetch['Dana_Keluar']), 'Keterangan' => $data_fetch['Keterangan'], 'ID_Bendahara' => $data_fetch['ID_Bendahara'], 'Nama_Bendahara' => $data_fetch['Nama_Bendahara']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}
}

?>