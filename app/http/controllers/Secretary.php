<?php

use Flare\Network\Http\Controller;

use Flare\Components\Environment;

use Flare\Network\Http\Ajax;

use Flare\Components\Validation;

class Secretary extends Controller
{

	public function getEnv($Key)
	{
		Environment::include();

		return Environment::get($Key);
	}

	public function parts($Data = null)
	{
		$this->securedView('parts');

		if (is_null($Data) == false OR empty($Data) == false)
		{
			self::load('header.php', $Data);

			self::load('body.php', $Data);
		
			self::load('footer.php', $Data);
		}
		else
		{
			self::load('header.php');

			self::load('body.php');
		
			self::load('footer.php');
		}
	}

	public function viewSetupPage()
	{
		if (isset($_GET['secretary_id']) AND empty($_GET['secretary_id']) == false)
		{
			if (isset($_GET['setup_code']) AND empty($_GET['setup_code']) == false)
			{
				$secretary_id_get = $_GET['secretary_id'];

				$setup_code_get   = $_GET['setup_code'];

				$secretary_model  = new app\http\models\Secretary;

				$secretary_model->connect();

				$secretary_model->table = 'sekretaris';

				if ($secretary_model->CheckAccessSetupPage($secretary_id_get, $setup_code_get))
				{
					$data = array
							(
								"URL"                => $this->getEnv('BASE_URL'),
								"ID_Sekretaris"      => $secretary_id_get
							);

					$this->parts($data); 
				}
				else
				{
					$this->error_404();
				}
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewLogin()
	{
		$data = array
				(
					"URL" => $this->getEnv('BASE_URL')
				); 

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;		

		$session->start();

		if ($session->check('secretary') == true)
		{
		    $secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			if ($secretary_model->CheckID($session->value('secretary')))
			{
				$secretary_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/secretary/dashboard/');
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($secretary_model->CheckID($encode->unprotected($cookie->value('secretary'))))
			{
				$secretary_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/secretary/dashboard/');
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{		
		   $this->parts($data);
		}
	}

	public function loginAjax()
	{
		if (Ajax::check())
		{
			$secretary_login_data      = Ajax::AngularInput();

			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			if (Validation::isEmpty($secretary_login_data->email))
			{
				Ajax::json_response(array('Tag' => '#69e0bhf1c4', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email masih kosong'));
			}
			else if (Validation::isEmpty($secretary_login_data->password))
			{
				Ajax::json_response(array('Tag' => '#20e29h12gd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi masih kosong'));
			}
			else
			{
				if (Validation::Regex("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/", $secretary_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#2470g04118', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format email yang anda masukkan salah'));
				}
				else if (Validation::Minimum(15, $secretary_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#5dh2gb9f7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email minimal terdapat 15 karakter'));
				}
				else if (Validation::Maximum(50, $secretary_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#3g946e7b5d', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email maksimal terdapat 50 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z-0-9]*$/", $secretary_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#d991d452df', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $secretary_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#dgh9dcbeh9', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(25, $secretary_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#c86b5df820', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi maksimal terdapat 25 karakter'));
				}
				else if ($secretary_model->CheckEmail($secretary_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#1e5h24ce21', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email yang anda masukkan salah'));

				}
				else if ($secretary_model->CheckPassword($secretary_model->get(null, 'Katasandi')->fetch(), $secretary_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#1e87ab2a0a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi yang anda masukkan salah'));
				}
				else if ($secretary_model->CheckAccess($secretary_model->getId($secretary_login_data->email)))
				{
					Ajax::json_response(array('Tag' => '#c4956ef651', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Akun yang anda gunakan belum melakukan konfigurasi. Silahkan melakukan konfigurasi dengan cara mengunjungi tautan yang dikirim ke email akun ini'));
				}
				else 
				{
					if ($secretary_login_data->method == 'cookie')
					{
						$encode         = new Flare\Components\Encode;

						$encode->key    = $this->getEnv('KEY');

						$cookie         = new Flare\Network\Http\Cookie;

						$cookie->name   = 'secretary';

						$cookie->give()->use($encode->protect($secretary_model->getId($secretary_login_data->email)));

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Type' => 'success'));

						$secretary_model->disconnect();
					}
					else if ($secretary_login_data->method == 'session')
					{
						$session = new Flare\Network\Http\Session;

						$session->name = "secretary";

						$session->start();

						$session->give()->use($secretary_model->getId($secretary_login_data->email));

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Type' => 'success'));

						$secretary_model->disconnect();
					}
					else
					{
						Ajax::json_response(array('Tag' => '#7ea1bh18a3', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan proses login anda tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
					}
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function processLogout()
	{
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;		

		$session->start();

		if ($session->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			if ($secretary_model->CheckID($session->value('secretary')))
			{
				$secretary_model->disconnect();

				$session->take('secretary');

				self::redirect('http://localhost:8080/projekuas/secretary/login/');
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($secretary_model->CheckID($encode->unprotected($cookie->value('secretary'))))
			{
				$secretary_model->disconnect();

				$cookie->take('secretary');

				self::redirect('http://localhost:8080/projekuas/secretary/login/');
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewDashboard()
	{
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			if ($secretary_model->CheckID($session->value('secretary')))
			{

				$book_model         = new app\http\models\Book;

				$book_model->connect();

				$book_model->table  = 'kategori_buku';

				$all_category       = $book_model->getCategory();

				$book_model->table  = 'buku';

				$limit_display      = 5;

				$set_page           = isset($_GET['page'])? (int)$_GET["page"]:1;
        
        		$check_page         = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

				$total_rows         = $book_model->getBookRows();

				$ceilIt             = ceil($total_rows/$limit_display);

		 		$list_book 			= $book_model->getBook($check_page, $limit_display);

				$data = array
						(
						  "URL"   			 => $this->getEnv('BASE_URL'),
						  "Data_Sekretaris"  => $secretary_model->getSecretaryData($session->value('secretary')),
						  "Data_Buku"        => $list_book,
				     	  "Halaman_Paging"   => $set_page,
					      "Total_Halaman"    => $ceilIt,
					      "Kategori_Buku"    => $all_category
						); 

				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($secretary_model->CheckID($encode->unprotected($cookie->value('secretary'))))
			{
				$book_model         = new app\http\models\Book;

				$book_model->connect();

				$book_model->table  = 'kategori_buku';

				$all_category       = $book_model->getCategory();

				$book_model->table  = 'buku';

				$limit_display      = 5;

				$set_page           = isset($_GET['page'])? (int)$_GET["page"]:1;
        
        		$check_page         = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

				$total_rows         = $book_model->getBookRows();

				$ceilIt             = ceil($total_rows/$limit_display);

		 		$list_book 			= $book_model->getBook($check_page, $limit_display);

				$data = array
						(
						  "URL"   			 => $this->getEnv('BASE_URL'),
						  "Data_Sekretaris"  => $secretary_model->getSecretaryData($encode->unprotected($cookie->value('secretary'))),
						  "Data_Buku"        => $list_book,
				     	  "Halaman_Paging"   => $set_page,
					      "Total_Halaman"    => $ceilIt,
					      "Kategori_Buku"    => $all_category
						); 

				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function setupAjax()
	{
		if (Ajax::check())
		{

			$setup_data                 = Ajax::AngularInput();

			$secretary_model            = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table     = 'sekretaris';

			if (Validation::isEmpty($setup_data->password))
			{
				Ajax::json_response(array('Tag' => '#638a92829d', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi masih kosong'));
			}
			else if (Validation::isEmpty($setup_data->confirmpassword))
			{
				Ajax::json_response(array('Tag' => '#cg334048ef', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Konfirmasi katasandi masih kosong'));
			}
			else
			{
				if (Validation::Regex("/^[a-zA-Z-0-9]*$/", $setup_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#bg53799h97', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $setup_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#5b1ahg6ec0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(25, $setup_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#f98662e1c2', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi maksimal terdapat 25 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z-0-9]*$/", $setup_data->confirmpassword) == false)
				{
					Ajax::json_response(array('Tag' => '#af900d742a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Konfirmasi katasandi hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $setup_data->confirmpassword) == false)
				{
					Ajax::json_response(array('Tag' => '#eb9gd2685f', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Konfirmasi katasandi minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(25, $setup_data->confirmpassword) == false)
				{
					Ajax::json_response(array('Tag' => '#aa5772b2hd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Konfirmasi katasandi maksimal terdapat 25 karakter'));
				}
				else if ($setup_data->password != $setup_data->confirmpassword)
				{
					Ajax::json_response(array('Tag' => '7edca7ac99', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi berbeda dengan konfirmasi katasandi'));
				}
				else
				{
					$newpassword = password_hash($setup_data->password, PASSWORD_DEFAULT);

					if ($secretary_model->where($setup_data->id)->update("Katasandi='$newpassword', Status_Akun='Terverifikasi'", "ID_Sekretaris"))
					{
						$session         = new Flare\Network\Http\Session;

						$session->name   = "secretary";

						$session->start();

						$session->give()->use($setup_data->id);

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Pengaturan katasandi berhasil'));

						$secretary_model->disconnect();
					}
					else
					{
						Ajax::json_response(array('Tag' => '#7ea1bh18a3', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengaturan katasandi tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
					}
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewManageBooks()
	{

		$book_model         = new app\http\models\Book;

		$book_model->connect();

		$book_model->table  = 'kategori_buku';

		$all_category       = $book_model->getCategory();

		$book_model->disconnect();

		$book_model->connect();

		$book_model->table  = 'buku';

		$limit_display      = 5;

		$set_page           = isset($_GET['page'])? (int)$_GET["page"]:1;
        
        $check_page         = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

		$total_rows         = $book_model->getBookRows();

		$ceilIt             = ceil($total_rows/$limit_display);

		$list_book 			= $book_model->getBook($check_page, $limit_display);

		$data = array
				(
					"URL"             => $this->getEnv('BASE_URL'),
					"Kategori_Buku"   => $all_category,
					"Buku"            => $list_book,
					"Halaman_Paging"  => $set_page,
					"Total_Halaman"   => $ceilIt
				); 

		$book_model->disconnect();

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			if ($secretary_model->CheckID($session->value('secretary')))
			{
				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($secretary_model->CheckID($encode->unprotected($cookie->value('secretary'))))
			{
				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewManageCategory()
	{

		$book_model         = new app\http\models\Book;

		$book_model->connect();

		$book_model->table  = 'kategori_buku';

		$limit_display      = 5;

		$set_page           = isset($_GET['page'])? (int)$_GET["page"]:1;
        
        $check_page         = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

		$total_rows         = $book_model->getCategoryRows();

		$ceilIt             = ceil($total_rows/$limit_display);

		$list_book_category = $book_model->getCategory2($check_page, $limit_display);

		$book_model->disconnect();

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			if ($secretary_model->CheckID($session->value('secretary')))
			{
				$data = array
				(
					"URL"              => $this->getEnv('BASE_URL'),
					"Data_Sekretaris"  => $secretary_model->getSecretaryData($session->value('secretary')),
					"Kategori_Buku"    => $list_book_category,
					"Halaman_Paging"   => $set_page,
					"Total_Halaman"	   => $ceilIt
				); 

				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($secretary_model->CheckID($encode->unprotected($cookie->value('secretary'))))
			{
				$data = array
				(
					"URL"              => $this->getEnv('BASE_URL'),
					"Data_Sekretaris"  => $secretary_model->getSecretaryData($encode->unprotected($cookie->value('secretary'))),
					"Kategori_Buku"    => $list_book_category,
					"Halaman_Paging"   => $set_page,
					"Total_Halaman"	   => $ceilIt
				); 

				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function addCategoryAjax()
	{
		if (Ajax::check())
		{
			$add_category_data  = Ajax::AngularInput();

			if (Validation::isEmpty($add_category_data->categoryname))
			{
				Ajax::json_response(array('Tag' => '#gce674b82f', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama kategori masih kosong'));
			}
			else
			{
				if (Validation::Regex("/^[a-zA-Z ]*$/", $add_category_data->categoryname) == false)
				{
					Ajax::json_response(array('Tag' => '#b36d59587f', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama kategori hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $add_category_data->categoryname) == false)
				{
					Ajax::json_response(array('Tag' => '#669bb1d967', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama kategori minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(40, $add_category_data->categoryname) == false)
				{
					Ajax::json_response(array('Tag' => '#d2g71e54be', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama kategori maksimal terdapat 40 karakter'));
				}
				else
				{
					$book_model  = new app\http\models\Book;

					$book_model->connect();

					$book_model->table = 'kategori_buku';

					if ($book_model->CheckCategoryName($add_category_data->categoryname))
					{
						Ajax::json_response(array('Tag' => '#hh16fbe96h', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama kategori yang anda ingin tambahkan sudah ada'));
					}
					else
					{

						$book_model->connect();

						$encode         = new Flare\Components\Encode;

						$encode->key    = $this->getEnv('KEY');

						$cookie         = new Flare\Network\Http\Cookie;

						$cookie->name   = 'secretary';

						$session = new Flare\Network\Http\Session;

						$session->name  = 'secretary';

						$session->start();

						$category_id    = substr(str_shuffle('0123456789012345678901234567890123456789'),0,40);

						$secretary_id   = $session->check('secretary') ? $session->value('secretary') : $encode->unprotected($cookie->value('secretary'));

						$secretary_model = new app\http\models\Secretary;

						$secretary_model->connect();

						$secretary_model->table = 'sekretaris';

						$secretary_name = $secretary_model->where($secretary_id)->get('Nama', 'ID_Sekretaris')->fetch();

						$date           = date("Y/m/d");

						if ($book_model->insert("ID_Kategori_Buku,Nama,Ditambahkan,ID_Sekretaris,Nama_Sekretaris", "'$category_id','$add_category_data->categoryname','$date','$secretary_id','".$secretary_name['Nama']."'")) 
						{
							$book_model->disconnect();

							Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Kategori berhasil ditambahkan'));
						}
						else
						{
							Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan kategori tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
						}
					}
				}
			}			
		}
		else
		{
			$this->error_404();
		}
	}

	public function addBookAjax()
	{

		if (Validation::isEmpty(Validation::SecureInput($_POST['booktitle'])))
		{
			Ajax::json_response(array('Tag' => '#6ae6abec7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Judul buku masih kosong'));
		}
		else if (Validation::isEmpty(Validation::SecureInput($_POST['bookdescription'])))
		{
			Ajax::json_response(array('Tag' => '#f02ehc3e92', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Deskripsi buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['authorname']))
		{
			Ajax::json_response(array('Tag' => '#ec5d329573', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama pengarang masih kosong'));
		}
		else if (Validation::isEmpty($_POST['bookpublisher']))
		{
			Ajax::json_response(array('Tag' => '#3g719h17bh', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Penerbit buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['datepublished']))
		{
			Ajax::json_response(array('Tag' => '#6ada3hbg22', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tanggal terbit buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['monthpublished']))
		{
			Ajax::json_response(array('Tag' => '#48fdgfg0dg', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Bulan terbit buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['yearpublished']))
		{
			Ajax::json_response(array('Tag' => '#f78hc7g50e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tahun terbit buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['placepublished']))
		{
			Ajax::json_response(array('Tag' => '#7ge30bb482', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tempat terbit buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['bookcategory']))
		{
			Ajax::json_response(array('Tag' => '#cdcf7h5e72', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kategori buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['numberofbook']))
		{
			Ajax::json_response(array('Tag' => '#ghf6fbefbe', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jumlah buku masih kosong'));
		}
		else if (Validation::isEmpty($_FILES) OR is_null($_FILES))
		{	
			Ajax::json_response(array('Tag' => '#2875959bag', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Gambar buku belum dipilih'));
		}
		else
		{
			if (Validation::Minimum(5, Validation::SecureInput($_POST['booktitle'])) == false)
			{
				Ajax::json_response(array('Tag' => '#12b38b1e09', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Judul buku minimal terdapat 5 karakter'));
			}
			else if (Validation::Maximum(80, Validation::SecureInput($_POST['booktitle'])) == false)
			{
				Ajax::json_response(array('Tag' => '#ac143beahg', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Judul buku maksimal 80 terdapat karakter'));
			}
			else if (Validation::Minimum(50, Validation::SecureInput($_POST['bookdescription'])) == false)
			{
				Ajax::json_response(array('Tag' => '#f967g370b1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Deskripsi buku minimal terdapat 50 karakter'));
			}
			else if (Validation::Maximum(1000, Validation::SecureInput($_POST['bookdescription'])) == false)
			{
				Ajax::json_response(array('Tag' => '#41h0818d39', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Deskripsi buku maksimal terdapat 1000 karakter'));
			}
			else if (Validation::Regex("/^[a-zA-Z ]*$/", $_POST['authorname']) == false)
			{
				Ajax::json_response(array('Tag' => '#66a66e4bd2', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama pengarang hanya boleh berisi huruf dan spasi'));
			}
			else if (Validation::Minimum(3, $_POST['authorname']) == false)
			{
				Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama pengarang minimal terdapat 3 karakter'));
			}
			else if (Validation::Maximum(25, $_POST['authorname']) == false)
			{
				Ajax::json_response(array('Tag' => '#827h4bgd8c', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama pengarang maksimal terdapat 25 karakter'));
			}
			else if (Validation::Regex("/^[a-zA-Z ]*$/", $_POST['bookpublisher']) == false)
			{
				Ajax::json_response(array('Tag' => '#0a6781f619', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Penerbit buku hanya boleh berisi huruf dan spasi'));
			}
			else if (Validation::Minimum(5, $_POST['bookpublisher']) == false)
			{
				Ajax::json_response(array('Tag' => '#41791ef7h0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Penerbit buku minimal terdapat 5 karakter'));
			}
			else if (Validation::Maximum(50, $_POST['bookpublisher']) == false)
			{
				Ajax::json_response(array('Tag' => '#gc4f4e8072', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Penerbit buku maksimal terdapat 50 karakter'));
			}
			else if (Validation::Regex("/^[a-zA-Z-0-9 ]*$/", $_POST['placepublished']) == false)
			{
				Ajax::json_response(array('Tag' => '#805d2d8bd0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tempat terbit buku hanya boleh berisi huruf, angka dan spasi'));
			}
			else if (Validation::Minimum(5, $_POST['placepublished']) == false)
			{
				Ajax::json_response(array('Tag' => '#hf61600h4a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tempat terbit buku minimal terdapat 5 karakter'));
			}
			else if (Validation::Maximum(50, $_POST['placepublished']) == false)
			{
				Ajax::json_response(array('Tag' => '#87d65f1ha0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tempat terbit buku maksimal terdapat 50 karakter'));
			}
			else if (Validation::Regex("/^[0-9]*$/", $_POST['numberofbook']) == false)
			{
				Ajax::json_response(array('Tag' => '#eh829g2f9e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jumlah buku hanya boleh berisi angka'));
			}
			else if ($_POST['numberofbook'] <= 0)
			{
				Ajax::json_response(array('Tag' => '#ddafagc5d1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jumlah buku minimal 1'));
			}
			else if ($_POST['numberofbook'] > 5000)
			{
				Ajax::json_response(array('Tag' => '#63hd42g63b', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jumlah buku maksimal 5000'));
			}
			else
			{

				$book_img          = $_FILES;

				$book_img_fname    = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,40);

				$book_img_ext      = explode('.', $book_img['file']['name']);

				$book_img_ext      = strtolower(end($book_img_ext));

				$book_img_size     = $book_img['file']['size'];

				$book_img_name     = $book_img_fname.".".$book_img_ext;

				$book_id           = substr(str_shuffle('0123456789012345678901234567890123456789'),0,40);

				$book_folder       = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,40);

				$booktitle         = Validation::SecureInput($_POST['booktitle']);
				
				$bookdescription   = Validation::SecureInput($_POST['bookdescription']);

				$authorname        = $_POST['authorname'];

				$bookpublisher     = $_POST['bookpublisher'];

				$datepublished     = $_POST['datepublished'];

				$monthpublished    = $_POST['monthpublished'];

				$yearpublished     = $_POST['yearpublished'];

				$placepublished    = $_POST['placepublished'];

				$bookcategory      = $_POST['bookcategory'];

				$numberofbook      = $_POST['numberofbook'];

				$secretary_model   = new app\http\models\Secretary;

				$secretary_model->connect();

				$secretary_model->table = 'sekretaris';

				$encode            = new Flare\Components\Encode;

				$encode->key       = $this->getEnv('KEY');

				$cookie            = new Flare\Network\Http\Cookie;

				$session           = new Flare\Network\Http\Session;

				$session->start();

				$secretary_id      =  $session->check('secretary') ? $session->value('secretary') : $encode->unprotected($cookie->value('secretary'));

				$secretary_name = $secretary_model->where($secretary_id)->get('Nama', 'ID_Sekretaris')->fetch();

				if ($book_img_ext == 'jpg' AND $book_img_ext != 'png' OR $book_img_ext != 'jpg' AND $book_img_ext == 'png')
				{
					if ($book_img_size < 5242880)
					{

						if (!file_exists("../resources/assets/".$book_folder."/".$book_img_fname.$book_img_ext))
						{
							mkdir("../resources/assets/".$book_folder, 0777, true);

							if (move_uploaded_file($book_img['file']['tmp_name'], "../resources/assets/".$book_folder."/".$book_img_name))
							{
								if (copy('../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/index.php', '../resources/assets/'.$book_folder.'/index.php'))
								{
									$book_model        = new app\http\models\Book;

									$book_model->connect();

									$book_model->table = 'buku';

									$date           = date("Y/m/d");

									if ($book_model->insert("ID_Buku,Folder_Buku,Foto_Buku,Judul_Buku,Deskripsi_Buku,Nama_Pengarang,Penerbit_Buku,Tanggal_Terbit,Bulan_Terbit,Tahun_Terbit,Tempat_Terbit,Kategori_Buku,Jumlah_Buku,Total_Rating,Ditambahkan,ID_Sekretaris,Nama_Sekretaris", "'$book_id','$book_folder','$book_img_name','$booktitle','$bookdescription','$authorname','$bookpublisher','$datepublished','$monthpublished','$yearpublished','$placepublished','$bookcategory','$numberofbook','0','$date','$secretary_id','".$secretary_name['Nama']."'"))
									{
										Ajax::json_response(array('Tag' => '#8h6g1gc456', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Buku telah berhasil ditambahkan'));
									}
									else
									{
							 			 Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
									}
								}
								else
								{
									Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
								}
							}
							else
							{
								Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
							}
						}
						else
						{
							Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
						}
					}
					else
					{
						Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Ukuran gambar buku maksimal 5 MB'));
					}
				}
				else
				{
					Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Gambar buku harus berupa PNG atau JPG'));
				}
			}
		}
	}

	public function deleteCategoryAjax()
	{
		if (Ajax::Check())
		{
			$delete_category_data = Ajax::AngularInput();

			if (Validation::isEmpty($delete_category_data->category_id) == false)
			{
				$book_model         = new app\http\models\Book;

				$book_model->connect();

				$book_model->table  = 'kategori_buku';

				if ($book_model->CheckID($delete_category_data->category_id))
				{
					if ($book_model->where($delete_category_data->category_id)->delete('ID_Kategori_Buku'))
					{
						Ajax::json_response(array('Tag' => '#ba434e5b80', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Kategori berhasil dihapus'));
					}
					else
					{
						Ajax::json_response(array('Tag' => '#eca4ddce4b', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan kategori tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
					}
				}
				else
				{
					Ajax::json_response(array('Tag' => '#e1gbed84fg', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan kategori tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
				}

				$book_model->disconnect();
			}
			else
			{
				Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan kategori tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewEditCategory()
	{
		if (isset($_GET['category_id']))
		{
			$session = new Flare\Network\Http\Session;

			$cookie  = new Flare\Network\Http\Cookie;

			$session->start();

			if ($session->check('secretary') == true)
			{
				$secretary_model           = new app\http\models\Secretary;

				$secretary_model->connect();

				$secretary_model->table    = 'sekretaris';

				if ($secretary_model->CheckID($session->value('secretary')))
				{
					$category_id        = $_GET['category_id'];

					$book_model         = new app\http\models\Book;

					$book_model->connect();

					$book_model->table  = 'kategori_buku';

					if ($book_model->CheckID($category_id))
					{
						$secretary_model->disconnect();

						$category_id        = $_GET['category_id'];

						$book_model         = new app\http\models\Book;

						$book_model->connect();

						$book_model->table  = 'kategori_buku';

						$data = array
									(
										"URL"           => $this->getEnv('BASE_URL'),
										"Data_Sekretaris"  => $secretary_model->getSecretaryData($session->value('secretary')),
										"Nama_Kategori" => $book_model->where($category_id)->get('Nama', 'ID_Kategori_Buku')->fetch()
									);

						$this->parts($data);
					}
					else
					{
						$this->error_404();
					}
				}
				else
				{
					$this->error_404();
				}
			}
			else if ($cookie->check('secretary') == true)
			{
				$secretary_model           = new app\http\models\Secretary;

				$secretary_model->connect();

				$secretary_model->table    = 'sekretaris';

				$encode         = new Flare\Components\Encode;

				$encode->key    = $this->getEnv('KEY');

				if ($secretary_model->CheckID($encode->unprotected($cookie->value('secretary'))))
				{
					$secretary_model->disconnect();

					$category_id        = $_GET['category_id'];

					$book_model         = new app\http\models\Book;

					$book_model->connect();

					$book_model->table  = 'kategori_buku';

					if ($book_model->CheckID($category_id))
					{
						$data = array
									(
										"URL"           => $this->getEnv('BASE_URL'),
										"Data_Sekretaris"  => $secretary_model->getSecretaryData($encode->unprotected($cookie->value('secretary'))),
										"Nama_Kategori" => $book_model->where($category_id)->get('Nama', 'ID_Kategori_Buku')->fetch()
									);

						$this->parts($data);
					}
					else
					{
						$this->error_404();
					}
				}
				else
				{
					$this->error_404();
				}
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function editCategoryAjax()
	{
		if (Ajax::check())
		{
			$edit_category_data = Ajax::AngularInput();

			if (Validation::isEmpty($edit_category_data->categoryname))
			{
				Ajax::json_response(array('Tag' => '#gce674b82f', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama kategori masih kosong'));
			}
			else
			{
				if (Validation::Regex("/^[a-zA-Z ]*$/", $edit_category_data->categoryname) == false)
				{
					Ajax::json_response(array('Tag' => '#b36d59587f', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama kategori hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $edit_category_data->categoryname) == false)
				{
					Ajax::json_response(array('Tag' => '#669bb1d967', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama kategori minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(40, $edit_category_data->categoryname) == false)
				{
					Ajax::json_response(array('Tag' => '#d2g71e54be', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama kategori maksimal terdapat 40 karakter'));
				}
				else
				{
					$session = new Flare\Network\Http\Session;

					$cookie  = new Flare\Network\Http\Cookie;

					$session->start();

					$book_model          = new app\http\models\Book;

					$book_model->connect();

					$book_model->table   = 'kategori_buku';

					$secretary_id   = $session->check('secretary') ? $session->value('secretary') : $encode->unprotected($cookie->value('secretary'));

					$secretary_model = new app\http\models\Secretary;

					$secretary_model->connect();

					$secretary_model->table = 'sekretaris';

					$secretary_name = $secretary_model->where($secretary_id)->get('Nama', 'ID_Sekretaris')->fetch();

					$date           = date("Y/m/d");

					if ($book_model->where($edit_category_data->id)->update("Nama='$edit_category_data->categoryname', Ditambahkan='$date', ID_Sekretaris='$secretary_id', Nama_Sekretaris='".$secretary_name['Nama']."'", "ID_Kategori_Buku"))
					{
						$book_model->disconnect();

						Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Kategori berhasil diedit', 'new_category_name' => $edit_category_data->categoryname));
					}
					else
					{
						Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan kategori tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
					}
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function deleteBookAjax()
	{
		if (Ajax::Check())
		{
			$delete_book_data = Ajax::AngularInput();

			if (Validation::isEmpty($delete_book_data->book_id) == false)
			{
				$book_model         = new app\http\models\Book;

				$book_model->connect();

				$book_model->table  = 'buku';

				if ($book_model->CheckBookID($delete_book_data->book_id))
				{
					if ($book_model->where($delete_book_data->book_id)->delete('ID_Buku'))
					{
						Ajax::json_response(array('Tag' => '#ba434e5b80', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Buku berhasil dihapus'));
					}
					else
					{
						Ajax::json_response(array('Tag' => '#eca4ddce4b', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
					}
				}
				else
				{
					Ajax::json_response(array('Tag' => '#e1gbed84fg', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
				}

				$book_model->disconnect();
			}
			else
			{
				Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewEditBook()
	{
		if (isset($_GET['book_id']))
		{
			$session = new Flare\Network\Http\Session;

			$cookie  = new Flare\Network\Http\Cookie;

			$session->start();

			if ($session->check('secretary') == true)
			{
				$secretary_model           = new app\http\models\Secretary;

				$secretary_model->connect();

				$secretary_model->table    = 'sekretaris';

				if ($secretary_model->CheckID($session->value('secretary')))
				{
					$book_id	        = $_GET['book_id'];

					$book_model         = new app\http\models\Book;

					$book_model->connect();

					$book_model->table  = 'kategori_buku';

					$all_category       = $book_model->getCategory();

					$book_model->table  = 'buku';

					if ($book_model->CheckBookID($book_id))
					{
						$secretary_model->disconnect();

						$book_model         = new app\http\models\Book;

						$book_model->connect();

						$book_model->table  = 'buku';

						$data = array
									(
										"URL"    => $this->getEnv('BASE_URL'),
										"Data_Sekretaris"  => $secretary_model->getSecretaryData($session->value('secretary')),
										"Data"	 => $book_model->getEditData($book_id),
										"Kategori_Buku" => $all_category
									);

						$this->parts($data);
					}
					else
					{
						$this->error_404();
					}
				}
				else
				{
					$this->error_404();
				}
			}
			else if ($cookie->check('secretary') == true)
			{
				$secretary_model           = new app\http\models\Secretary;

				$secretary_model->connect();

				$secretary_model->table    = 'sekretaris';

				$encode         = new Flare\Components\Encode;

				$encode->key    = $this->getEnv('KEY');

				if ($secretary_model->CheckID($encode->unprotected($cookie->value('secretary'))))
				{
					$book_id	        = $_GET['book_id'];

					$book_model         = new app\http\models\Book;

					$book_model->connect();

					$book_model->table  = 'kategori_buku';

					$all_category       = $book_model->getCategory();

					$book_model->table  = 'buku';

					if ($book_model->CheckBookID($book_id))
					{
						$secretary_model->disconnect();

						$book_model         = new app\http\models\Book;

						$book_model->connect();

						$book_model->table  = 'buku';

						$data = array
									(
										"URL"    => $this->getEnv('BASE_URL'),
										"Data_Sekretaris"  => $secretary_model->getSecretaryData($encode->unprotected($cookie->value('secretary'))),
										"Data"	 => $book_model->getEditData($book_id),
										"Kategori_Buku" => $all_category
									);

						$this->parts($data);
					}
					else
					{
						$this->error_404();
					}
				}
				else
				{
					$this->error_404();
				}
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function editBookAjax()
	{
		if (Ajax::check())
		{
			$edit_book_data = Ajax::AngularInput();

			if (Validation::isEmpty($edit_book_data->booktitle))
			{
				Ajax::json_response(array('Tag' => '#6ae6abec7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Judul buku masih kosong'));
			}
			else if (Validation::isEmpty($edit_book_data->bookdescription))
			{
				Ajax::json_response(array('Tag' => '#f02ehc3e92', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Deskripsi buku masih kosong'));
			}
			else if (Validation::isEmpty($edit_book_data->authorname))
			{
				Ajax::json_response(array('Tag' => '#ec5d329573', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama pengarang masih kosong'));
			}
			else if (Validation::isEmpty($edit_book_data->bookpublisher))
			{
				Ajax::json_response(array('Tag' => '#3g719h17bh', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Penerbit buku masih kosong'));
			}
			else if (Validation::isEmpty($edit_book_data->datepublished))
			{
				Ajax::json_response(array('Tag' => '#6ada3hbg22', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tanggal terbit buku masih kosong'));
			}
			else if (Validation::isEmpty($edit_book_data->monthpublished))
			{
				Ajax::json_response(array('Tag' => '#48fdgfg0dg', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Bulan terbit buku masih kosong'));
			}
			else if (Validation::isEmpty($edit_book_data->yearpublished))
			{
				Ajax::json_response(array('Tag' => '#f78hc7g50e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tahun terbit buku masih kosong'));
			}
			else if (Validation::isEmpty($edit_book_data->placepublished))
			{
				Ajax::json_response(array('Tag' => '#7ge30bb482', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tempat terbit buku masih kosong'));
			}
			else if (Validation::isEmpty($edit_book_data->numberofbook))
			{
				Ajax::json_response(array('Tag' => '#ghf6fbefbe', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jumlah buku masih kosong'));
			}
			else
			{
				if (Validation::Minimum(5, Validation::SecureInput($edit_book_data->booktitle)) == false)
				{
					Ajax::json_response(array('Tag' => '#12b38b1e09', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Judul buku minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(80, Validation::SecureInput($edit_book_data->booktitle)) == false)
				{
					Ajax::json_response(array('Tag' => '#ac143beahg', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Judul buku maksimal 80 terdapat karakter'));
				}
				else if (Validation::Minimum(50, Validation::SecureInput($edit_book_data->bookdescription)) == false)
				{
					Ajax::json_response(array('Tag' => '#f967g370b1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Deskripsi buku minimal terdapat 50 karakter'));
				}
				else if (Validation::Maximum(1000, Validation::SecureInput($edit_book_data->bookdescription)) == false)
				{
					Ajax::json_response(array('Tag' => '#41h0818d39', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Deskripsi buku maksimal terdapat 1000 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z ]*$/", $edit_book_data->authorname) == false)
				{
					Ajax::json_response(array('Tag' => '#66a66e4bd2', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama pengarang hanya boleh berisi huruf dan spasi'));
				}
				else if (Validation::Minimum(3, $edit_book_data->authorname) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama pengarang minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(25, $edit_book_data->authorname) == false)
				{
					Ajax::json_response(array('Tag' => '#827h4bgd8c', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama pengarang maksimal terdapat 25 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z ]*$/", $edit_book_data->bookpublisher) == false)
				{
					Ajax::json_response(array('Tag' => '#0a6781f619', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Penerbit buku hanya boleh berisi huruf dan spasi'));
				}
				else if (Validation::Minimum(5, $edit_book_data->bookpublisher) == false)
				{
					Ajax::json_response(array('Tag' => '#41791ef7h0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Penerbit buku minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(50, $edit_book_data->bookpublisher) == false)
				{
					Ajax::json_response(array('Tag' => '#gc4f4e8072', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Penerbit buku maksimal terdapat 50 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z-0-9 ]*$/", $edit_book_data->placepublished) == false)
				{
					Ajax::json_response(array('Tag' => '#805d2d8bd0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tempat terbit buku hanya boleh berisi huruf, angka dan spasi'));
				}
				else if (Validation::Minimum(5, $edit_book_data->placepublished) == false)
				{
					Ajax::json_response(array('Tag' => '#hf61600h4a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tempat terbit buku minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(50, $edit_book_data->placepublished) == false)
				{
					Ajax::json_response(array('Tag' => '#87d65f1ha0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tempat terbit buku maksimal terdapat 50 karakter'));
				}
				else if (Validation::Regex("/^[0-9]*$/", $edit_book_data->numberofbook) == false)
				{
					Ajax::json_response(array('Tag' => '#eh829g2f9e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jumlah buku hanya boleh berisi angka'));
				}
				else if ($edit_book_data->numberofbook <= 0)
				{
					Ajax::json_response(array('Tag' => '#ddafagc5d1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jumlah buku minimal 1'));
				}
				else if ($edit_book_data->numberofbook > 5000)
				{
					Ajax::json_response(array('Tag' => '#63hd42g63b', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jumlah buku maksimal 5000'));
				}
				else
				{
					$session = new Flare\Network\Http\Session;

					$cookie  = new Flare\Network\Http\Cookie;

					$session->start();

					$book_model          = new app\http\models\Book;

					$book_model->connect();

					$book_model->table   = 'buku';

					$secretary_id   	 = $session->check('secretary') ? $session->value('secretary') : $encode->unprotected($cookie->value('secretary'));

					$secretary_model = new app\http\models\Secretary;

					$secretary_model->connect();

					$secretary_model->table = 'sekretaris';

					$secretary_name = $secretary_model->where($secretary_id)->get('Nama', 'ID_Sekretaris')->fetch();

					$date           = date("Y/m/d");

					if ($book_model->where($edit_book_data->id)->update("Judul_Buku='$edit_book_data->booktitle', Deskripsi_Buku='$edit_book_data->bookdescription', Nama_Pengarang='$edit_book_data->authorname', Penerbit_Buku='$edit_book_data->bookpublisher', Tanggal_Terbit='$edit_book_data->datepublished', Bulan_Terbit='$edit_book_data->monthpublished', Tahun_Terbit='$edit_book_data->yearpublished', Tempat_Terbit='$edit_book_data->placepublished', Kategori_Buku='$edit_book_data->bookcategory', Jumlah_Buku='$edit_book_data->numberofbook', Ditambahkan='$date', ID_Sekretaris='$secretary_id', Nama_Sekretaris='".$secretary_name['Nama']."'", "ID_Buku"))
					{
						$book_model->disconnect();

						Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Buku berhasil diedit', 'new_book_title' => $edit_book_data->booktitle, 'new_book_description' => $edit_book_data->bookdescription, 'new_author_name' => $edit_book_data->authorname, 'new_book_publisher' => $edit_book_data->bookpublisher, 'new_date_published' => $edit_book_data->datepublished, 'new_month_published' => $edit_book_data->monthpublished, 'new_year_published' => $edit_book_data->yearpublished, 'new_place_published' => $edit_book_data->placepublished, 'new_book_category' => $edit_book_data->bookcategory, 'new_number_of_book' => $edit_book_data->numberofbook));
					}
					else
					{
						Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
					}
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function deleteFolderNow($Directory)
	{
    	foreach(glob("{$Directory}/*") as $File)
    	{
        	if(is_dir($File)) 
        	{ 
            	$this->deleteFolderNow($File);
        	} 
        	else 
        	{
            	unlink($File);
        	}
    	}
    	
    	rmdir($Directory);
	}

	public function editBookWithUploadAjax()
	{

		if (Validation::isEmpty(Validation::SecureInput($_POST['booktitle'])))
		{
			Ajax::json_response(array('Tag' => '#6ae6abec7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Judul buku masih kosong'));
		}
		else if (Validation::isEmpty(Validation::SecureInput($_POST['bookdescription'])))
		{
			Ajax::json_response(array('Tag' => '#f02ehc3e92', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Deskripsi buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['authorname']))
		{
			Ajax::json_response(array('Tag' => '#ec5d329573', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama pengarang masih kosong'));
		}
		else if (Validation::isEmpty($_POST['bookpublisher']))
		{
			Ajax::json_response(array('Tag' => '#3g719h17bh', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Penerbit buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['datepublished']))
		{
			Ajax::json_response(array('Tag' => '#6ada3hbg22', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tanggal terbit buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['monthpublished']))
		{
			Ajax::json_response(array('Tag' => '#48fdgfg0dg', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Bulan terbit buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['yearpublished']))
		{
			Ajax::json_response(array('Tag' => '#f78hc7g50e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tahun terbit buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['placepublished']))
		{
			Ajax::json_response(array('Tag' => '#7ge30bb482', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tempat terbit buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['bookcategory']))
		{
			Ajax::json_response(array('Tag' => '#cdcf7h5e72', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kategori buku masih kosong'));
		}
		else if (Validation::isEmpty($_POST['numberofbook']))
		{
			Ajax::json_response(array('Tag' => '#ghf6fbefbe', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jumlah buku masih kosong'));
		}
		else if (Validation::isEmpty($_FILES) OR is_null($_FILES))
		{	
			Ajax::json_response(array('Tag' => '#2875959bag', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Gambar buku belum dipilih'));
		}
		else
		{
			if (Validation::Minimum(5, Validation::SecureInput($_POST['booktitle'])) == false)
			{
				Ajax::json_response(array('Tag' => '#12b38b1e09', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Judul buku minimal terdapat 5 karakter'));
			}
			else if (Validation::Maximum(80, Validation::SecureInput($_POST['booktitle'])) == false)
			{
				Ajax::json_response(array('Tag' => '#ac143beahg', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Judul buku maksimal 80 terdapat karakter'));
			}
			else if (Validation::Minimum(50, Validation::SecureInput($_POST['bookdescription'])) == false)
			{
				Ajax::json_response(array('Tag' => '#f967g370b1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Deskripsi buku minimal terdapat 50 karakter'));
			}
			else if (Validation::Maximum(1000, Validation::SecureInput($_POST['bookdescription'])) == false)
			{
				Ajax::json_response(array('Tag' => '#41h0818d39', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Deskripsi buku maksimal terdapat 1000 karakter'));
			}
			else if (Validation::Regex("/^[a-zA-Z ]*$/", $_POST['authorname']) == false)
			{
				Ajax::json_response(array('Tag' => '#66a66e4bd2', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama pengarang hanya boleh berisi huruf dan spasi'));
			}
			else if (Validation::Minimum(3, $_POST['authorname']) == false)
			{
				Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama pengarang minimal terdapat 3 karakter'));
			}
			else if (Validation::Maximum(25, $_POST['authorname']) == false)
			{
				Ajax::json_response(array('Tag' => '#827h4bgd8c', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama pengarang maksimal terdapat 25 karakter'));
			}
			else if (Validation::Regex("/^[a-zA-Z ]*$/", $_POST['bookpublisher']) == false)
			{
				Ajax::json_response(array('Tag' => '#0a6781f619', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Penerbit buku hanya boleh berisi huruf dan spasi'));
			}
			else if (Validation::Minimum(5, $_POST['bookpublisher']) == false)
			{
				Ajax::json_response(array('Tag' => '#41791ef7h0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Penerbit buku minimal terdapat 5 karakter'));
			}
			else if (Validation::Maximum(50, $_POST['bookpublisher']) == false)
			{
				Ajax::json_response(array('Tag' => '#gc4f4e8072', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Penerbit buku maksimal terdapat 50 karakter'));
			}
			else if (Validation::Regex("/^[a-zA-Z-0-9 ]*$/", $_POST['placepublished']) == false)
			{
				Ajax::json_response(array('Tag' => '#805d2d8bd0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tempat terbit buku hanya boleh berisi huruf, angka dan spasi'));
			}
			else if (Validation::Minimum(5, $_POST['placepublished']) == false)
			{
				Ajax::json_response(array('Tag' => '#hf61600h4a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tempat terbit buku minimal terdapat 5 karakter'));
			}
			else if (Validation::Maximum(50, $_POST['placepublished']) == false)
			{
				Ajax::json_response(array('Tag' => '#87d65f1ha0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tempat terbit buku maksimal terdapat 50 karakter'));
			}
			else if (Validation::Regex("/^[0-9]*$/", $_POST['numberofbook']) == false)
			{
				Ajax::json_response(array('Tag' => '#eh829g2f9e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jumlah buku hanya boleh berisi angka'));
			}
			else if ($_POST['numberofbook'] <= 0)
			{
				Ajax::json_response(array('Tag' => '#ddafagc5d1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jumlah buku minimal 1'));
			}
			else if ($_POST['numberofbook'] > 5000)
			{
				Ajax::json_response(array('Tag' => '#63hd42g63b', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jumlah buku maksimal 5000'));
			}
			else
			{

				$book_img          = $_FILES;

				$book_img_fname    = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,40);

				$book_img_ext      = explode('.', $book_img['file']['name']);

				$book_img_ext      = strtolower(end($book_img_ext));

				$book_img_size     = $book_img['file']['size'];

				$book_img_name     = $book_img_fname.".".$book_img_ext;

				$book_id           = substr(str_shuffle('0123456789012345678901234567890123456789'),0,40);

				$book_folder       = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,40);

				$bookid            = $_POST['id'];

				$booktitle         = Validation::SecureInput($_POST['booktitle']);
				
				$bookdescription   = Validation::SecureInput($_POST['bookdescription']);

				$authorname        = $_POST['authorname'];

				$bookpublisher     = $_POST['bookpublisher'];

				$datepublished     = $_POST['datepublished'];

				$monthpublished    = $_POST['monthpublished'];

				$yearpublished     = $_POST['yearpublished'];

				$placepublished    = $_POST['placepublished'];

				$bookcategory      = $_POST['bookcategory'];

				$numberofbook      = $_POST['numberofbook'];

				$secretary_model   = new app\http\models\Secretary;

				$secretary_model->connect();

				$secretary_model->table = 'sekretaris';

				$encode            = new Flare\Components\Encode;

				$encode->key       = $this->getEnv('KEY');

				$cookie            = new Flare\Network\Http\Cookie;

				$session           = new Flare\Network\Http\Session;

				$session->start();

				$secretary_id      =  $session->check('secretary') ? $session->value('secretary') : $encode->unprotected($cookie->value('secretary'));

				$secretary_name = $secretary_model->where($secretary_id)->get('Nama', 'ID_Sekretaris')->fetch();

				if ($book_img_ext == 'jpg' AND $book_img_ext != 'png' OR $book_img_ext != 'jpg' AND $book_img_ext == 'png')
				{
					if ($book_img_size < 5242880)
					{

						if (!file_exists("../resources/assets/".$book_folder."/".$book_img_fname.$book_img_ext))
						{
							mkdir("../resources/assets/".$book_folder, 0777, true);

							if (move_uploaded_file($book_img['file']['tmp_name'], "../resources/assets/".$book_folder."/".$book_img_name))
							{
								if (copy('../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/index.php', '../resources/assets/'.$book_folder.'/index.php'))
								{
									$book_model        = new app\http\models\Book;

									$book_model->connect();

									$book_model->table = 'buku';

									$date              = date("Y/m/d");

									$get_name_folder_now	   = $book_model->where($bookid)->get('Folder_Buku', 'ID_Buku')->fetch();

									$get_folder_now    = '../resources/assets/'.$get_name_folder_now['Folder_Buku'].'/';

									$this->deleteFolderNow($get_folder_now);

									if ($book_model->where($bookid)->update("Folder_Buku='$book_folder', Foto_Buku='$book_img_name', Judul_Buku='$booktitle', Deskripsi_Buku='$bookdescription', Nama_Pengarang='$authorname', Penerbit_Buku='$bookpublisher', Tanggal_Terbit='$datepublished', Bulan_Terbit='$monthpublished', Tahun_Terbit='$yearpublished', Tempat_Terbit='$placepublished', Kategori_Buku='$bookcategory', Jumlah_Buku='$numberofbook', Ditambahkan='$date', ID_Sekretaris='$secretary_id', Nama_Sekretaris='".$secretary_name['Nama']."'", "ID_Buku"))
									{
										Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Buku berhasil diedit', 'new_book_title' => $booktitle, 'new_book_description' => $bookdescription, 'new_author_name' => $authorname, 'new_book_publisher' => $bookpublisher, 'new_date_published' => $datepublished, 'new_month_published' => $monthpublished, 'new_year_published' => $yearpublished, 'new_place_published' => $placepublished, 'new_book_category' => $bookcategory, 'new_number_of_book' => $numberofbook));
									}
									else
									{
							 			Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
									}
									
								}
								else
								{
									Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
								}
							}
							else
							{
								Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
							}
						}
						else
						{
							Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
						}
					}
					else
					{
						Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Ukuran gambar buku maksimal 5 MB'));
					}
				}
				else
				{
					Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Gambar buku harus berupa PNG atau JPG'));
				}
			}
		}
	}

	public function searchCategoryAjax()
	{
		if (Ajax::check())
		{
			$search_category_data = Ajax::AngularInput();

			if (Validation::isEmpty(Validation::SecureInput($search_category_data->keyword)))
			{
				Ajax::json_response(array('Tag' => '#6ae6abec7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci masih kosong'));
			}
			else
			{	
				if (Validation::Minimum(3, Validation::SecureInput($search_category_data->keyword)) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(200, Validation::SecureInput($search_category_data->keyword)) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci maksimal terdapat 200 karakter'));
				}
				else
				{
					$keyword 		   = Validation::SecureInput($search_category_data->keyword);

					$book_model 	   = new app\http\models\Book;

					$book_model->connect();

					$book_model->table = 'kategori_buku';

					$data_table		   = $book_model->searchCategory($keyword);

					if (empty($data_table) == false OR is_null($data_table) == false)
					{
						Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Type' => 'success', 'result' => $data_table, 'keyword' => $search_category_data->keyword));
					}
					else
					{
						Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Type' => 'no_result'));
					}
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function searchBookAjax()
	{
		if (Ajax::check())
		{
			$search_book_data = Ajax::AngularInput();

			if (Validation::isEmpty(Validation::SecureInput($search_book_data->keyword)))
			{
				Ajax::json_response(array('Tag' => '#6ae6abec7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci masih kosong'));
			}
			else
			{	
				if (Validation::Minimum(3, Validation::SecureInput($search_book_data->keyword)) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(200, Validation::SecureInput($search_book_data->keyword)) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci maksimal terdapat 200 karakter'));
				}
				else
				{
					$keyword 		   = Validation::SecureInput($search_book_data->keyword);

					$book_model 	   = new app\http\models\Book;

					$book_model->connect();

					$book_model->table = 'buku';

					$data_table		   = $book_model->searchBook($keyword);

					if (empty($data_table) == false OR is_null($data_table) == false)
					{
						Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Type' => 'success', 'result' => $data_table, 'keyword' => $search_book_data->keyword));
					}
					else
					{
						Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Type' => 'no_result'));
					}
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewAccountSettings()
	{
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			if ($secretary_model->CheckID($session->value('secretary')))
			{
				$data = array
						(
							"URL"   => $this->getEnv('BASE_URL'),
							"Data"  => $secretary_model->getSecretaryData($session->value('secretary'))
						);

				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($secretary_model->CheckID($encode->unprotected($cookie->value('secretary'))))
			{
				$data = array
						(
							"URL"   => $this->getEnv('BASE_URL'),
							"Data"  => $secretary_model->getSecretaryData($encode->unprotected($cookie->value('secretary')))
						);

				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function updateAccountInformationsAjax()
	{
		if (Ajax::check())
		{
			$data_update_account = Ajax::AngularInput();

			$secretary_model = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table = 'sekretaris';

			$system_profil_picture	= array
									  (
									  	'6gb12a88h51e7016b21g7371h.png',
									  	'd5991cc5b8f8dc8a4g26c335g.png'
									  );

			$get_profile_picture 	= $secretary_model->where($data_update_account->id)->get('Foto_Sekretaris', 'ID_Sekretaris')->fetch(); 

			if (Validation::isEmpty($data_update_account->fullname))
			{
				Ajax::json_response(array('Tag' => '#6ae6abec7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama lengkap masih kosong'));
			}
			else if (Validation::isEmpty($data_update_account->dateofbirth))
			{
				Ajax::json_response(array('Tag' => '#ef2fha76a0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tanggal lahir masih kosong'));
			}
			else if (Validation::isEmpty($data_update_account->monthofbirth))
			{
				Ajax::json_response(array('Tag' => '#a37412dgac', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Bulan lahir masih kosong'));
			}
			else if (Validation::isEmpty($data_update_account->yearofbirth))
			{
				Ajax::json_response(array('Tag' => '#16h0bh8438', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tahun lahir masih kosong'));
			}
			else if (Validation::isEmpty($data_update_account->gender))
			{
				Ajax::json_response(array('Tag' => '#hbf4b7e164', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jenis kelamin masih kosong'));
			}
			else if (Validation::isEmpty($data_update_account->address))
			{
				Ajax::json_response(array('Tag' => '#0hd3g9ag93', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat masih kosong'));
			}
			else if (Validation::isEmpty($data_update_account->phonenumber))
			{
				Ajax::json_response(array('Tag' => '#737a9dcage', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel masih kosong'));
			}
			else if (Validation::isEmpty($data_update_account->email))
			{
				Ajax::json_response(array('Tag' => '#h768fd39ab', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel masih kosong'));
			}
			else
			{
				if (Validation::Regex("/^[a-zA-Z ]*$/", $data_update_account->fullname) == false)
				{
					Ajax::json_response(array('Tag' => '#9457644ahf', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama lengkap hanya boleh berisi huruf dan spasi'));
				}
				else if (Validation::Minimum(3, $data_update_account->fullname) == false)
				{
					Ajax::json_response(array('Tag' => '#7h6cc14fca', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama lengkap minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(25, $data_update_account->fullname) == false)
				{
					Ajax::json_response(array('Tag' => '#380b312d3d', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama lengkap maksimal terdapat 25 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z-0-9 ]*$/", $data_update_account->address) == false)
				{
					Ajax::json_response(array('Tag' => '#7g8a8g3491', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat hanya boleh berisi huruf, angka dan spasi'));
				}
				else if (Validation::Minimum(10, $data_update_account->address) == false)
				{
					Ajax::json_response(array('Tag' => '#f23830d6ae', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat minimal terdapat 10 karakter'));
				}
				else if (Validation::Maximum(50, $data_update_account->address) == false)
				{
					Ajax::json_response(array('Tag' => '#166g269bae', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat maksimal terdapat 50 karakter'));
				}
				else if (Validation::Regex("/08?[0-9]{10}$/", $data_update_account->phonenumber) == false)
				{
					Ajax::json_response(array('Tag' => '#d0c6720aca', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format nomor ponsel yang anda masukkan salah'));
				}
				else if (Validation::Minimum(12, $data_update_account->phonenumber) == false)
				{
					Ajax::json_response(array('Tag' => '#d197e1g4hb', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel harus terdiri dari 12 digit'));
				}
				else if (Validation::Maximum(12, $data_update_account->phonenumber) == false)
				{
					Ajax::json_response(array('Tag' => '#f073b40c38', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel harus terdiri dari 12 digit'));
				}
				else if (Validation::Regex("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/", $data_update_account->email) == false)
				{
					Ajax::json_response(array('Tag' => '#2ebc6gcg7b', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format email yang anda masukkan salah'));
				}
				else if (Validation::Minimum(15, $data_update_account->email) == false)
				{
					Ajax::json_response(array('Tag' => '#f220db1dg6', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email minimal terdapat 15 karakter'));
				}
				else if (Validation::Maximum(50, $data_update_account->email) == false)
				{
					Ajax::json_response(array('Tag' => '#07ed54be2c', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email maksimal terdapat 50 karakter'));
				}
				else
				{
					if ($data_update_account->gender == $data_update_account->gendernow)
					{
						if ($secretary_model->where($data_update_account->id)->update("Nama='$data_update_account->fullname', Tanggal_Lahir='$data_update_account->dateofbirth', Bulan_Lahir='$data_update_account->monthofbirth', Tahun_Lahir='$data_update_account->yearofbirth', Jenis_Kelamin='$data_update_account->gender', Alamat='$data_update_account->address', Ponsel='$data_update_account->phonenumber', Email='$data_update_account->email'", "ID_Sekretaris"))
						{

							$dataform = array
										(
										   'fullname' 		=> $data_update_account->fullname,
										   'dateofbirth'	=> $data_update_account->dateofbirth,
										   'monthofbirth'	=> $data_update_account->monthofbirth,
										   'yearofbirth'	=> $data_update_account->yearofbirth,
										   'gender'			=> $data_update_account->gender,
										   'address'		=> $data_update_account->address,
										   'phonenumber'	=> $data_update_account->phonenumber,
										   'email'			=> $data_update_account->email
										);

							Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Data berhasil diperbaharui', 'new_data' => $dataform));
						}
						else
						{
							Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan akun tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
						}
					}
					else if ($data_update_account->gender != $data_update_account->gendernow AND in_array($get_profile_picture['Foto_Sekretaris'], $system_profil_picture))
					{
						$secretary_model = new app\http\models\Secretary;

						$secretary_model->connect();

						$secretary_model->table = 'sekretaris';

						$get_name_folder_now	= $secretary_model->where($data_update_account->id)->get('Folder_Sekretaris', 'ID_Sekretaris')->fetch();

						$get_name_img_now		= $secretary_model->where($data_update_account->id)->get('Foto_Sekretaris', 'ID_Sekretaris')->fetch();

						$img_now   = '../resources/assets/'.$get_name_folder_now['Folder_Sekretaris'].'/'.$get_name_img_now['Foto_Sekretaris'];

						$img_fname = $data_update_account->gender == 'Pria' ? '6gb12a88h51e7016b21g7371h.png' : 'd5991cc5b8f8dc8a4g26c335g.png'; 

						$from      = $data_update_account->gender == 'Pria' ? '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/6gb12a88h51e7016b21g7371h.png' : '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/d5991cc5b8f8dc8a4g26c335g.png';

						if (unlink($img_now))
						{
							if (copy($from, '../resources/assets/'.$get_name_folder_now['Folder_Sekretaris'].'/'.$img_fname))
							{
								if ($secretary_model->where($data_update_account->id)->update("Foto_Sekretaris='$img_fname' , Nama='$data_update_account->fullname', Tanggal_Lahir='$data_update_account->dateofbirth', Bulan_Lahir='$data_update_account->monthofbirth', Tahun_Lahir='$data_update_account->yearofbirth', Jenis_Kelamin='$data_update_account->gender', Alamat='$data_update_account->address', Ponsel='$data_update_account->phonenumber', Email='$data_update_account->email'", "ID_Sekretaris"))
								{

									$dataform = array
										(
										   'fullname' 		=> $data_update_account->fullname,
										   'dateofbirth'	=> $data_update_account->dateofbirth,
										   'monthofbirth'	=> $data_update_account->monthofbirth,
										   'yearofbirth'	=> $data_update_account->yearofbirth,
										   'gender'			=> $data_update_account->gender,
										   'address'		=> $data_update_account->address,
										   'phonenumber'	=> $data_update_account->phonenumber,
										   'email'			=> $data_update_account->email
										);

									Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => '	Berhasil', 'Type' => 'success', 'Message' => 'Data berhasil diperbaharui', 'new_data' => $dataform));
								}
								else
								{
									Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan akun tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
								}
							}
							else
							{
								Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan akun tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
							}
						}
						else
						{
							Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan akun tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
						}
					}
					else if ($data_update_account->gender != $data_update_account->gendernow AND in_array($get_profile_picture['Foto_Sekretaris'], $system_profil_picture) == false)
					{
						if ($secretary_model->where($data_update_account->id)->update("Nama='$data_update_account->fullname', Tanggal_Lahir='$data_update_account->dateofbirth', Bulan_Lahir='$data_update_account->monthofbirth', Tahun_Lahir='$data_update_account->yearofbirth', Jenis_Kelamin='$data_update_account->gender', Alamat='$data_update_account->address', Ponsel='$data_update_account->phonenumber', Email='$data_update_account->email'", "ID_Sekretaris"))
						{

							$dataform = array
										(
										   'fullname' 		=> $data_update_account->fullname,
										   'dateofbirth'	=> $data_update_account->dateofbirth,
										   'monthofbirth'	=> $data_update_account->monthofbirth,
										   'yearofbirth'	=> $data_update_account->yearofbirth,
										   'gender'			=> $data_update_account->gender,
										   'address'		=> $data_update_account->address,
										   'phonenumber'	=> $data_update_account->phonenumber,
										   'email'			=> $data_update_account->email
										);

							Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Data berhasil diperbaharui', 'new_data' => $dataform));
						}
						else
						{
							Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan akun tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
						}
					}
					else
					{
						Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan akun tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
					}
				}
			}
		}
		else
		{
			$this->error_494();
		}
	}

	public function updateAccountInformationsWithUploadAjax()
	{
			if (Validation::isEmpty($_POST['fullname']))
			{
				Ajax::json_response(array('Tag' => '#6ae6abec7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama lengkap masih kosong'));
			}
			else if (Validation::isEmpty($_POST['dateofbirth']))
			{
				Ajax::json_response(array('Tag' => '#ef2fha76a0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tanggal lahir masih kosong'));
			}
			else if (Validation::isEmpty($_POST['monthofbirth']))
			{
				Ajax::json_response(array('Tag' => '#a37412dgac', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Bulan lahir masih kosong'));
			}
			else if (Validation::isEmpty($_POST['yearofbirth']))
			{
				Ajax::json_response(array('Tag' => '#16h0bh8438', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tahun lahir masih kosong'));
			}
			else if (Validation::isEmpty($_POST['gender']))
			{
				Ajax::json_response(array('Tag' => '#hbf4b7e164', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jenis kelamin masih kosong'));
			}
			else if (Validation::isEmpty($_POST['address']))
			{
				Ajax::json_response(array('Tag' => '#0hd3g9ag93', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat masih kosong'));
			}
			else if (Validation::isEmpty($_POST['phonenumber']))
			{
				Ajax::json_response(array('Tag' => '#737a9dcage', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel masih kosong'));
			}
			else if (Validation::isEmpty($_POST['email']))
			{
				Ajax::json_response(array('Tag' => '#h768fd39ab', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel masih kosong'));
			}
			else if (Validation::isEmpty($_FILES) OR is_null($_FILES))
			{	
				Ajax::json_response(array('Tag' => '#2875959bag', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Foto profil belum dipilih'));
			}
			else
			{
				if (Validation::Regex("/^[a-zA-Z ]*$/", $_POST['fullname']) == false)
				{
					Ajax::json_response(array('Tag' => '#9457644ahf', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama lengkap hanya boleh berisi huruf dan spasi'));
				}
				else if (Validation::Minimum(3, $_POST['fullname']) == false)
				{
					Ajax::json_response(array('Tag' => '#7h6cc14fca', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama lengkap minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(25, $_POST['fullname']) == false)
				{
					Ajax::json_response(array('Tag' => '#380b312d3d', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama lengkap maksimal terdapat 25 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z-0-9 ]*$/", $_POST['address']) == false)
				{
					Ajax::json_response(array('Tag' => '#7g8a8g3491', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat hanya boleh berisi huruf, angka dan spasi'));
				}
				else if (Validation::Minimum(10, $_POST['address']) == false)
				{
					Ajax::json_response(array('Tag' => '#f23830d6ae', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat minimal terdapat 10 karakter'));
				}
				else if (Validation::Maximum(50, $_POST['address']) == false)
				{
					Ajax::json_response(array('Tag' => '#166g269bae', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat maksimal terdapat 50 karakter'));
				}
				else if (Validation::Regex("/08?[0-9]{10}$/", $_POST['phonenumber']) == false)
				{
					Ajax::json_response(array('Tag' => '#d0c6720aca', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format nomor ponsel yang anda masukkan salah'));
				}
				else if (Validation::Minimum(12, $_POST['phonenumber']) == false)
				{
					Ajax::json_response(array('Tag' => '#d197e1g4hb', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel harus terdiri dari 12 digit'));
				}
				else if (Validation::Maximum(12, $_POST['phonenumber']) == false)
				{
					Ajax::json_response(array('Tag' => '#f073b40c38', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel harus terdiri dari 12 digit'));
				}
				else if (Validation::Regex("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/", $_POST['email']) == false)
				{
					Ajax::json_response(array('Tag' => '#2ebc6gcg7b', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format email yang anda masukkan salah'));
				}
				else if (Validation::Minimum(15, $_POST['email']) == false)
				{
					Ajax::json_response(array('Tag' => '#f220db1dg6', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email minimal terdapat 15 karakter'));
				}
				else if (Validation::Maximum(50, $_POST['email']) == false)
				{
					Ajax::json_response(array('Tag' => '#07ed54be2c', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email maksimal terdapat 50 karakter'));
				}
				else
				{
					$id  					= $_POST['id'];

					$fullname 				= $_POST['fullname'];
					
					$dateofbirth 			= $_POST['dateofbirth'];
					
					$monthofbirth			= $_POST['monthofbirth'];

					$yearofbirth			= $_POST['yearofbirth'];

					$gender   				= $_POST['gender'];

					$address		   		= $_POST['address'];

					$phonenumber	   		= $_POST['phonenumber'];

					$email             		= $_POST['email'];

					$profil_picture    		= $_FILES;

					$profil_picture_fname   = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,40);

					$profil_picture_ext     = explode('.', $profil_picture['file']['name']);

					$profil_picture_ext     = strtolower(end($profil_picture_ext));

					$profil_picture_size    = $profil_picture['file']['size'];

					$profil_picture_name    = $profil_picture_fname.".".$profil_picture_ext;

					$new_folder      		= substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,40);

					if ($profil_picture_ext == 'jpg' AND $profil_picture_ext != 'png' OR $profil_picture_ext != 'jpg' AND $profil_picture_ext == 'png')
					{
						if ($profil_picture_size < 5242880)
						{
							
							if (!file_exists("../resources/assets/".$new_folder."/".$profil_picture_fname.$profil_picture_ext))
							{
								mkdir("../resources/assets/".$new_folder, 0777, true);

								if (move_uploaded_file($profil_picture['file']['tmp_name'], "../resources/assets/".$new_folder."/".$profil_picture_name))
								{
									if (copy('../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/index.php', '../resources/assets/'.$new_folder.'/index.php'))
									{
										$secretary_model = new app\http\models\Secretary;

										$secretary_model->connect();

										$secretary_model->table = 'sekretaris';

										$get_name_folder_now	= $secretary_model->where($id)->get('Folder_Sekretaris', 'ID_Sekretaris')->fetch();

										$get_folder_now 		= '../resources/assets/'.$get_name_folder_now['Folder_Sekretaris'].'/';

										$this->deleteFolderNow($get_folder_now);

										if ($secretary_model->where($id)->update("Folder_Sekretaris='$new_folder', Foto_Sekretaris='$profil_picture_name', Nama='$fullname', Tanggal_Lahir='$dateofbirth', Bulan_Lahir='$monthofbirth', Tahun_Lahir='$yearofbirth', Jenis_Kelamin='$gender', Alamat='$address', Ponsel='$phonenumber', Email='$email'", "ID_Sekretaris"))
										{
											$dataform = array
														(
										   	   				'fullname' 		=> $fullname,
										   	   				'dateofbirth'	=> $dateofbirth,
										   	   				'monthofbirth'	=> $monthofbirth,
										       				'yearofbirth'	=> $yearofbirth,
										       				'gender'			=> $gender,
										       				'address'		=> $address,
										       				'phonenumber'	=> $phonenumber,
										       				'email'			=> $email
														);

											Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => '	Berhasil', 'Type' => 'success', 'Message' => 'Data berhasil diperbaharui', 'new_data' => $dataform));
										}
									}
									else
									{
										Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan akun tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
									}
								}
								else
								{
									Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan akun tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
								}
							}
							else
							{
								Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan akun tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
							}

						}
						else
						{
							Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Ukuran foto maksimal 5 MB'));
						}
					}
					else
					{
						Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Foto harus berupa JPG atau PNG'));
					}

				}
			}	
	}



	public function changePasswordAjax()
	{
		if (Ajax::Check())
		{
			$change_password_data  = Ajax::AngularInput();

			$secretary_model	   = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table = 'sekretaris';

			if (Validation::isEmpty($change_password_data->password))
			{
				Ajax::json_response(array('Tag' => '#c5f3ghh56g', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi lama masih kosong'));
			}
			else if (Validation::isEmpty($change_password_data->newpassword))
			{
				Ajax::json_response(array('Tag' => '#3ge3bg212h', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi baru masih kosong'));
			}
			else
			{
				if (Validation::Regex("/^[a-zA-Z-0-9]*$/", $change_password_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#d991d452df', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi lama hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $change_password_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#dgh9dcbeh9', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi lama minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(25, $change_password_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#c86b5df820', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi lama maksimal terdapat 25 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z-0-9]*$/", $change_password_data->newpassword) == false)
				{
					Ajax::json_response(array('Tag' => '#cebe03b7a6', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi baru hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $change_password_data->newpassword) == false)
				{
					Ajax::json_response(array('Tag' => '#730d7e909h', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi baru minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(25, $change_password_data->newpassword) == false)
				{
					Ajax::json_response(array('Tag' => '#69501d708c', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi baru maksimal terdapat 25 karakter'));
				}
				else if ($secretary_model->CheckPassword($secretary_model->get(null, 'Katasandi')->fetch(), $change_password_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#1e87ab2a0a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi lama yang anda masukkan salah'));
				}
				else
				{

					$hash_new_password = password_hash($change_password_data->newpassword, PASSWORD_DEFAULT);

					if ($secretary_model->where($change_password_data->id)->update("Katasandi='$hash_new_password'", "ID_Sekretaris"))
					{
						Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Katasandi berhasil diperbaharui'));	
					}
					else
					{
						Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengubahan katasandi tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
					}
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function forgotPasswordAjax()
	{
		if (Ajax::Check())
		{
			$forgot_password_data  = Ajax::AngularInput();

			$secretary_model	   = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table = 'sekretaris';

			if (Validation::isEmpty($forgot_password_data->email))
			{
				Ajax::json_response(array('Tag' => '#69e0bhf1c4', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email masih kosong'));
			}
			else
			{
				if (Validation::Regex("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/", $forgot_password_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#2470g04118', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format email yang anda masukkan salah'));
				}
				else if (Validation::Minimum(15, $forgot_password_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#5dh2gb9f7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email minimal terdapat 15 karakter'));
				}
				else if (Validation::Maximum(50, $forgot_password_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#3g946e7b5d', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email maksimal terdapat 50 karakter'));
				}
				else if ($secretary_model->CheckEmail($forgot_password_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#1e5h24ce21', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email yang anda masukkan salah'));

				}
				else
				{

					$secretary_id     = $secretary_model->where($forgot_password_data->email)->get('ID_Sekretaris', 'Email')->fetch();

					if ($secretary_model->CheckAccess($secretary_id['ID_Sekretaris']) == false)
					{

						$name 			  = $secretary_model->where($forgot_password_data->email)->get('Nama', 'Email')->fetch();
					
						$reset_code       = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,50);

					
						$msg              = "<html><head><style>a {text-decoration: none;color: blue;}</style></head><body>Yth, <strong>".$name['Nama']."</strong>. <br/><br/> Anda baru saja meminta permohonan untuk mengatur ulang katasandi anda. Silahkan klik tautan yang ada dibawah ini untuk mengatur ulang katasandi anda. <br/><br/> <a href='".$this->getEnv('BASE_URL')."reset_password_secretary.php?secretary_id=".$secretary_id['ID_Sekretaris']."&reset_code=".$reset_code."'>".$this->getEnv('BASE_URL')."reset_password_secretary.php?secretary_id=".$secretary_id['ID_Sekretaris']."&reset_code=".$reset_code."</a> <br/><br/> Jika anda merasa tidak pernah merasa untuk meminta mengatur ulang katasandi silahkan abaikan email ini, terima kasih.</body></html>";

						$mailer = new Flare\Components\Mail;

						$mailer->timezone     	=  'Asia/Makassar';

						$mailer->senderName   	=  'Perpusnusantara';

						$mailer->thesubject   	=  'Lupa Katasandi';

						$mailer->receiptEmail 	=  $forgot_password_data->email;

						$mailer->receiptName  	=  $name;

						$mailer->senderEmail    =  $this->getEnv('EMAIL_ADDRESS');

						$mailer->senderPassword =  $this->getEnv('EMAIL_PASSWORD');

						$mailer->host_mail  	=  'smtp.gmail.com';

						$mailer->message     	=  $msg;

						if ($mailer->send())
						{
							if ($secretary_model->where($secretary_id['ID_Sekretaris'])->update("Kode_Atur_Ulang_Katasandi='$reset_code', Akses_Atur_Ulang_Katasandi='Aktif'", "ID_Sekretaris"))
							{
								Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => '	Berhasil', 'Type' => 'success', 'Message' => 'Silahkan periksa email anda karena kami sudah mengirimkan tautan agar anda bisa mengatur ulang katasandi anda.'));
							}
							else
							{
								Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan proses permintaan ulang katasandi anda tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
							}
						}
						else
						{
							Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan proses permintaan ulang katasandi anda tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
						}
					}
					else
					{
						Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tidak bisa melakukan permohonan katasandi hal ini dikarenakan akun ini belum melakukan konfigurasi. Silahkan periksa email anda karena kami sudah mengirimkan tautan untuk menkonfigurasi akun anda.'));
					}
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewForgotPasswordPage()
	{
		$data = array
				(
					"URL" => $this->getEnv('BASE_URL')
				); 

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;		

		$session->start();

		if ($session->check('secretary') == true)
		{
		    $secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			if ($secretary_model->CheckID($session->value('secretary')))
			{
				$secretary_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/secretary/dashboard/');
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($secretary_model->CheckID($encode->unprotected($cookie->value('secretary'))))
			{
				$secretary_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/secretary/dashboard/');
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{		
		   $this->parts($data);
		}
	}

	public function viewResetPasswordPage()
	{

		if (isset($_GET['secretary_id']) OR empty($_GET['secretary_id']) == false)
		{
			if (isset($_GET['reset_code']) OR empty($_GET['reset_code']) == false)
			{
				$secretary_id_get  = $_GET['secretary_id'];

				$reset_code_get	   = $_GET['reset_code'];

				$secretary_model   = new app\http\models\Secretary;

				$secretary_model->connect();

				$secretary_model->table = 'sekretaris';

				if ($secretary_model->CheckAccess2($secretary_id_get, $reset_code_get))
				{
					$data = array
							(
								'URL' => $this->getEnv('BASE_URL'),
								'ID_Sekretaris'	=> $secretary_id_get
							);

					$this->parts($data);
				}
				else
				{
					$this->error_404();
				}
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function resetPasswordAjax()
	{
		if (Ajax::check())
		{
			$reset_password_data        = Ajax::AngularInput();

			$secretary_model            = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table     = 'sekretaris';

			if (Validation::isEmpty($reset_password_data->password))
			{
				Ajax::json_response(array('Tag' => '#638a92829d', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi masih kosong'));
			}
			else
			{
				if (Validation::Regex("/^[a-zA-Z-0-9]*$/", $reset_password_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#bg53799h97', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $reset_password_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#5b1ahg6ec0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(25, $reset_password_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#f98662e1c2', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi maksimal terdapat 25 karakter'));
				}
				else if ($secretary_model->CheckAccess($secretary_model->getId($secretary_login_data->email)))
				{
					Ajax::json_response(array('Tag' => '#c4956ef651', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tidak bisa mengatur ulang katasandi dikarenakan akun ini belum melakukan konfigurasi. Silahkan periksa email anda karena kami sudah mengirimkan tautan agar anda bisa melakukan konfigurasi terhadap akun anda.'));
				}
				else
				{
					$newpassword = password_hash($reset_password_data->password, PASSWORD_DEFAULT);

					if ($secretary_model->where($reset_password_data->id)->update("Katasandi='$newpassword', Kode_Atur_Ulang_Katasandi='Tidak Ada', Akses_Atur_Ulang_Katasandi='Tidak Aktif'", "ID_Sekretaris"))
					{
						$session         = new Flare\Network\Http\Session;

						$session->name   = "secretary";

						$session->start();

						$session->give()->use($reset_password_data->id);

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Pengaturan katasandi berhasil'));

						$secretary_model->disconnect();
					}
					else
					{
						Ajax::json_response(array('Tag' => '#7ea1bh18a3', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengaturan katasandi tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
					}
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewBookStatistic()
	{
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			if ($secretary_model->CheckID($session->value('secretary')))
			{
				$book_model          = new app\http\models\Book;

				$book_model->connect();

				$book_model->table   = 'statistik_buku';

				$limit_display       = 10;

			    $set_page            = isset($_GET['page'])? (int)$_GET["page"]:1;
        
        		$check_page          = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

				$total_rows          = $book_model->getBookStatisticRows();

				$ceilIt              = ceil($total_rows/$limit_display);

				$list_book_statistic = $book_model->getBookStatistic($check_page, $limit_display);

				$data = array
						(
							"URL"                   => $this->getEnv('BASE_URL'),
							"Data_Sekretaris"  => $secretary_model->getSecretaryData($session->value('secretary')),
							"List_Statistik_Buku"   => $list_book_statistic,
							"Halaman_Paging"        => $set_page,
							"Total_Halaman"         => $ceilIt
						);

				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('secretary') == true)
		{
			$secretary_model           = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table    = 'sekretaris';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($secretary_model->CheckID($encode->unprotected($cookie->value('secretary'))))
			{
				$book_model          = new app\http\models\Book;

				$book_model->connect();

				$book_model->table   = 'statistik_buku';

				$limit_display       = 10;

			    $set_page            = isset($_GET['page'])? (int)$_GET["page"]:1;
        
        		$check_page          = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

				$total_rows          = $book_model->getBookStatisticRows();

				$ceilIt              = ceil($total_rows/$limit_display);

				$list_book_statistic = $book_model->getBookStatistic($check_page, $limit_display);

				$book_model->disconnect();

				$data = array
						(
							"URL"                   => $this->getEnv('BASE_URL'),
							"Data_Sekretaris"  => $secretary_model->getSecretaryData($encode->unprotected($cookie->value('secretary'))),
							"List_Statistik_Buku"   => $list_book_statistic,
							"Halaman_Paging"        => $set_page,
							"Total_Halaman"         => $ceilIt
						);

				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function searchBookStatisticAjax()
	{
		if (Ajax::check())
		{
			$search_book_statistic_data = Ajax::AngularInput();

			if (Validation::isEmpty(Validation::SecureInput($search_book_statistic_data->keyword)))
			{
				Ajax::json_response(array('Tag' => '#6ae6abec7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci masih kosong'));
			}
			else
			{	
				if (Validation::Minimum(3, Validation::SecureInput($search_book_statistic_data->keyword)) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(200, Validation::SecureInput($search_book_statistic_data->keyword)) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci maksimal terdapat 200 karakter'));
				}
				else
				{
					$keyword 		   = Validation::SecureInput($search_book_statistic_data->keyword);

					$book_model 	   = new app\http\models\Book;

					$book_model->connect();

					$book_model->table = 'statistik_buku';

					$data_table		   = $book_model->searchBookStatistic($keyword);

					if (empty($data_table) == false OR is_null($data_table) == false)
					{
						Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Type' => 'success', 'result' => $data_table, 'keyword' => $search_book_statistic_data->keyword));
					}
					else
					{
						Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Type' => 'no_result'));
					}
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function notifToBorrowerAjax()
	{
		if (Ajax::Check())
		{
			$notif_to_borrower_data   = Ajax::AngularInput();

			$book_model           = new app\http\models\Book;

			$book_model->connect();

			$book_model->table  = 'statistik_buku';

			if ($book_model->CheckBookStatisticID($notif_to_borrower_data->borrow_id))
			{
				$sample 		= $book_model->where($notif_to_borrower_data->borrow_id)->get('Judul_Buku, Tanggal_Dipinjam, Tanggal_Dikembalikan, Keterangan, Status, ID_Pengguna', 'ID_Peminjaman')->fetch();

				$book_model->disconnect();

				$users_model  		= new app\http\models\Users;

				$users_model->connect();

				$users_model->table = 'pengguna';

				$sample2			= $users_model->where($sample['ID_Pengguna'])->get('Nama, Email', 'ID_Pengguna')->fetch();

				$date_db            = date("Y-m-d", strtotime($sample['Tanggal_Dikembalikan']));

				$formatted_date_db  = (new DateTime($date_db))->modify('-1 days');

				$borrowed_date      = date("d-m-Y", strtotime($sample['Tanggal_Dipinjam']));

				$returned_date      = date("d-m-Y", strtotime($sample['Tanggal_Dikembalikan']));

				if ($sample['Keterangan'] == "Proses Peminjaman" AND $sample['Status'] == "Terverifikasi")
				{

					if ($formatted_date_db->format("Y-m-d") == date("Y-m-d") AND $date_db != date("Y-m-d"))
					{

						$msg                = "<html><head><style>a {text-decoration: none;color: blue;}</style></head><body>Yth, <strong>".$sample2['Nama']."</strong>. <br/><br/> Peminjaman buku yang berjudul <strong>".$sample['Judul_Buku']."</strong> pengembalian buku tersebut dapat dilakukan besok. Anda melakukan peminjaman pada tanggal <strong>".$borrowed_date."</strong> dan buku tersebut harus dikembalikan pada <strong>".$returned_date."</strong> . Silahkan pergi ke perpustakaan kami dan melakukan pengembalian buku tersebut di sekertaris perpustakaan.<br/><br/> Segala ketentuan mengenai peminjaman buku sudah diatur pada <a href='".$this->getEnv('BASE_URL')."' style='text-decoration: none;'>ketentuan peminjaman buku</a>, silahkan melakukan pengembalian buku tersebut besok.</body></html>";

						$mailer = new Flare\Components\Mail;

						$mailer->timezone     	=  'Asia/Makassar';

						$mailer->senderName   	=  'Perpusnusantara';

						$mailer->thesubject   	=  'Sisa 1 Hari Sebelum Pengembalian Peminjaman Buku';

						$mailer->receiptEmail 	=  $sample2['Email'];

						$mailer->receiptName  	=  $sample2['Nama'];

						$mailer->senderEmail    =  $this->getEnv('EMAIL_ADDRESS');

						$mailer->senderPassword =  $this->getEnv('EMAIL_PASSWORD');

						$mailer->host_mail  	=  'smtp.gmail.com';

						$mailer->message     	=  $msg;

						if ($mailer->send())
						{
							Ajax::json_response(array('Tag' => '#1606669dcg', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Pengiriman notifikasi ke pengguna sudah berhasil dilakukan.'));
						}
						else
						{
							Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengiriman notifikasi ke pengguna tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
						}
					}
					else if ($formatted_date_db->format("Y-m-d") != date("Y-m-d") AND $date_db == date("Y-m-d"))
					{
						$msg                = "<html><head><style>a {text-decoration: none;color: blue;}</style></head><body>Yth, <strong>".$sample2['Nama']."</strong>. <br/><br/> Peminjaman buku yang berjudul <strong>".$sample['Judul_Buku']."</strong> telah mencapai tanggal pengembalian yang ditentukan. Anda melakukan peminjaman pada tanggal <strong>".$borrowed_date."</strong> dan buku tersebut harus dikembalikan pada <strong>".$returned_date."</strong> . Silahkan pergi ke perpustakaan kami dan melakukan pengembalian buku tersebut di sekertaris perpustakaan.<br/><br/> Segala ketentuan mengenai peminjaman buku sudah diatur pada <a href='".$this->getEnv('BASE_URL')."' style='text-decoration: none;'>ketentuan peminjaman buku</a>, silahkan melakukan pengembalian buku tersebut sekarang.</body></html>";

						$mailer = new Flare\Components\Mail;

						$mailer->timezone     	=  'Asia/Makassar';

						$mailer->senderName   	=  'Perpusnusantara';

						$mailer->thesubject   	=  'Pengembalian Peminjaman Buku';

						$mailer->receiptEmail 	=  $sample2['Email'];

						$mailer->receiptName  	=  $sample2['Nama'];

						$mailer->senderEmail    =  $this->getEnv('EMAIL_ADDRESS');

						$mailer->senderPassword =  $this->getEnv('EMAIL_PASSWORD');

						$mailer->host_mail  	=  'smtp.gmail.com';

						$mailer->message     	=  $msg;

						if ($mailer->send())
						{
							Ajax::json_response(array('Tag' => '#1606669dcg', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Pengiriman notifikasi ke pengguna sudah berhasil dilakukan.'));
						}
						else
						{
							Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengiriman notifikasi ke pengguna tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
						}
					}
					else
					{		
						Ajax::json_response(array('Tag' => '#65d9egc05f', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Pengiriman notifikasi ke pengguna hanya bisa dilakukan pada hari sebelum jadwal pengembalian buku (1 hari sebelumnya) atau pada hari pengembalian buku tersebut. Tidak bisa melakukan pengiriman notifikasi jika sudah melewati hari pengembalian buku.'));
					}
				}
				else if ($sample['Keterangan'] == "Proses Peminjaman" AND $sample['Status'] == "Belum Terverifikasi")
				{
					Ajax::json_response(array('Tag' => '#d8d2cd405c', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tidak dapat mengirim notifikasi ke pengguna ini. dikarenakan pengguna ini belum melakukan proses peminjaman buku dimana status peminjamannya belum terverifikasi.'));
				}
				else
				{
					Ajax::json_response(array('Tag' => '#7h9c436h67', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengiriman notifikasi ke pengguna tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
				}

				$book_model->disconnect();
			}	
			else
			{
				echo $notif_to_borrower_data->borrow_id."adasd";
				Ajax::json_response(array('Tag' => '#e0h8fc97e4', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengiriman notifikasi ke pengguna tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
			}
		}
	}
	
	public function deleteBookStatisticAjax()
	{
		if (Ajax::check())
		{
			$delete_book_statistic_data = Ajax::AngularInput();

			if (Validation::isEmpty($delete_book_statistic_data->borrow_id))
			{
				Ajax::json_response(array('Tag' => '#e0h8fc97e4', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan data peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
			}
			else
			{
				$book_model         = new app\http\models\Book;

				$book_model->connect();

				$book_model->table  = 'statistik_buku';

				if ($book_model->CheckBookStatisticID($delete_book_statistic_data->borrow_id))
				{

					$sample         = $book_model->where($delete_book_statistic_data->borrow_id)->get('ID_Buku, Keterangan, Status', 'ID_Peminjaman')->fetch();

					if ($sample['Keterangan'] == "Peminjaman" AND $sample['Status'] == "Terverifikasi")
					{

						$book_model->table = 'buku';

						$sample2    	   = $book_model->where($sample['ID_Buku'])->get('Jumlah_Buku', 'ID_Buku')->fetch();

						$total_new_book	   = $sample2['Jumlah_Buku'] + 1;

						if ($book_model->where($sample['ID_Buku'])->update("Jumlah_Buku='$total_new_book'", "ID_Buku"))
						{

							if ($book_model->where($delete_book_statistic_data->borrow_id)->delete('ID_Peminjaman'))
							{
								Ajax::json_response(array('Tag' => '#7eb569bf3f', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Penghapusan data peminjaman buku berhasil dilakukan.'));	
							}
							else
							{
								Ajax::json_response(array('Tag' => '#823gh82b7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan data peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
							}
						}
						else
						{
							Ajax::json_response(array('Tag' => '#1e6a55ggdh', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan data peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
						}
					}
					else
					{
						if ($book_model->where($delete_book_statistic_data->borrow_id)->delete('ID_Peminjaman'))
						{
							Ajax::json_response(array('Tag' => '#7eb569bf3f', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Penghapusan data peminjaman buku berhasil dilakukan.'));	
						}
						else
						{
							Ajax::json_response(array('Tag' => '#823gh82b7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan data peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
						}
					}
				}
				else
				{
					Ajax::json_response(array('Tag' => '#2ccc942fc7', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan data peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
				}

				$book_model->disconnect();	
			}
		}
		else
		{
			$this->error_404();
		}
	}
	
	public function viewChangeStatusBookBorrower()
	{
		if (isset($_GET['borrow_id']))
		{
			$session = new Flare\Network\Http\Session;

			$cookie  = new Flare\Network\Http\Cookie;

			$session->start();

			if ($session->check('secretary') == true)
			{
				$secretary_model           = new app\http\models\Secretary;

				$secretary_model->connect();

				$secretary_model->table    = 'sekretaris';

				if ($secretary_model->CheckID($session->value('secretary')))
				{
					$borrow_id        = $_GET['borrow_id'];

					$book_model         = new app\http\models\Book;

					$book_model->connect();

					$book_model->table  = 'statistik_buku';

					if ($book_model->CheckBookStatisticID($borrow_id))
					{
						$secretary_model->disconnect();

						$borrow_id        = $_GET['borrow_id'];

						$book_model         = new app\http\models\Book;

						$book_model->connect();

						$book_model->table  = 'statistik_buku';

						$data = array
									(
										"URL"           => $this->getEnv('BASE_URL'),
										"Data_Sekretaris"  => $secretary_model->getSecretaryData($session->value('secretary')),
										"Data_Edit"     => $book_model->getEditDataBorrowerBook($borrow_id)
									);

						$this->parts($data);
					}
					else
					{
						$this->error_404();
					}
				}
				else
				{
					$this->error_404();
				}
			}
			else if ($cookie->check('secretary') == true)
			{
				$secretary_model           = new app\http\models\Secretary;

				$secretary_model->connect();

				$secretary_model->table    = 'sekretaris';

				$encode         = new Flare\Components\Encode;

				$encode->key    = $this->getEnv('KEY');

				if ($secretary_model->CheckID($encode->unprotected($cookie->value('secretary'))))
				{
					$secretary_model->disconnect();

					$borrow_id        = $_GET['borrow_id'];

					$book_model         = new app\http\models\Book;

					$book_model->connect();

					$book_model->table  = 'statistik_buku';

					if ($book_model->CheckBookStatisticID($borrow_id))
					{
						$data = array
									(
										"URL"           => $this->getEnv('BASE_URL'),
										"Data_Sekretaris"  => $secretary_model->getSecretaryData($encode->unprotected($cookie->value('secretary'))),
										"Data_Edit"     => $book_model->getEditDataBorrowerBook($borrow_id)
									);

						$this->parts($data);
					}
					else
					{
						$this->error_404();
					}
				}
				else
				{
					$this->error_404();
				}
			}
			else
			{
				$this->error_404();
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function ChangeStatusBookBorrowerAjax()
	{
		if (Ajax::Check())
		{
			$change_status_book_borrower_data = Ajax::AngularInput();

			if (Validation::isEmpty($change_status_book_borrower_data))
			{
				Ajax::json_response(array('Tag' => '#2ccc942fc7', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengubahan status peminjaman tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
			}
			else
			{
				$book_model 		= new app\http\models\Book;

				$book_model->table  = 'statistik_buku';

				$book_model->connect();

				if ($book_model->CheckBookStatisticID($change_status_book_borrower_data->borrow_id))
				{
					if ($change_status_book_borrower_data->oldStatus != $change_status_book_borrower_data->newStatus->label)
					{
						if ($change_status_book_borrower_data->newStatus->label == "Dipinjam")
						{
							if ($book_model->where($change_status_book_borrower_data->borrow_id)->update("Keterangan='".$change_status_book_borrower_data->newStatus->label."'", "ID_Peminjaman"))
							{
								$borrowed_date   		= strtotime($change_status_book_borrower_data->borrowed_date);

								$returned_date			= strtotime($change_status_book_borrower_data->returned_date);

								$dayBorrowed            = $returned_date - $borrowed_date;

								$dayBorrowed			= round($dayBorrowed / (60 * 60 * 24));

								$msg              	    = "<html><head><style>a {text-decoration: none;color: blue;}</style></head><body>Yth, <strong>".$change_status_book_borrower_data->borrower_name."</strong>. <br/><br/> Peminjaman buku berhasil dilakukan, buku yang berjudul <strong>".$change_status_book_borrower_data->booktitle."</strong> dipinjam pada <strong>".date('d-m-Y H:i', strtotime($change_status_book_borrower_data->borrowed_date))."</strong> dengan masa peminjaman <strong>".$dayBorrowed." hari</strong> maka buku tersebut harus dikembalikan pada <strong>".date('d-m-Y H:i', strtotime($change_status_book_borrower_data->returned_date))."</strong>.<br/><br/> Diharapkan untuk melakukan pengembalian buku secepatnya pihak sekretaris juga akan memberitahu kembali mengenai pengembalian buku tersebut melalui email atau menghubungi melalui telepon. Segala ketentuan mengenai peminjaman buku sudah diatur pada <a href='".$this->getEnv('BASE_URL')."' style='text-decoration: none;'>ketentuan peminjaman buku</a>, sekian dan terimakasih</body></html>";

								$mailer 				= new Flare\Components\Mail;

								$mailer->timezone     	=  'Asia/Makassar';

								$mailer->senderName   	=  'Perpusnusantara';

								$mailer->thesubject   	=  'Buku yang berjudul '.$change_status_book_borrower_data->booktitle.' telah dipinjam';

								$mailer->receiptEmail 	=  $change_status_book_borrower_data->borrower_email;

								$mailer->receiptName  	=  $change_status_book_borrower_data->borrower_name;

								$mailer->senderEmail    =  $this->getEnv('EMAIL_ADDRESS');

								$mailer->senderPassword =  $this->getEnv('EMAIL_PASSWORD');

								$mailer->host_mail  	=  'smtp.gmail.com';

								$mailer->message     	=  $msg;

								if ($mailer->send())
								{
									$book_model->table  = 'buku';

									$numberofbook       = $book_model->where($change_status_book_borrower_data->bookid)->get('Jumlah_Buku' , 'ID_Buku')->fetch();

									$Newnumberofbook    = $numberofbook['Jumlah_Buku'] - 1; 

									if ($book_model->where($change_status_book_borrower_data->bookid)->update("Jumlah_Buku='$Newnumberofbook'", "ID_Buku"))
									{
										Ajax::json_response(array('Tag' => '#7eb569bf3f', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Pengubahan status peminjaman telah berhasil dilakukan.'));
									}
									else
									{
										Ajax::json_response(array('Tag' => '#be2348c9f8', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengubahan status peminjaman tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
									}
								}
								else
								{
									Ajax::json_response(array('Tag' => '#4207h3fbf1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengubahan status peminjaman tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
								}
							}
							else
							{
								Ajax::json_response(array('Tag' => '#g51g081300', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengubahan status peminjaman tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
							}
						}
						else if ($change_status_book_borrower_data->newStatus->label == "Dikembalikan")
						{
							if ($book_model->where($change_status_book_borrower_data->borrow_id)->update("Keterangan='".$change_status_book_borrower_data->newStatus->label."'", "ID_Peminjaman"))
							{

								$msg              	    = "<html><head><style>a {text-decoration: none;color: blue;}</style></head><body>Yth, <strong>".$change_status_book_borrower_data->borrower_name."</strong>. <br/><br/> Buku yang berjudul <strong>".$change_status_book_borrower_data->booktitle."</strong> telah anda kembalikan. Silahkan jika anda berminat untuk memberi review mengenai buku yang anda pinjam ini melalui link berikut : <a href='".$this->getEnv('BASE_URL')."review_book/index.php?bookid=".$change_status_book_borrower_data->bookid."'>".$this->getEnv('BASE_URL')."review_book/index.php?bookid=".$change_status_book_borrower_data->bookid."</a><br/><br/> Jika link diatas ketika di akses munculnya halaman 404 berarti anda belum log-in ke akun anda seilahkan log-in terlebih dahulu dan mengunjungi ulang tautan yang ada di link tersebut, sekian dan terimakasih</body></html>";

								$mailer 				= new Flare\Components\Mail;

								$mailer->timezone     	=  'Asia/Makassar';

								$mailer->senderName   	=  'Perpusnusantara';

								$mailer->thesubject   	=  'Buku yang berjudul '.$change_status_book_borrower_data->booktitle.' telah dikembalikan';

								$mailer->receiptEmail 	=  $change_status_book_borrower_data->borrower_email;

								$mailer->receiptName  	=  $change_status_book_borrower_data->borrower_name;

								$mailer->senderEmail    =  $this->getEnv('EMAIL_ADDRESS');

								$mailer->senderPassword =  $this->getEnv('EMAIL_PASSWORD');

								$mailer->host_mail  	=  'smtp.gmail.com';

								$mailer->message     	=  $msg;

								if ($mailer->send())
								{
									$book_model->table  = 'buku';

									$numberofbook       = $book_model->where($change_status_book_borrower_data->bookid)->get('Jumlah_Buku' , 'ID_Buku')->fetch();

									$Newnumberofbook    = $numberofbook['Jumlah_Buku'] + 1; 

									if ($book_model->where($change_status_book_borrower_data->bookid)->update("Jumlah_Buku='$Newnumberofbook'", "ID_Buku"))
									{
										Ajax::json_response(array('Tag' => '#7eb569bf3f', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Pengubahan status peminjaman telah berhasil dilakukan.'));
									}
									else
									{
										Ajax::json_response(array('Tag' => '#be2348c9f8', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengubahan status peminjaman tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
									}
								}
								else
								{
									Ajax::json_response(array('Tag' => '#4207h3fbf1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengubahan status peminjaman tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
								}
							}
							else
							{
								Ajax::json_response(array('Tag' => '#g51g081300', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengubahan status peminjaman tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
							}
						}
						else
						{
							Ajax::json_response(array('Tag' => '#bg0190e1b8', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengubahan status peminjaman tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
						}
					}
					else
					{
						Ajax::json_response(array('Tag' => '#a411acb911', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Pengubahan status yang sama tidak dapat dilakukan.'));
					}
				}
				else
				{
					Ajax::json_response(array('Tag' => '#4360d6a822', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengubahan status peminjaman tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.'));
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}
}