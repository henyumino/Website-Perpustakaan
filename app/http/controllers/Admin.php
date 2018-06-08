<?php

use Flare\Network\Http\Controller;

use Flare\Components\Environment;

use Flare\Network\Http\Ajax;

use Flare\Components\Validation;

class Admin extends Controller
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

	public function viewLogin()
	{
		$data = array
				(
					"URL" => $this->getEnv('BASE_URL')
				); 

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;		

		$session->start();

		if ($session->check('admin') == true)
		{
		    $admin_model           = new app\http\models\Admin;

			$admin_model->connect();

			$admin_model->table    = 'pemilik';

			if ($admin_model->CheckID($session->value('admin')))
			{
				$admin_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/admin/dashboard/index.php?secretaryList=show&treasurerList=hide');
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('admin') == true)
		{
			$admin_model           = new app\http\models\Admin;

			$admin_model->connect();

			$admin_model->table    = 'pemilik';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($admin_model->CheckID($encode->unprotected($cookie->value('admin'))))
			{
				$admin_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/admin/dashboard/index.php?secretaryList=show&treasurerList=hide');
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

	public function processLogout()
	{
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;		

		$session->start();

		if ($session->check('admin') == true)
		{
			$admin_model           = new app\http\models\Admin;

			$admin_model->connect();

			$admin_model->table    = 'pemilik';

			if ($admin_model->CheckID($session->value('admin')))
			{
				$admin_model->disconnect();

				$session->take('admin');

				self::redirect('http://localhost:8080/projekuas/admin/login/');
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('admin') == true)
		{
			$admin_model           = new app\http\models\Admin;

			$admin_model->connect();

			$admin_model->table    = 'pemilik';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($admin_model->CheckID($encode->unprotected($cookie->value('admin'))))
			{
				$admin_model->disconnect();

				$cookie->take('admin');

				self::redirect('http://localhost:8080/projekuas/admin/login/');
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
		$data = array
				(
					"URL" => $this->getEnv('BASE_URL')
				); 

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('admin') == true)
		{
			$admin_model           = new app\http\models\Admin;

			$admin_model->connect();

			$admin_model->table    = 'pemilik';

			if ($admin_model->CheckID($session->value('admin')))
			{	
				if (isset($_GET['secretaryList']) OR empty($_GET['secretaryList']) == false)
				{
					if (isset($_GET['treasurerList']) OR empty($_GET['treasurerList']) == false)
					{
						if ($_GET['secretaryList'] == 'show' AND $_GET['treasurerList'] == 'hide')
						{
							$limit_display       = 10;

						   	$set_page_1          = isset($_GET['page_secretary'])? (int)$_GET["page_secretary"]:1;
        
        					$check_page_1        = ($set_page_1>1) ? ($set_page_1 * $limit_display) - $limit_display : 0;

							$total_rows_1        = $admin_model->getRowsTableSecretary();

							$ceilIt_1            = ceil($total_rows_1/$limit_display);

							$list_role_secretary = $admin_model->getDataSecretary($check_page_1, $limit_display);

							$data 				 = array
									  			   (
													 "URL"           			   => $this->getEnv('BASE_URL'),
													 "Data_Pemilik"  			   => $admin_model->getAdminData($session->value('admin')),
												  	 "Data_Sekretaris" 			   => $list_role_secretary,
													 "Halaman_Paging_Sekretaris"    => $set_page_1,
													 "Total_Halaman_Sekretaris"     => $ceilIt_1
												   );

							$this->parts($data);
						}
						else if ($_GET['secretaryList'] == 'hide' AND $_GET['treasurerList'] == 'show')
						{
							$limit_display       = 10;

							$set_page_2          = isset($_GET['page_treasurer'])? (int)$_GET["page_treasurer"]:1;
        
			        		$check_page_2        = ($set_page_2>1) ? ($set_page_2 * $limit_display) - $limit_display : 0;

							$total_rows_2        = $admin_model->getRowsTableTreasurer();

							$ceilIt_2            = ceil($total_rows_2/$limit_display);

							$list_role_treasurer = $admin_model->getDataTreasurer($check_page_2, $limit_display);

							$data 				 = array
									  			   (
													 "URL"           			   => $this->getEnv('BASE_URL'),
													 "Data_Pemilik"  			   => $admin_model->getAdminData($session->value('admin')),
												  	 "Data_Bendahara" 			   => $list_role_treasurer,
													 "Halaman_Paging_Bendahara"    => $set_page_2,
													 "Total_Halaman_Bendahara"     => $ceilIt_2
												   );
							// @Override -- Merubah directory awal dengan directory lain tidak diperbolehkan 
							//		        pada controller class. Kecuali dengan keadaan terdesak.
							/**
							* @return void => use Flare\Override::use()
							*/

							$Settings = array
								        (
            								'controllers'       => '../../../', 
								            'config'            => '../../../',
            								'custom_resources'  => '../../resources/admin_dashboard_2/',
								            'custom_errors'     => '../../resources/errors/'
            							);

							self::setDirectory($Settings);

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
		else if ($cookie->check('admin') == true)
		{
			$admin_model           = new app\http\models\Admin;

			$admin_model->connect();

			$admin_model->table    = 'pemilik';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($admin_model->CheckID($encode->unprotected($cookie->value('admin'))))
			{
				if (isset($_GET['secretaryList']) OR empty($_GET['secretaryList']) == false)
				{
					if (isset($_GET['treasurerList']) OR empty($_GET['treasurerList']) == false)
					{
						if ($_GET['secretaryList'] == 'show' AND $_GET['treasurerList'] == 'hide')
						{
							$limit_display       = 10;

						   	$set_page_1          = isset($_GET['page_secretary'])? (int)$_GET["page_secretary"]:1;
        
        					$check_page_1        = ($set_page_1>1) ? ($set_page_1 * $limit_display) - $limit_display : 0;

							$total_rows_1        = $admin_model->getRowsTableSecretary();

							$ceilIt_1            = ceil($total_rows_1/$limit_display);

							$list_role_secretary = $admin_model->getDataSecretary($check_page_1, $limit_display);

							$data 				 = array
									  			   (
													 "URL"           			   => $this->getEnv('BASE_URL'),
													 "Data_Pemilik"  			   => $admin_model->getAdminData($encode->unprotected($cookie->value('admin'))),
												  	 "Data_Sekretaris" 			   => $list_role_secretary,
													 "Halaman_Paging_Sekretaris"    => $set_page_1,
													 "Total_Halaman_Sekretaris"     => $ceilIt_1
												   );

							$this->parts($data);
						}
						else if ($_GET['secretaryList'] == 'hide' AND $_GET['treasurerList'] == 'show')
						{
							$limit_display       = 10;

							$set_page_2          = isset($_GET['page_treasurer'])? (int)$_GET["page_treasurer"]:1;
        
			        		$check_page_2        = ($set_page_2>1) ? ($set_page_2 * $limit_display) - $limit_display : 0;

							$total_rows_2        = $admin_model->getRowsTableTreasurer();

							$ceilIt_2            = ceil($total_rows_2/$limit_display);

							$list_role_treasurer = $admin_model->getDataTreasurer($check_page_2, $limit_display);

							$data 				 = array
									  			   (
													 "URL"           			   => $this->getEnv('BASE_URL'),
													 "Data_Pemilik"  			   => $admin_model->getAdminData($encode->unprotected($cookie->value('admin'))),
												  	 "Data_Bendahara" 			   => $list_role_treasurer,
													 "Halaman_Paging_Bendahara"    => $set_page_2,
													 "Total_Halaman_Bendahara"     => $ceilIt_2
												   );
							// @Override -- Merubah directory awal dengan directory lain tidak diperbolehkan 
							//		        pada controller class. Kecuali dengan keadaan terdesak.
							/**
							* @return void => use Flare\Override::use()
							*/

							$Settings = array
								        (
            								'controllers'       => '../../', 
								            'config'            => '../../',
            								'custom_resources'  => '../resources/admin_dashboard_2/',
								            'custom_errors'     => '../resources/errors/'
            							);

							self::setDirectory($Settings);

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
		else
		{
			$this->error_404();
		}
	}

	public function loginAjax()
	{
		if (Ajax::check())
		{
			$admin_login_data      = Ajax::AngularInput();

			$admin_model           = new app\http\models\Admin;

			$admin_model->connect();

			$admin_model->table    = 'pemilik';

			if (Validation::isEmpty($admin_login_data->email))
			{
				Ajax::json_response(array('Tag' => '#69e0bhf1c4', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email masih kosong'));
			}
			else if (Validation::isEmpty($admin_login_data->password))
			{
				Ajax::json_response(array('Tag' => '#20e29h12gd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi masih kosong'));
			}
			else
			{
				if (Validation::Regex("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/", $admin_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#2470g04118', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format email yang anda masukkan salah'));
				}
				else if (Validation::Minimum(15, $admin_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#5dh2gb9f7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email minimal terdapat 15 karakter'));
				}
				else if (Validation::Maximum(50, $admin_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#3g946e7b5d', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email maksimal terdapat 50 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z-0-9]*$/", $admin_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#d991d452df', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $admin_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#dgh9dcbeh9', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(25, $admin_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#c86b5df820', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi maksimal terdapat 25 karakter'));
				}
				else if ($admin_model->CheckEmail($admin_model->get(null, 'Email')->fetch(), $admin_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#1e5h24ce21', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email yang anda masukkan salah'));

				}
				else if ($admin_model->CheckPassword($admin_model->get(null, 'Katasandi')->fetch(), $admin_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#1e87ab2a0a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi yang anda masukkan salah'));
				}
				else 
				{
					if ($admin_login_data->method == 'cookie')
					{
						$encode         = new Flare\Components\Encode;

						$encode->key    = $this->getEnv('KEY');

						$cookie         = new Flare\Network\Http\Cookie;

						$cookie->name   = 'admin';

						// Method 1

						// $cookie->use    = $encode->protect($admin_login_data->email));		

						// $cookie->give();

						// ----------------------------------------------------------------

						// Method 2

						$cookie->give()->use($encode->protect($admin_model->getId($admin_login_data->email)));

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Type' => 'success'));

						$admin_model->disconnect();
					}
					else if ($admin_login_data->method == 'session')
					{
						$session = new Flare\Network\Http\Session;

						$session->name = "admin";

						$session->start();

						// --------------------------------------------

						// Method 1

						// $session->use  = $admin_login_data->email;

						// $session->give();

						// --------------------------------------------

						// Method 2

						$session->give()->use($admin_model->getId($admin_login_data->email));

						// --------------------------------------------

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Type' => 'success'));

						$admin_model->disconnect();
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

	public function viewManageMember()
	{ 
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('admin') == true)
		{
			$admin_model           = new app\http\models\Admin;

			$admin_model->connect();

			$admin_model->table    = 'pemilik';

			if ($admin_model->CheckID($session->value('admin')))
			{	
				if (isset($_GET['secretaryList']) OR empty($_GET['secretaryList']) == false)
				{
					if (isset($_GET['treasurerList']) OR empty($_GET['treasurerList']) == false)
					{
						if ($_GET['secretaryList'] == 'show' AND $_GET['treasurerList'] == 'hide')
						{
							$limit_display       = 10;

						   	$set_page_1          = isset($_GET['page_secretary'])? (int)$_GET["page_secretary"]:1;
        
        					$check_page_1        = ($set_page_1>1) ? ($set_page_1 * $limit_display) - $limit_display : 0;

							$total_rows_1        = $admin_model->getRowsTableSecretary();

							$ceilIt_1            = ceil($total_rows_1/$limit_display);

							$list_role_secretary = $admin_model->getDataSecretary($check_page_1, $limit_display);

							$data 				 = array
									  			   (
													 "URL"           			   => $this->getEnv('BASE_URL'),
												  	 "Data_Sekretaris" 			   => $list_role_secretary,
													 "Halaman_Paging_Sekretaris"    => $set_page_1,
													 "Total_Halaman_Sekretaris"     => $ceilIt_1
												   );

							$this->parts($data);
						}
						else if ($_GET['secretaryList'] == 'hide' AND $_GET['treasurerList'] == 'show')
						{
							$set_page_2          = isset($_GET['page_treasurer'])? (int)$_GET["page_treasurer"]:1;
        
			        		$check_page_2        = ($set_page_2>1) ? ($set_page_2 * $limit_display) - $limit_display : 0;

							$total_rows_2        = $admin_model->getRowsTableTreasurer();

							$ceilIt_2            = ceil($total_rows_2/$limit_display);

							$list_role_treasurer = $admin_model->getDataTreasurer($check_page_2, $limit_display);

							$data 				 = array
									  			   (
													 "URL"           			   => $this->getEnv('BASE_URL'),
												  	 "Data_Bendahara" 			   => $list_role_treasurer,
													 "Halaman_Paging_Bendahara"    => $set_page_2,
													 "Total_Halaman_Bendahara"     => $ceilIt_2
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
		else if ($cookie->check('admin') == true)
		{
			$admin_model           = new app\http\models\Admin;

			$admin_model->connect();

			$admin_model->table    = 'pemilik';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($admin_model->CheckID($encode->unprotected($cookie->value('admin'))))
			{
				if (isset($_GET['secretaryList']) OR empty($_GET['secretaryList']) == false)
				{
					if (isset($_GET['treasurerList']) OR empty($_GET['treasurerList']) == false)
					{
						if ($_GET['secretaryList'] == 'show' AND $_GET['treasurerList'] == 'hide')
						{
							$limit_display       = 10;

						   	$set_page_1          = isset($_GET['page_secretary'])? (int)$_GET["page_secretary"]:1;
        
        					$check_page_1        = ($set_page_1>1) ? ($set_page_1 * $limit_display) - $limit_display : 0;

							$total_rows_1        = $admin_model->getRowsTableSecretary();

							$ceilIt_1            = ceil($total_rows_1/$limit_display);

							$list_role_secretary = $admin_model->getDataSecretary($check_page_1, $limit_display);

							$data 				 = array
									  			   (
													 "URL"           			   => $this->getEnv('BASE_URL'),
												  	 "Data_Sekretaris" 			   => $list_role_secretary,
													 "Halaman_Paging_Sekretaris"    => $set_page_1,
													 "Total_Halaman_Sekretaris"     => $ceilIt_1
												   );

							$this->parts($data);
						}
						else if ($_GET['secretaryList'] == 'hide' AND $_GET['treasurerList'] == 'show')
						{
							$set_page_2          = isset($_GET['page_treasurer'])? (int)$_GET["page_treasurer"]:1;
        
			        		$check_page_2        = ($set_page_2>1) ? ($set_page_2 * $limit_display) - $limit_display : 0;

							$total_rows_2        = $admin_model->getRowsTableTreasurer();

							$ceilIt_2            = ceil($total_rows_2/$limit_display);

							$list_role_treasurer = $admin_model->getDataTreasurer($check_page_2, $limit_display);

							$data 				 = array
									  			   (
													 "URL"           			   => $this->getEnv('BASE_URL'),
												  	 "Data_Bendahara" 			   => $list_role_treasurer,
													 "Halaman_Paging_Bendahara"    => $set_page_2,
													 "Total_Halaman_Bendahara"     => $ceilIt_2
												   );
							// @Override -- Merubah directory awal dengan directory lain tidak diperbolehkan 
							//		        pada controller class. Kecuali dengan keadaan terdesak.
							/**
							* @return void => use Flare\Override::use()
							*/

							$Settings = array
								        (
            								'controllers'       => '../../', 
								            'config'            => '../../',
            								'custom_resources'  => '../resources/admin_dashboard_2/',
								            'custom_errors'     => '../resources/errors/'
            							);

							self::setDirectory($Settings);

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
		else
		{
			$this->error_404();
		}
	}

	public function addMemberAjax()
	{
		if (Ajax::check())
		{
			$admin_addmember_data    = Ajax::AngularInput();

			if (Validation::isEmpty($admin_addmember_data->firstname))
			{
				Ajax::json_response(array('Tag' => '#b7h480f2cg', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama depan masih kosong'));
			}
			else if (Validation::isEmpty($admin_addmember_data->lastname))
			{
				Ajax::json_response(array('Tag' => '#ehd7h053b9', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama belakang masih kosong'));
			}
			else if (Validation::isEmpty($admin_addmember_data->dateofbirth))
			{
				Ajax::json_response(array('Tag' => '#h2c40gh3e3', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tangal lahir masih kosong'));
			}
			else if (Validation::isEmpty($admin_addmember_data->monthofbirth))
			{
				Ajax::json_response(array('Tag' => '#6820b4ad82', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Bulan lahir masih kosong'));	
			}
			else if (Validation::isEmpty($admin_addmember_data->yearofbirth))
			{
				Ajax::json_response(array('Tag' => '#f2ce01g2e4', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tahun lahir masih kosong'));	
			}
			else if (Validation::isEmpty($admin_addmember_data->gender))
			{
				Ajax::json_response(array('Tag' => '#9dff8047hh', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jenis kelamin masih kosong'));
			}
			else if (Validation::isEmpty($admin_addmember_data->address))
			{
				Ajax::json_response(array('Tag' => '#c9c28hhba5', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat masih kosong'));
			}
			else if (Validation::isEmpty($admin_addmember_data->phonenumber))
			{
				Ajax::json_response(array('Tag' => '#fg9037c2dd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel masih kosong'));
			}
			else if (Validation::isEmpty($admin_addmember_data->email))
			{
				Ajax::json_response(array('Tag' => '#1ah73hh02c', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email masih kosong'));
			}
			else if (Validation::isEmpty($admin_addmember_data->role))
			{
				Ajax::json_response(array('Tag' => '#17935h544h', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Status anggota yang ingin ditambahkan belum dipilih'));
			}
			else
			{
				if (Validation::Regex("/^[a-zA-Z ]*$/", $admin_addmember_data->firstname) == false)
				{
					Ajax::json_response(array('Tag' => '#efg6cagcac', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama depan hanya boleh berisi huruf dan spasi'));
				}
				else if (Validation::Minimum(3, $admin_addmember_data->firstname) == false)
				{
					Ajax::json_response(array('Tag' => '#f27e8gag37', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama depan minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(25, $admin_addmember_data->firstname) == false)
				{
					Ajax::json_response(array('Tag' => '#70485964b6', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama depan maksimal terdapat 25 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z ]*$/", $admin_addmember_data->lastname) == false) 
				{
					Ajax::json_response(array('Tag' => '#7c540886g8', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama belakang hanya boleh berisi huruf dan spasi'));
				}
				else if (Validation::Minimum(3, $admin_addmember_data->lastname) == false)
				{
					Ajax::json_response(array('Tag' => '#b0f6d115b1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama belakang minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(25, $admin_addmember_data->lastname) == false)
				{
					Ajax::json_response(array('Tag' => '#790fb3461f', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama belakang maksimal terdapat 25 karakter'));
				}
				else if (Validation::Minimum(10, $admin_addmember_data->address) == false)
				{
					Ajax::json_response(array('Tag' => '#fcg1a40b1g', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat minimal terdapat 10 karakter'));
				}
				else if (Validation::Maximum(50, $admin_addmember_data->address) == false)
				{
					Ajax::json_response(array('Tag' => '#688543ehh9', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat maksimal terdapat 50 karakter'));
				}
				else if (Validation::Regex("/08?[0-9]{10}$/", $admin_addmember_data->phonenumber) == false)
				{
					Ajax::json_response(array('Tag' => '#52gh202e44', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format nomor ponsel yang anda masukkan salah'));
				}
				else if (Validation::Minimum(12, $admin_addmember_data->phonenumber) == false)
				{
					Ajax::json_response(array('Tag' => '#d197e1g4hb', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel harus terdiri dari 12 digit'));
				}
				else if (Validation::Maximum(12, $admin_addmember_data->phonenumber) == false)
				{
					Ajax::json_response(array('Tag' => '#f073b40c38', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel harus terdiri dari 12 digit'));
				}
				else if (Validation::Regex("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/", $admin_addmember_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#2ebc6gcg7b', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format email yang anda masukkan salah'));
				}
				else if (Validation::Minimum(15, $admin_addmember_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#f220db1dg6', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email minimal terdapat 15 karakter'));
				}
				else if (Validation::Maximum(50, $admin_addmember_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#07ed54be2c', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email maksimal terdapat 50 karakter'));
				}
				else
				{
					if ($admin_addmember_data->gender == 'Pria' AND $admin_addmember_data->gender != 'Wanita' OR $admin_addmember_data->gender != 'Pria' AND $admin_addmember_data->gender == 'Wanita')
					{
						if ($admin_addmember_data->role == 'Sekretaris')
						{
							$secretary_model = new app\http\models\Secretary;

							$secretary_model->connect();

							$secretary_model->table = 'sekretaris';

							if ($secretary_model->CheckEmail($admin_addmember_data->email))
							{
								Ajax::json_response(array('Tag' => '#1e5h24ce21', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email yang anda gunakan sudah terdaftar sebagai Sekretaris'));
							}
							else
							{
								$secretary_id         = substr(str_shuffle('0123456789012345678901234567890123456789'),0,40);

								$secretary_folder     = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,40);

								$secretary_img_fname  = $admin_addmember_data->gender == 'Pria' ? '6gb12a88h51e7016b21g7371h.png' : 'd5991cc5b8f8dc8a4g26c335g.png';

								$secretary_img_path   = $admin_addmember_data->gender == 'Pria' ? '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/6gb12a88h51e7016b21g7371h.png' : '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/d5991cc5b8f8dc8a4g26c335g.png';

								$setup_code           = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,50);

								$Name                 = $admin_addmember_data->firstname." ".$admin_addmember_data->lastname;

								$msg              = "<html><head><style>a {text-decoration: none;color: blue;}</style></head><body>Yth, <strong>$Name</strong>. <br/><br/> Anda baru saja didaftarkan sebagai Sekretaris di <a href='".$this->getEnv('BASE_URL')."'>Perpustakaan Nusantara</a>. Namun anda tidak dapat mengakses akun anda sebagai Sekretaris jika tidak melakukan konfigurasi pada akun anda. Silahkan klik tautan yang ada dibawah ini untuk menkonfigurasi akun anda. <br/><br/> <a href='".$this->getEnv('BASE_URL')."setup_secretary.php?secretary_id=".$secretary_id."&setup_code=".$setup_code."'>".$this->getEnv('BASE_URL')."setup_secretary.php?secretary_id=".$secretary_id."&setup_code=".$setup_code."</a> <br/><br/> Jika anda merasa tidak mengenal apapun mengenai hal ini silahkan abaikan email ini, terima kasih.</body></html>";

								$mailer = new Flare\Components\Mail;

								$mailer->timezone     	=  'Asia/Makassar';

								$mailer->senderName   	=  'Perpusnusantara';

								$mailer->thesubject   	=  'Anda Didaftarkan Sebagai Sekretaris';

								$mailer->receiptEmail 	=  $admin_addmember_data->email;

								$mailer->receiptName  	=  $Name;

								$mailer->senderEmail    =  $this->getEnv('EMAIL_ADDRESS');

								$mailer->senderPassword =  $this->getEnv('EMAIL_PASSWORD');

								$mailer->host_mail  	=  'smtp.gmail.com';

								$mailer->message     	=  $msg;

								$newpassword			= '$2y$10$oqUqDL.RNWz9BccRNakX6eWKcGhywyrPp3otbCZZZCDdgs0kHd7VW';

								if ($mailer->Send())
								{
									if ($secretary_model->insert("ID_Sekretaris,Folder_Sekretaris,Foto_Sekretaris,Nama,Tanggal_Lahir,Bulan_Lahir,Tahun_Lahir,Jenis_Kelamin,Alamat,Ponsel,Email,Katasandi,Kode_Konfigurasi_Akun,Kode_Atur_Ulang_Katasandi,Akses_Atur_Ulang_Katasandi,Status_Akun", "'$secretary_id','$secretary_folder','$secretary_img_fname','$Name','$admin_addmember_data->dateofbirth','$admin_addmember_data->monthofbirth','$admin_addmember_data->yearofbirth','$admin_addmember_data->gender','$admin_addmember_data->address','$admin_addmember_data->phonenumber','$admin_addmember_data->email','$newpassword','$setup_code','Tidak Ada', 'Tidak Aktif','Belum Terverifikasi'"))
									{
										if (!file_exists("../resources/assets/".$secretary_folder."/".$secretary_img_fname) OR !file_exists("../resources/assets/".$secretary_folder."/index.php"))
										{	
											mkdir("../resources/assets/".$secretary_folder, 0777, true);

											if (copy($secretary_img_path, "../resources/assets/".$secretary_folder."/".$secretary_img_fname))
											{
												if (copy('../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/index.php', '../resources/assets/'.$secretary_folder.'/index.php'))
												{
													$secretary_model->disconnect();

													Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Anda telah berhasil menambahkan sekretaris sistem sudah mengirimkan tautan ke email sekretaris tersebut agar ia bisa melakukan konfigurasi akun.'));
												}
												else
												{
													Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan sekretaris tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
												}
											}
											else
											{
												Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan sekretaris tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
											}
										}
										else
										{
											Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan sekretaris tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
										}
									}
									else
									{
										Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan sekretaris tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
									}
								}
								else
								{
									Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan sekretaris tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
								}
							}

						}
						else if ($admin_addmember_data->role == 'Bendahara')
						{
							$treasurer_model       = new app\http\models\Treasurer;

							$treasurer_model->connect();

							$treasurer_model->table = 'bendahara';

							if ($treasurer_model->CheckEmail($admin_addmember_data->email))
							{
								Ajax::json_response(array('Tag' => '#1e5h24ce21', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email yang anda gunakan sudah terdaftar sebagai Bendahara'));
							}
							else
							{
								$treasurer_id         = substr(str_shuffle('0123456789012345678901234567890123456789'),0,40);

								$treasurer_folder     = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,40);

								$treasurer_img_fname  = $admin_addmember_data->gender == 'Pria' ? '6gb12a88h51e7016b21g7371h.png' : 'd5991cc5b8f8dc8a4g26c335g.png';

								$treasurer_img_path   = $admin_addmember_data->gender == 'Pria' ? '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/6gb12a88h51e7016b21g7371h.png' : '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/d5991cc5b8f8dc8a4g26c335g.png';

								$setup_code           = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,50);

								$Name                 = $admin_addmember_data->firstname." ".$admin_addmember_data->lastname;

								$msg              = "<html><head><style>a {text-decoration: none;color: blue;}</style></head><body>Yth, <strong>$Name</strong>. <br/><br/> Anda baru saja didaftarkan sebagai Bendahara di <a href='".$this->getEnv('BASE_URL')."'>Perpustakaan Nusantara</a>. Namun anda tidak dapat mengakses akun anda sebagai Bendahara jika tidak melakukan konfigurasi pada akun anda. Silahkan klik tautan yang ada dibawah ini untuk menkonfigurasi akun anda. <br/><br/> <a href='".$this->getEnv('BASE_URL')."setup_treasurer.php?treasurer_id=".$treasurer_id."&setup_code=".$setup_code."'>".$this->getEnv('BASE_URL')."setup_treasurer.php?treasurer_id=".$treasurer_id."&setup_code=".$setup_code."</a> <br/><br/> Jika anda merasa tidak mengenal apapun mengenai hal ini silahkan abaikan email ini, terima kasih.</body></html>";

								$mailer = new Flare\Components\Mail;

								$mailer->timezone     	=  'Asia/Makassar';

								$mailer->senderName   	=  'Perpusnusantara';

								$mailer->thesubject   	=  'Anda Didaftarkan Sebagai Bendahara';

								$mailer->receiptEmail 	=  $admin_addmember_data->email;

								$mailer->receiptName  	=  $Name;

								$mailer->senderEmail    =  $this->getEnv('EMAIL_ADDRESS');

								$mailer->senderPassword =  $this->getEnv('EMAIL_PASSWORD');

								$mailer->host_mail  	=  'smtp.gmail.com';

								$mailer->message     	=  $msg;

								$newpassword			= '$2y$10$oqUqDL.RNWz9BccRNakX6eWKcGhywyrPp3otbCZZZCDdgs0kHd7VW';

								if ($mailer->Send())
								{
									if ($treasurer_model->insert("ID_Bendahara,Folder_Bendahara,Foto_Bendahara,Nama,Tanggal_Lahir,Bulan_Lahir,Tahun_Lahir,Jenis_Kelamin,Alamat,Ponsel,Email,Katasandi,Kode_Konfigurasi_Akun,Kode_Atur_Ulang_Katasandi,Akses_Atur_Ulang_Katasandi,Status_Akun", "'$treasurer_id','$treasurer_folder','$treasurer_img_fname','$Name','$admin_addmember_data->dateofbirth','$admin_addmember_data->monthofbirth','$admin_addmember_data->yearofbirth','$admin_addmember_data->gender','$admin_addmember_data->address','$admin_addmember_data->phonenumber','$admin_addmember_data->email','$newpassword','$setup_code','Tidak Ada','Tidak Aktif','Belum Terverifikasi'"))
									{
										if (!file_exists("../resources/assets/".$treasurer_folder."/".$treasurer_img_fname) OR !file_exists("../resources/assets/".$treasurer_folder."/index.php"))
										{	
											mkdir("../resources/assets/".$treasurer_folder, 0777, true);

											if (copy($treasurer_img_path, "../resources/assets/".$treasurer_folder."/".$treasurer_img_fname))
											{
												if (copy('../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/index.php', '../resources/assets/'.$treasurer_folder.'/index.php'))
												{
													$treasurer_model->disconnect();

													Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Anda telah berhasil menambahkan bendahara sistem sudah mengirimkan tautan ke email bendahara tersebut agar ia bisa melakukan konfigurasi akun.'));
												}
												else
												{
													Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan bendahara tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
												}
											}
											else
											{
												Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan bendahara tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
											}
										}
										else
										{
											Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan bendahara tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
										}
									}
									else
									{
										Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan bendahara tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
									}
								}
								else
								{
									Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan bendahara tidak berhasil. Silahkan muat ulang laman ini dan mencoba menambahkan kembali'));
								}
							}
						}
						else
						{
							Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan anggota tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
						}
					}
					else
					{
						Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan anggota tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
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

		if ($session->check('admin') == true)
		{
			$admin_model           = new app\http\models\Admin;

			$admin_model->connect();

			$admin_model->table    = 'pemilik';

			if ($admin_model->CheckID($session->value('admin')))
			{
				$data = array
						(
							"URL"   => $this->getEnv('BASE_URL'),
							"Data"  => $admin_model->getAdminData($session->value('admin'))
						);

				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('admin') == true)
		{
			$admin_model           = new app\http\models\Admin;

			$admin_model->connect();

			$admin_model->table    = 'pemilik';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($admin_model->CheckID($encode->unprotected($cookie->value('admin'))))
			{
				$data = array
						(
							"URL"   => $this->getEnv('BASE_URL'),
							"Data"  => $admin_model->getAdminData($encode->unprotected($cookie->value('admin')))
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

			$admin_model = new app\http\models\Secretary;

			$admin_model->connect();

			$admin_model->table = 'pemilik';

			$system_profil_picture	= array
									  (
									  	'6gb12a88h51e7016b21g7371h.png',
									  	'd5991cc5b8f8dc8a4g26c335g.png'
									  );

			$get_profile_picture 	= $admin_model->where($data_update_account->id)->get('Foto_Pemilik', 'ID_Pemilik')->fetch(); 

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
						if ($admin_model->where($data_update_account->id)->update("Nama='$data_update_account->fullname', Tanggal_Lahir='$data_update_account->dateofbirth', Bulan_Lahir='$data_update_account->monthofbirth', Tahun_Lahir='$data_update_account->yearofbirth', Jenis_Kelamin='$data_update_account->gender', Alamat='$data_update_account->address', Ponsel='$data_update_account->phonenumber', Email='$data_update_account->email'", "ID_Pemilik"))
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
					else if ($data_update_account->gender != $data_update_account->gendernow AND in_array($get_profile_picture['Foto_Pemilik'], $system_profil_picture))
					{
						$admin_model = new app\http\models\Admin;

						$admin_model->connect();

						$admin_model->table = 'pemilik';

						$get_name_folder_now	= $admin_model->where($data_update_account->id)->get('Folder_Pemilik', 'ID_Pemilik')->fetch();

						$get_name_img_now		= $admin_model->where($data_update_account->id)->get('Foto_Pemilik', 'ID_Pemilik')->fetch();

						$img_now   = '../resources/assets/'.$get_name_folder_now['Folder_Pemilik'].'/'.$get_name_img_now['Foto_Pemilik'];

						$img_fname = $data_update_account->gender == 'Pria' ? '6gb12a88h51e7016b21g7371h.png' : 'd5991cc5b8f8dc8a4g26c335g.png'; 

						$from      = $data_update_account->gender == 'Pria' ? '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/6gb12a88h51e7016b21g7371h.png' : '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/d5991cc5b8f8dc8a4g26c335g.png';

						if (unlink($img_now))
						{
							if (copy($from, '../resources/assets/'.$get_name_folder_now['Folder_Pemilik'].'/'.$img_fname))
							{
								if ($admin_model->where($data_update_account->id)->update("Foto_Pemilik='$img_fname' , Nama='$data_update_account->fullname', Tanggal_Lahir='$data_update_account->dateofbirth', Bulan_Lahir='$data_update_account->monthofbirth', Tahun_Lahir='$data_update_account->yearofbirth', Jenis_Kelamin='$data_update_account->gender', Alamat='$data_update_account->address', Ponsel='$data_update_account->phonenumber', Email='$data_update_account->email'", "ID_Pemilik"))
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
					else if ($data_update_account->gender != $data_update_account->gendernow AND in_array($get_profile_picture['Foto_Pemilik'], $system_profil_picture) == false)
					{
						if ($admin_model->where($data_update_account->id)->update("Nama='$data_update_account->fullname', Tanggal_Lahir='$data_update_account->dateofbirth', Bulan_Lahir='$data_update_account->monthofbirth', Tahun_Lahir='$data_update_account->yearofbirth', Jenis_Kelamin='$data_update_account->gender', Alamat='$data_update_account->address', Ponsel='$data_update_account->phonenumber', Email='$data_update_account->email'", "ID_Pemilik"))
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
										$admin_model = new app\http\models\Admin;

										$admin_model->connect();

										$admin_model->table = 'pemilik';

										$get_name_folder_now	= $admin_model->where($id)->get('Folder_Pemilik', 'ID_Pemilik')->fetch();

										$get_folder_now 		= '../resources/assets/'.$get_name_folder_now['Folder_Pemilik'].'/';

										$this->deleteFolderNow($get_folder_now);

										if ($admin_model->where($id)->update("Folder_Pemilik='$new_folder', Foto_Pemilik='$profil_picture_name', Nama='$fullname', Tanggal_Lahir='$dateofbirth', Bulan_Lahir='$monthofbirth', Tahun_Lahir='$yearofbirth', Jenis_Kelamin='$gender', Alamat='$address', Ponsel='$phonenumber', Email='$email'", "ID_Pemilik"))
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

			$admin_model	   	   = new app\http\models\Admin;

			$admin_model->connect();

			$admin_model->table    = 'pemilik';

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
				else if ($admin_model->CheckPassword($admin_model->get(null, 'Katasandi')->fetch(), $change_password_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#1e87ab2a0a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi lama yang anda masukkan salah'));
				}
				else
				{

					$hash_new_password = password_hash($change_password_data->newpassword, PASSWORD_DEFAULT);

					if ($admin_model->where($change_password_data->id)->update("Katasandi='$hash_new_password'", "ID_Pemilik"))
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

	public function DeleteRoleSecretaryAjax()
	{
		if (Ajax::Check())
		{
			$delete_role_secretary_data = Ajax::AngularInput();

			$secretary_model            = new app\http\models\Secretary;

			$secretary_model->connect();

			$secretary_model->table     = 'sekretaris';

			if ($secretary_model->CheckID($delete_role_secretary_data->secretary_id))
			{
				if ($secretary_model->DeleteSecretary($delete_role_secretary_data->secretary_id))
				{
					Ajax::json_response(array('Tag' => '#gd4dbaf0a7', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Sekretaris berhasil dihapus'));
				}
				else
				{
					Ajax::json_response(array('Tag' => '#9b05e73be1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan anggota tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
				}
			}
			else
			{
				Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan anggota tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
			}
		}	
		else
		{
			$this->error_404();
		}
	}

	public function DeleteRoleTreasurerAjax()
	{
		if (Ajax::Check())
		{
			$delete_role_secretary_data = Ajax::AngularInput();

			$treasurer_model            = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table     = 'bendahara';

			if ($treasurer_model->CheckID($delete_role_secretary_data->treasurer_id))
			{
				if ($treasurer_model->DeleteTreasurer($delete_role_secretary_data->treasurer_id))
				{
					Ajax::json_response(array('Tag' => '#gd4dbaf0a7', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Bendahara berhasil dihapus'));
				}
				else
				{
					Ajax::json_response(array('Tag' => '#9b05e73be1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan anggota tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
				}
			}
			else
			{
				Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan anggota tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
			}
		}	
		else
		{
			$this->error_404();
		}
	}

	public function searchSecretaryAjax()
	{
		if (Ajax::check())
		{
			$search_secretary_data = Ajax::AngularInput();

			if (Validation::isEmpty(Validation::SecureInput($search_secretary_data->keyword)))
			{
				Ajax::json_response(array('Tag' => '#6ae6abec7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci masih kosong'));
			}
			else
			{	
				if (Validation::Minimum(3, Validation::SecureInput($search_secretary_data->keyword)) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(200, Validation::SecureInput($search_secretary_data->keyword)) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci maksimal terdapat 200 karakter'));
				}
				else
				{
					$keyword 		   = Validation::SecureInput($search_secretary_data->keyword);

					$admin_model 	   = new app\http\models\Admin;

					$admin_model->connect();

					$admin_model->table = 'pemilik';

					$data_table			= $admin_model->searchMemberSecretary($keyword);

					if (empty($data_table) == false OR is_null($data_table) == false)
					{
						Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Type' => 'success', 'result' => $data_table, 'keyword' => $search_secretary_data->keyword));
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

	public function searchTreasurerAjax()
	{
		if (Ajax::check())
		{
			$search_treasurer_data = Ajax::AngularInput();

			if (Validation::isEmpty(Validation::SecureInput($search_treasurer_data->keyword)))
			{
				Ajax::json_response(array('Tag' => '#6ae6abec7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci masih kosong'));
			}
			else
			{	
				if (Validation::Minimum(3, Validation::SecureInput($search_treasurer_data->keyword)) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(200, Validation::SecureInput($search_treasurer_data->keyword)) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci maksimal terdapat 200 karakter'));
				}
				else
				{
					$keyword 		   = Validation::SecureInput($search_treasurer_data->keyword);

					$admin_model 	   = new app\http\models\Admin;

					$admin_model->connect();

					$admin_model->table = 'pemilik';

					$data_table			= $admin_model->searchMemberTreasurer($keyword);

					if (empty($data_table) == false OR is_null($data_table) == false)
					{
						Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Type' => 'success', 'result' => $data_table, 'keyword' => $search_treasurer_data->keyword));
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

	public function searchMemberAjax()
	{
		if (Ajax::Check())
		{
			$search_member_data = Ajax::AngularInput();

			if (Validation::isEmpty(Validation::SecureInput($search_member_data->keyword)))
			{
				Ajax::json_response(array('Tag' => '#6ae6abec7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci masih kosong'));
			}
			else
			{	
				if (Validation::Minimum(3, Validation::SecureInput($search_member_data->keyword)) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(200, Validation::SecureInput($search_member_data->keyword)) == false)
				{
					Ajax::json_response(array('Tag' => '#h3e55c4389', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kata kunci maksimal terdapat 200 karakter'));
				}
				else
				{
					$keyword 		   = Validation::SecureInput($search_member_data->keyword);

					$admin_model 	   = new app\http\models\Admin;

					$admin_model->connect();

					$admin_model->table = 'pemilik';
					
					if ($search_member_data->filtercarianggota == 'Sekretaris')
					{

						$data_table		   = $admin_model->searchMemberSecretary($keyword);

						if (empty($data_table) == false OR is_null($data_table) == false)
						{
							Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Type' => 'success', 'result' => $data_table, 'keyword' => $search_member_data->keyword, 'filtercarianggota' => $search_member_data->filtercarianggota));
						}
						else
						{
							Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Type' => 'no_result'));
						}
					}
					else
					{
						$data_table		   = $admin_model->searchMemberTreasurer($keyword);

						if (empty($data_table) == false OR is_null($data_table) == false)
						{
							Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Type' => 'success', 'result' => $data_table, 'keyword' => $search_member_data->keyword, 'filtercarianggota' => $search_member_data->filtercarianggota));
						}
						else
						{
							Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Type' => 'no_result'));
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
}