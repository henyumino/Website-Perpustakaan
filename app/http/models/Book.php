<?php

namespace app\http\models;

use Flare\Network\Http\Error;

use Flare\Components\Database\QueryBuilder;

class Book extends QueryBuilder
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
				$data_table  = $this->get(null, 'ID_Kategori_Buku');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Kategori_Buku'] == $Data)
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

	public function CheckBookID($Data = null)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckBookID() is empty");
			}
			else
			{
				$data_table  = $this->get(null, 'ID_Buku');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Buku'] == $Data)
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

	public function CheckCategoryID($Data = null)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckCategoryID() is empty");
			}
			else
			{
				$data_table  = $this->get(null, 'ID_Kategori_Buku');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Kategori_Buku'] == $Data)
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

	public function CheckBookStatisticID($Data = null)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckBookStatisticID() is empty");
			}
			else
			{
				$data_table  = $this->get(null, 'ID_Peminjaman');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Peminjaman'] == $Data)
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

	public function CheckCategoryName($Data = null)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckCategoryName() is empty");
			}
			else
			{
				if ($this->query("SELECT * FROM kategori_buku WHERE Nama='$Data'")->num_rows > 0)
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

	public function getCategory()
	{
		$data_table  = $this->get(null, '*');

		$array_data  = array();

		if ($data_table->rows() > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = $data_fetch['Nama'];
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function getCategory2($start, $end)
	{
		$data_table  = $this->query("SELECT * FROM kategori_buku ORDER BY Ditambahkan DESC LIMIT $start,$end");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Kategori_Buku' => $data_fetch['ID_Kategori_Buku'], 'Nama' => $data_fetch['Nama'], 'Ditambahkan' => $data_fetch['Ditambahkan'], 'Nama_Sekretaris' => $data_fetch['Nama_Sekretaris']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function getBook($start, $end)
	{
		$data_table  = $this->query("SELECT * FROM buku ORDER BY Ditambahkan DESC LIMIT $start,$end");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Buku' => $data_fetch['ID_Buku'], 'Folder_Buku' => $data_fetch['Folder_Buku'], 'Foto_Buku' => $data_fetch['Foto_Buku'], 'Judul_Buku' => $data_fetch['Judul_Buku'], 'Deskripsi_Buku' => $data_fetch['Deskripsi_Buku'], 'Pengarang_Buku' => $data_fetch['Nama_Pengarang'], 'Penerbit_Buku' => $data_fetch['Penerbit_Buku'], 'Tanggal_Terbit' => $data_fetch['Tanggal_Terbit'], 'Bulan_Terbit' => $data_fetch['Bulan_Terbit'], 'Tahun_Terbit' => $data_fetch['Tahun_Terbit'], 'Kategori_Buku' => $data_fetch['Kategori_Buku'], 'Jumlah_Buku' => $data_fetch['Jumlah_Buku'], 'Ditambahkan' => $data_fetch['Ditambahkan'], 'ID_Sekretaris' => $data_fetch['ID_Sekretaris'], 'Nama_Sekretaris' => $data_fetch['Nama_Sekretaris']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function getRecommendedBook($start, $end)
	{
		$data_table  = $this->query("SELECT * FROM buku ORDER BY Total_Rating DESC LIMIT $start,$end");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Buku' => $data_fetch['ID_Buku'], 'Folder_Buku' => $data_fetch['Folder_Buku'], 'Foto_Buku' => $data_fetch['Foto_Buku'], 'Judul_Buku' => $data_fetch['Judul_Buku'], 'Deskripsi_Buku' => $data_fetch['Deskripsi_Buku'], 'Pengarang_Buku' => $data_fetch['Nama_Pengarang'], 'Penerbit_Buku' => $data_fetch['Penerbit_Buku'], 'Tanggal_Terbit' => $data_fetch['Tanggal_Terbit'], 'Bulan_Terbit' => $data_fetch['Bulan_Terbit'], 'Tahun_Terbit' => $data_fetch['Tahun_Terbit'], 'Kategori_Buku' => $data_fetch['Kategori_Buku'], 'Jumlah_Buku' => $data_fetch['Jumlah_Buku'], 'Ditambahkan' => $data_fetch['Ditambahkan'], 'ID_Sekretaris' => $data_fetch['ID_Sekretaris'], 'Nama_Sekretaris' => $data_fetch['Nama_Sekretaris']);
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
		$data_table  = $this->query("SELECT buku.ID_Buku,buku.Folder_Buku,buku.Foto_Buku,buku.Judul_Buku,buku.Deskripsi_Buku,buku.Nama_Pengarang,buku.Penerbit_Buku,buku.Tanggal_Terbit,buku.Bulan_Terbit,buku.Tahun_Terbit,buku.Tempat_Terbit,buku.Kategori_Buku,buku.Jumlah_Buku,buku.Total_Rating,buku.Ditambahkan,buku.Ditambahkan,buku.ID_Sekretaris,buku.Nama_Sekretaris,kategori_buku.ID_Kategori_Buku FROM buku CROSS JOIN kategori_buku");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$array_data = $data_table->fetch_assoc();
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function getBorrowDetail($Data)
	{
		$data_table  = $this->query("SELECT * FROM statistik_buku WHERE ID_Peminjaman='$Data'");

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

	public function getCategoryRows()
	{
		return $this->get(null, '*')->rows();
	}

	public function getBookRows()
	{
		return $this->get(null, '*')->rows();
	}

	public function getBookStatisticRows()
	{
		return $this->get(null, '*')->rows();
	}

	public function getBookReviewRows()
	{
		return $this->get(null, '*')->rows();
	}

	public function getBookCategoryRows()
	{
		return $this->get(null, '*')->rows();
	}

	public function searchCategory($Keyword)
	{
		$data_table  = $this->query("SELECT * FROM kategori_buku WHERE Nama LIKE '%$Keyword%' OR ID_Kategori_Buku LIKE '%$Keyword%'");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Kategori_Buku' => $data_fetch['ID_Kategori_Buku'], 'Nama' => $data_fetch['Nama'], 'Ditambahkan' => $data_fetch['Ditambahkan'], 'Nama_Sekretaris' => $data_fetch['Nama_Sekretaris']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function searchBook($Keyword)
	{
		$data_table  = $this->query("SELECT * FROM buku WHERE Judul_Buku LIKE '%$Keyword%' OR ID_Buku LIKE '%$Keyword%'");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Buku' => $data_fetch['ID_Buku'], 'Judul_Buku' => $data_fetch['Judul_Buku'], 'Nama_Pengarang' => $data_fetch['Nama_Pengarang'], 'Penerbit_Buku' => $data_fetch['Penerbit_Buku'], 'Ditambahkan' => $data_fetch['Ditambahkan'], 'ID_Sekretaris' => $data_fetch['ID_Sekretaris'], 'Kategori_Buku' => $data_fetch['Kategori_Buku'], 'Nama_Sekretaris' => $data_fetch['Nama_Sekretaris'], 'Folder_Buku' => $data_fetch['Folder_Buku'], 'Foto_Buku' => $data_fetch['Foto_Buku']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function CheckPermission1($Id = null, $Code = null)
	{
		try 
		{
			if (empty($Id) OR is_null($Id) OR empty($Code) OR is_null($Code))
			{
				throw new Error("Parameter method CheckPermission1() is empty");
			}
			else
			{
				$data_table  = $this->get(null, 'ID_Peminjaman,ID_Pengguna,Status');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Pengguna'] == $Id)
						{
							if ($data['ID_Peminjaman'] == $Code)
							{
								if ($data['Status'] == 'Belum Terverifikasi')
								{
									return true;

									break;
								}
							}
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

	public function CheckPermission2($Id = null, $Code = null)
	{
		try 
		{
			if (empty($Id) OR is_null($Id) OR empty($Code) OR is_null($Code))
			{
				throw new Error("Parameter method CheckPermission2() is empty");
			}
			else
			{
				$data_table  = $this->get(null, 'ID_Peminjaman,ID_Pengguna,Status');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Pengguna'] == $Id)
						{
							if ($data['ID_Peminjaman'] == $Code)
							{
								if ($data['Status'] == 'Terverifikasi')
								{
									return true;

									break;
								}
							}
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

	public function getListMyBook($id, $start, $end)
	{
		$data_table  = $this->query("SELECT * FROM statistik_buku WHERE ID_Pengguna='$id' AND Status='Terverifikasi' ORDER BY Tanggal_Dipinjam DESC LIMIT $start,$end");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Peminjaman' => $data_fetch['ID_Peminjaman'], 'ID_Buku' => $data_fetch['ID_Buku'], 'Judul_Buku' => $data_fetch['Judul_Buku'], 'Tanggal_Dipinjam' => $data_fetch['Tanggal_Dipinjam'], 'Tanggal_Dikembalikan' => $data_fetch['Tanggal_Dikembalikan'], 'Keterangan' => $data_fetch['Keterangan'], 'Status' => $data_fetch['Status'], 'ID_Pengguna' => $data_fetch['ID_Pengguna']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function searchMyBook($Id, $Keyword)
	{
		$data_table  = $this->query("SELECT * FROM statistik_buku WHERE Judul_Buku LIKE '%$Keyword%' OR ID_Peminjaman LIKE '%$Keyword%' AND ID_Pengguna='$Id'");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Peminjaman' => $data_fetch['ID_Peminjaman'], 'ID_Buku' => $data_fetch['ID_Buku'], 'Judul_Buku' => $data_fetch['Judul_Buku'], 'Tanggal_Dipinjam' => date("d-m-Y H:i", strtotime($data_fetch['Tanggal_Dipinjam'])), 'Tanggal_Dikembalikan' => date("d-m-Y H:i", strtotime($data_fetch['Tanggal_Dikembalikan'])), 'Keterangan' => $data_fetch['Keterangan'], 'Status' => $data_fetch['Status'], 'ID_Pengguna' => $data_fetch['ID_Pengguna']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function CheckBokkWanttoBorrow($bookid, $usersid)
	{
		$data_table = $this->query("SELECT Keterangan,Status FROM statistik_buku WHERE ID_Buku='$bookid' AND ID_Pengguna='$usersid'");

		if ($data_table->num_rows > 0)
		{
			$data = $data_table->fetch_assoc();

			if ($data['Keterangan'] == 'Proses Peminjaman' AND $data['Status'] == 'Belum Terverifikasi')
			{
				return 'type_2';
			}
			else if ($data['Keterangan'] == 'Proses Peminjaman' AND $data['Status'] == 'Terverifikasi')
			{
				return 'type_3';
			}
			else
			{
				return 'type_4';
			}
		}
		else
		{
			return 'type_1';
		}
	}

	public function getBookStatistic($start, $end)
	{
		$data_table  = $this->query("SELECT statistik_buku.ID_Peminjaman,statistik_buku.ID_Buku,statistik_buku.Judul_Buku,statistik_buku.Tanggal_Dipinjam,statistik_buku.Tanggal_Dikembalikan,statistik_buku.Keterangan,statistik_buku.Status,statistik_buku.ID_Pengguna,pengguna.Nama FROM statistik_buku CROSS JOIN pengguna ORDER BY Tanggal_Dipinjam DESC LIMIT $start,$end");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Peminjaman' => $data_fetch['ID_Peminjaman'], 'ID_Buku' => $data_fetch['ID_Buku'], 'Judul_Buku' => $data_fetch['Judul_Buku'], 'Tanggal_Dipinjam' => $data_fetch['Tanggal_Dipinjam'], 'Tanggal_Dikembalikan' => $data_fetch['Tanggal_Dikembalikan'], 'Keterangan' => $data_fetch['Keterangan'], 'Status' => $data_fetch['Status'], 'ID_Pengguna' => $data_fetch['ID_Pengguna'], 'Nama' => $data_fetch['Nama']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function searchBookStatistic($Keyword)
	{
		$get_users_id  = $this->query("SELECT ID_Pengguna FROM statistik_buku WHERE ID_Peminjaman='$Keyword'")->fetch_assoc();

		$data_table  = $this->query("SELECT ID_Peminjaman,ID_Buku,Judul_Buku,Tanggal_Dipinjam,Tanggal_Dikembalikan,Keterangan,Status,Nama,Email FROM statistik_buku INNER JOIN pengguna ON pengguna.ID_Pengguna='".$get_users_id['ID_Pengguna']."' WHERE statistik_buku.ID_Peminjaman='$Keyword'");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Peminjaman' => $data_fetch['ID_Peminjaman'], 'ID_Buku' => $data_fetch['ID_Buku'], 'Judul_Buku' => $data_fetch['Judul_Buku'], 'Tanggal_Dipinjam' => date("d-m-Y H:i", strtotime($data_fetch['Tanggal_Dipinjam'])), 'Tanggal_Dikembalikan' => date("d-m-Y H:i", strtotime($data_fetch['Tanggal_Dikembalikan'])), 'Keterangan' => $data_fetch['Keterangan'], 'Status' => $data_fetch['Status'], 'Peminjam' => $data_fetch['Nama']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function getEditDataBorrowerBook($borrow_id)
	{
		$get_users_id  = $this->query("SELECT ID_Pengguna FROM statistik_buku WHERE ID_Peminjaman='$borrow_id'")->fetch_assoc();

		$data_table  = $this->query("SELECT ID_Peminjaman,ID_Buku,Judul_Buku,Tanggal_Dipinjam,Tanggal_Dikembalikan,Keterangan,Status,Nama,Email FROM statistik_buku INNER JOIN pengguna ON pengguna.ID_Pengguna='".$get_users_id['ID_Pengguna']."' WHERE statistik_buku.ID_Peminjaman='$borrow_id'");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$array_data = $data_table->fetch_assoc();
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function CheckUsersCanReviewBook($BookID = null, $UserID)
	{
		try 
		{
			if (empty($BookID) OR is_null($BookID) OR empty($UserID) OR is_null($UserID))
			{
				throw new Error("Parameter method CheckUsersCanReviewBook() is empty");
			}
			else
			{
				$data_table  = $this->get(null, 'ID_Buku, ID_Pengguna, Keterangan');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Buku'] == $BookID AND $data['ID_Pengguna'] == $UserID AND $data['Keterangan'] == 'Dikembalikan')
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

	public function getBorrowID($BookID = null, $UserID = null)
	{
		try 
		{
			if (empty($BookID) OR is_null($BookID) OR empty($UserID) OR is_null($UserID))
			{
				throw new Error("Parameter method getBorrowID() is empty");
			}
			else
			{
				$data_table = $this->query("SELECT ID_Peminjaman FROM statistik_buku WHERE ID_Buku='$BookID' AND ID_Pengguna='$UserID'");

				if ($data_table->num_rows > 0) 
				{
					return $data_table->fetch_assoc();
				}
				else
				{
					return null;
				}
			}
		} 
		catch (Error $e)
		{
			echo $e->print();	
		}
	}

	public function getNumRowReviewBook($BookID = null)
	{
		try 
		{
			if (empty($BookID) OR is_null($BookID))
			{
				throw new Error("Parameter method getBorrowID() is empty");
			}
			else
			{
				$data_table = $this->query("SELECT * FROM ulasan_buku WHERE ID_Buku='$BookID'");

				if ($data_table->num_rows > 0) 
				{
					return $data_table->num_rows;
				}
				else
				{
					return 0;
				}
			}
		} 
		catch (Error $e)
		{
			echo $e->print();	
		}
	}

	public function getReviewBook($BookID = null)
	{
		try 
		{
			if (empty($BookID) OR is_null($BookID))
			{
				throw new Error("Parameter method getBorrowID() is empty");
			}
			else
			{
				$data_table = $this->query("SELECT * FROM ulasan_buku WHERE ID_Buku='$BookID'");

				if ($data_table->num_rows > 0) 
				{
					return $data_table->fetch_assoc();
				}
				else
				{
					return null;
				}
			}
		} 
		catch (Error $e)
		{
			echo $e->print();	
		}
	}

	public function getReview($bookid, $start, $end)
	{
		$data_table  = $this->query("SELECT * FROM ulasan_buku WHERE ID_Buku='$bookid' ORDER BY Tanggal_Diulas DESC LIMIT $start,$end");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Ulasan' => $data_fetch['ID_Ulasan'], 'ID_Pengguna' => $data_fetch['ID_Pengguna'], 'Nama' => $data_fetch['Nama'], 'Isi_Ulasan' => $data_fetch['Isi_Ulasan'], 'Jumlah_Rating' => $data_fetch['Jumlah_Rating'], 'Tanggal_Diulas' => $data_fetch['Tanggal_Diulas']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}

	public function CheckReviewID($Data = null)
	{
		try 
		{
			if (empty($Data) OR is_null($Data))
			{
				throw new Error("Parameter method CheckReviewID() is empty");
			}
			else
			{
				$data_table  = $this->get(null, 'ID_Ulasan');

				if ($data_table->rows() > 0)
				{
					while ($data = $data_table->fetch()) 
					{
						if ($data['ID_Ulasan'] == $Data)
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

	public function getBookCategory($categoryname, $start, $end)
	{
		$data_table  = $this->query("SELECT * FROM buku WHERE Kategori_Buku='$categoryname' ORDER BY Ditambahkan DESC LIMIT $start,$end");

		$array_data  = array();

		if ($data_table->num_rows > 0) 
		{
			$counter = 0;

			while ($data_fetch = $data_table->fetch_assoc()) 
			{
				$counter=$counter+1;
				$array_data[$counter] = array('ID_Buku' => $data_fetch['ID_Buku'], 'Folder_Buku' => $data_fetch['Folder_Buku'], 'Foto_Buku' => $data_fetch['Foto_Buku'], 'Judul_Buku' => $data_fetch['Judul_Buku'], 'Deskripsi_Buku' => $data_fetch['Deskripsi_Buku'], 'Pengarang_Buku' => $data_fetch['Nama_Pengarang'], 'Penerbit_Buku' => $data_fetch['Penerbit_Buku'], 'Tanggal_Terbit' => $data_fetch['Tanggal_Terbit'], 'Bulan_Terbit' => $data_fetch['Bulan_Terbit'], 'Tahun_Terbit' => $data_fetch['Tahun_Terbit'], 'Kategori_Buku' => $data_fetch['Kategori_Buku'], 'Jumlah_Buku' => $data_fetch['Jumlah_Buku'], 'Ditambahkan' => $data_fetch['Ditambahkan'], 'ID_Sekretaris' => $data_fetch['ID_Sekretaris'], 'Nama_Sekretaris' => $data_fetch['Nama_Sekretaris']);
			}
		}
		else
		{
			$array_data = null;
		}

		return $array_data;
	}
}