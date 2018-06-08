<?php

use Flare\Network\Http\Controller;

use Flare\Components\Environment;

use Flare\Network\Http\Ajax;

use Flare\Components\Validation;

class Treasurer extends Controller
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
		if (isset($_GET['treasurer_id']) AND empty($_GET['treasurer_id']) == false)
		{
			if (isset($_GET['setup_code']) AND empty($_GET['setup_code']) == false)
			{
				$treasurer_id_get = $_GET['treasurer_id'];

				$setup_code_get   = $_GET['setup_code'];

				$treasurer_model  = new app\http\models\Treasurer;

				$treasurer_model->connect();

				$treasurer_model->table = 'bendahara';

				if ($treasurer_model->CheckAccessSetupPage($treasurer_id_get, $setup_code_get))
				{
					$data = array
							(
								"URL"                => $this->getEnv('BASE_URL'),
								"ID_Bendahara"      => $treasurer_id_get
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

	public function setupAjax()
	{
		if (Ajax::check())
		{

			$setup_data                 = Ajax::AngularInput();

			$treasurer_model            = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table     = 'bendahara';

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

					if ($treasurer_model->where($setup_data->id)->update("Katasandi='$newpassword', Status_Akun='Terverifikasi'", "ID_Bendahara"))
					{
						$session         = new Flare\Network\Http\Session;

						$session->name   = "treasurer";

						$session->start();

						$session->give()->use($setup_data->id);

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Pengaturan katasandi berhasil'));

						$treasurer_model->disconnect();
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
	public function viewLogin()
	{
		$data = array
				(
					"URL" => $this->getEnv('BASE_URL')
				); 

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;		

		$session->start();

		if ($session->check('treasurer') == true)
		{
		    $treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			if ($treasurer_model->CheckID($session->value('treasurer')))
			{
				$treasurer_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/treasurer/dashboard/');
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('treasurer') == true)
		{
			$treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($treasurer_model->CheckID($encode->unprotected($cookie->value('treasurer'))))
			{
				$treasurer_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/treasurer/dashboard/');
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
			$treasurer_login_data      = Ajax::AngularInput();

			$treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			if (Validation::isEmpty($treasurer_login_data->email))
			{
				Ajax::json_response(array('Tag' => '#69e0bhf1c4', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email masih kosong'));
			}
			else if (Validation::isEmpty($treasurer_login_data->password))
			{
				Ajax::json_response(array('Tag' => '#20e29h12gd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi masih kosong'));
			}
			else
			{
				if (Validation::Regex("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/", $treasurer_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#2470g04118', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format email yang anda masukkan salah'));
				}
				else if (Validation::Minimum(15, $treasurer_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#5dh2gb9f7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email minimal terdapat 15 karakter'));
				}
				else if (Validation::Maximum(50, $treasurer_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#3g946e7b5d', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email maksimal terdapat 50 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z-0-9]*$/", $treasurer_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#d991d452df', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $treasurer_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#dgh9dcbeh9', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(25, $treasurer_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#c86b5df820', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi maksimal terdapat 25 karakter'));
				}
				else if ($treasurer_model->CheckEmail($treasurer_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#1e5h24ce21', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email yang anda masukkan salah'));

				}
				else if ($treasurer_model->CheckPassword($treasurer_model->get(null, 'Katasandi')->fetch(), $treasurer_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#1e87ab2a0a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi yang anda masukkan salah'));
				}
				else if ($treasurer_model->CheckAccess($treasurer_model->getId($treasurer_login_data->email)))
				{
					Ajax::json_response(array('Tag' => '#c4956ef651', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Akun yang anda gunakan belum melakukan konfigurasi. Silahkan melakukan konfigurasi dengan cara mengunjungi tautan yang dikirim ke email akun ini'));
				}
				else 
				{
					if ($treasurer_login_data->method == 'cookie')
					{
						$encode         = new Flare\Components\Encode;

						$encode->key    = $this->getEnv('KEY');

						$cookie         = new Flare\Network\Http\Cookie;

						$cookie->name   = 'treasurer';

						$cookie->give()->use($encode->protect($treasurer_model->getId($treasurer_login_data->email)));

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Type' => 'success'));

						$treasurer_model->disconnect();
					}
					else if ($treasurer_login_data->method == 'session')
					{
						$session = new Flare\Network\Http\Session;

						$session->name = "treasurer";

						$session->start();

						$session->give()->use($treasurer_model->getId($treasurer_login_data->email));

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Type' => 'success'));

						$treasurer_model->disconnect();
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

	public function viewDashboard()
	{

		$finance_model          = new app\http\models\Finance;

		$finance_model->connect();

		$finance_model->table   = 'statistik_keuangan';

		$limit_display      	= 5;

		$set_page           	= isset($_GET['page'])? (int)$_GET["page"]:1;
        
        $check_page         	= ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

		$total_rows         	= $finance_model->getTotalRows();

		$ceilIt             	= ceil($total_rows/$limit_display);

		$list_reports 			= $finance_model->getReports($check_page, $limit_display);

		$finance_model->disconnect();

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('treasurer') == true)
		{
			$treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			if ($treasurer_model->CheckID($session->value('treasurer')))
			{
				$data = array
						(
							"URL" => $this->getEnv('BASE_URL'),
							"Data_Bendahara"  => $treasurer_model->getTreasurerData($session->value('treasurer')),
							"List_Laporan"    => $list_reports,
							"Halaman_Paging"  => $set_page,
							"Total_Halaman"   => $ceilIt
						);

				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('treasurer') == true)
		{
			$treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($treasurer_model->CheckID($encode->unprotected($cookie->value('treasurer'))))
			{
				$data = array
						(
							"URL" => $this->getEnv('BASE_URL'),
							"Data_Bendahara"  => $treasurer_model->getTreasurerData($encode->unprotected($cookie->value('treasurer'))),
							"List_Laporan"    => $list_reports,
							"Halaman_Paging"  => $set_page,
							"Total_Halaman"   => $ceilIt
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

	public function processLogout()
	{
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;		

		$session->start();

		if ($session->check('treasurer') == true)
		{
			$treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			if ($treasurer_model->CheckID($session->value('treasurer')))
			{
				$treasurer_model->disconnect();

				$session->take('treasurer');

				self::redirect('http://localhost:8080/projekuas/treasurer/login');
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('treasurer') == true)
		{
			$treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($treasurer_model->CheckID($encode->unprotected($cookie->value('treasurer'))))
			{
				$treasurer_model->disconnect();

				$cookie->take('treasurer');

				self::redirect('http://localhost:8080/projekuas/treasurer/login');
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

	public function viewAccountSettings()
	{
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('treasurer') == true)
		{
			$treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			if ($treasurer_model->CheckID($session->value('treasurer')))
			{
				$data = array
						(
							"URL"   => $this->getEnv('BASE_URL'),
							"Data"  => $treasurer_model->getTreasurerData($session->value('treasurer'))
						);

				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('treasurer') == true)
		{
			$treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($treasurer_model->CheckID($encode->unprotected($cookie->value('treasurer'))))
			{
				$data = array
						(
							"URL"   => $this->getEnv('BASE_URL'),
							"Data"  => $treasurer_model->getTreasurerData($encode->unprotected($cookie->value('treasurer')))
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

			$treasurer_model = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table = 'bendahara';

			$system_profil_picture	= array
									  (
									  	'6gb12a88h51e7016b21g7371h.png',
									  	'd5991cc5b8f8dc8a4g26c335g.png'
									  );

			$get_profile_picture 	= $treasurer_model->where($data_update_account->id)->get('Foto_Bendahara', 'ID_Bendahara')->fetch(); 

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
						if ($treasurer_model->where($data_update_account->id)->update("Nama='$data_update_account->fullname', Tanggal_Lahir='$data_update_account->dateofbirth', Bulan_Lahir='$data_update_account->monthofbirth', Tahun_Lahir='$data_update_account->yearofbirth', Jenis_Kelamin='$data_update_account->gender', Alamat='$data_update_account->address', Ponsel='$data_update_account->phonenumber', Email='$data_update_account->email'", "ID_Bendahara"))
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
					else if ($data_update_account->gender != $data_update_account->gendernow AND in_array($get_profile_picture['Foto_Bendahara'], $system_profil_picture))
					{
						$treasurer_model = new app\http\models\Treasurer;

						$treasurer_model->connect();

						$treasurer_model->table = 'bendahara';

						$get_name_folder_now	= $treasurer_model->where($data_update_account->id)->get('Folder_Bendahara', 'ID_Bendahara')->fetch();

						$get_name_img_now		= $treasurer_model->where($data_update_account->id)->get('Foto_Bendahara', 'ID_Bendahara')->fetch();

						$img_now   = '../resources/assets/'.$get_name_folder_now['Folder_Bendahara'].'/'.$get_name_img_now['Foto_Bendahara'];

						$img_fname = $data_update_account->gender == 'Pria' ? '6gb12a88h51e7016b21g7371h.png' : 'd5991cc5b8f8dc8a4g26c335g.png'; 

						$from      = $data_update_account->gender == 'Pria' ? '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/6gb12a88h51e7016b21g7371h.png' : '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/d5991cc5b8f8dc8a4g26c335g.png';

						if (unlink($img_now))
						{
							if (copy($from, '../resources/assets/'.$get_name_folder_now['Folder_Bendahara'].'/'.$img_fname))
							{
								if ($treasurer_model->where($data_update_account->id)->update("Foto_Bendahara='$img_fname' , Nama='$data_update_account->fullname', Tanggal_Lahir='$data_update_account->dateofbirth', Bulan_Lahir='$data_update_account->monthofbirth', Tahun_Lahir='$data_update_account->yearofbirth', Jenis_Kelamin='$data_update_account->gender', Alamat='$data_update_account->address', Ponsel='$data_update_account->phonenumber', Email='$data_update_account->email'", "ID_Bendahara"))
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
					else if ($data_update_account->gender != $data_update_account->gendernow AND in_array($get_profile_picture['Foto_Bendahara'], $system_profil_picture) == false)
					{
						if ($treasurer_model->where($data_update_account->id)->update("Nama='$data_update_account->fullname', Tanggal_Lahir='$data_update_account->dateofbirth', Bulan_Lahir='$data_update_account->monthofbirth', Tahun_Lahir='$data_update_account->yearofbirth', Jenis_Kelamin='$data_update_account->gender', Alamat='$data_update_account->address', Ponsel='$data_update_account->phonenumber', Email='$data_update_account->email'", "ID_Bendahara"))
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
										$treasurer_model = new app\http\models\Treasurer;

										$treasurer_model->connect();

										$treasurer_model->table = 'bendahara';

										$get_name_folder_now	= $treasurer_model->where($id)->get('Folder_Bendahara', 'ID_Bendahara')->fetch();

										$get_folder_now 		= '../resources/assets/'.$get_name_folder_now['Folder_Bendahara'].'/';

										$this->deleteFolderNow($get_folder_now);

										if ($treasurer_model->where($id)->update("Folder_Bendahara='$new_folder', Foto_Bendahara='$profil_picture_name', Nama='$fullname', Tanggal_Lahir='$dateofbirth', Bulan_Lahir='$monthofbirth', Tahun_Lahir='$yearofbirth', Jenis_Kelamin='$gender', Alamat='$address', Ponsel='$phonenumber', Email='$email'", "ID_Bendahara"))
										{
											$dataform = array
														(
										   	   				'fullname' 		=> $fullname,
										   	   				'dateofbirth'	=> $dateofbirth,
										   	   				'monthofbirth'	=> $monthofbirth,
										       				'yearofbirth'	=> $yearofbirth,
										       				'gender'	    => $gender,
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

			$treasurer_model	   = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table = 'bendahara';

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
				else if ($treasurer_model->CheckPassword($treasurer_model->get(null, 'Katasandi')->fetch(), $change_password_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#1e87ab2a0a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi lama yang anda masukkan salah'));
				}
				else
				{

					$hash_new_password = password_hash($change_password_data->newpassword, PASSWORD_DEFAULT);

					if ($treasurer_model->where($change_password_data->id)->update("Katasandi='$hash_new_password'", "ID_Bendahara"))
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

	public function viewForgotPasswordPage()
	{
		$data = array
				(
					"URL" => $this->getEnv('BASE_URL')
				); 

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;		

		$session->start();

		if ($session->check('treasurer') == true)
		{
		    $treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			if ($treasurer_model->CheckID($session->value('treasurer')))
			{
				$treasurer_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/treasurer/dashboard/');
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('treasurer') == true)
		{
			$treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($treasurer_model->CheckID($encode->unprotected($cookie->value('treasurer'))))
			{
				$treasurer_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/treasurer/dashboard/');
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

	public function forgotPasswordAjax()
	{
		if (Ajax::Check())
		{
			$forgot_password_data  = Ajax::AngularInput();

			$treasurer_model	   = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table = 'bendahara';

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
				else if ($treasurer_model->CheckEmail($forgot_password_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#1e5h24ce21', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email yang anda masukkan salah'));

				}
				else
				{

					$treasurer_id     = $treasurer_model->where($forgot_password_data->email)->get('ID_Bendahara', 'Email')->fetch();

					if ($treasurer_model->CheckAccess($treasurer_id['ID_Bendahara']) == false)
					{

						$name 			  = $treasurer_model->where($forgot_password_data->email)->get('Nama', 'Email')->fetch();
					
						$reset_code       = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,50);

					
						$msg              = "<html><head><style>a {text-decoration: none;color: blue;}</style></head><body>Yth, <strong>".$name['Nama']."</strong>. <br/><br/> Anda baru saja meminta permohonan untuk mengatur ulang katasandi anda. Silahkan klik tautan yang ada dibawah ini untuk mengatur ulang katasandi anda. <br/><br/> <a href='".$this->getEnv('BASE_URL')."reset_password_treasurer.php?treasurer_id=".$treasurer_id['ID_Bendahara']."&reset_code=".$reset_code."'>".$this->getEnv('BASE_URL')."reset_password_treasurer.php?treasurer_id=".$treasurer_id['ID_Bendahara']."&reset_code=".$reset_code."</a> <br/><br/> Jika anda merasa tidak pernah merasa untuk meminta mengatur ulang katasandi silahkan abaikan email ini, terima kasih.</body></html>";

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
							if ($treasurer_model->where($treasurer_id['ID_Bendahara'])->update("Kode_Atur_Ulang_Katasandi='$reset_code', Akses_Atur_Ulang_Katasandi='Aktif'", "ID_Bendahara"))
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

	public function viewResetPasswordPage()
	{

		if (isset($_GET['treasurer_id']) OR empty($_GET['treasurer_id']) == false)
		{
			if (isset($_GET['reset_code']) OR empty($_GET['reset_code']) == false)
			{
				$treasurer_id_get  = $_GET['treasurer_id'];

				$reset_code_get	   = $_GET['reset_code'];

				$treasurer_model   = new app\http\models\Treasurer;

				$treasurer_model->connect();

				$treasurer_model->table = 'bendahara';

				if ($treasurer_model->CheckAccess2($treasurer_id_get, $reset_code_get))
				{
					$data = array
							(
								'URL' => $this->getEnv('BASE_URL'),
								'ID_Bendahara'	=> $treasurer_id_get
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

			$treasurer_model            = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table     = 'bendahara';

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
				else
				{
					$newpassword = password_hash($reset_password_data->password, PASSWORD_DEFAULT);

					if ($treasurer_model->where($reset_password_data->id)->update("Katasandi='$newpassword', Kode_Atur_Ulang_Katasandi='Tidak Ada', Akses_Atur_Ulang_Katasandi='Tidak Aktif'", "ID_Bendahara"))
					{
						$session         = new Flare\Network\Http\Session;

						$session->name   = "treasurer";

						$session->start();

						$session->give()->use($reset_password_data->id);

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Pengaturan katasandi berhasil'));

						$treasurer_model->disconnect();
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

	public function viewManageReports()
	{
		$finance_model          = new app\http\models\Finance;

		$finance_model->connect();

		$finance_model->table   = 'statistik_keuangan';

		$limit_display      	= 5;

		$set_page           	= isset($_GET['page'])? (int)$_GET["page"]:1;
        
        $check_page         	= ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

		$total_rows         	= $finance_model->getTotalRows();

		$ceilIt             	= ceil($total_rows/$limit_display);

		$list_reports 			= $finance_model->getReports($check_page, $limit_display);

		$finance_model->disconnect();

		$data = array
				(
					"URL"             => $this->getEnv('BASE_URL'),
					"List_Laporan"    => $list_reports,
					"Halaman_Paging"  => $set_page,
					"Total_Halaman"   => $ceilIt
				); 

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('treasurer') == true)
		{
			$treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			if ($treasurer_model->CheckID($session->value('treasurer')))
			{
				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('treasurer') == true)
		{
			$treasurer_model           = new app\http\models\Treasurer;

			$treasurer_model->connect();

			$treasurer_model->table    = 'bendahara';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($treasurer_model->CheckID($encode->unprotected($cookie->value('treasurer'))))
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

	public function addReportsAjax()
	{
		if (Ajax::check())
		{
			$add_reports_data  = Ajax::AngularInput();

			$income			   = array_key_exists('income', $add_reports_data) ? $add_reports_data->income : 0;

			$spending		   = array_key_exists('spending', $add_reports_data) ? $add_reports_data->spending : 0;

			if ($income == 0 AND $spending == 0)
			{
				Ajax::json_response(array('Tag' => '#7ea1bh18a3', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Dana masuk atau Dana keluar setidaknya diantara form tersebut harus diisi atau nilainya tidak boleh 0'));
			}
			else if (Validation::isEmpty(Validation::SecureInput($add_reports_data->information)))
			{
				Ajax::json_response(array('Tag' => '#c174c2e630', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Keterangan masih kosong'));
			}
			else
			{
				if (Validation::Minimum(10, Validation::SecureInput($add_reports_data->information)) == false)
				{
					Ajax::json_response(array('Tag' => '#f23830d6ae', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Keterangan minimal terdapat 10 karakter'));
				}
				else if (Validation::Maximum(1500, $add_reports_data->information) == false)
				{
					Ajax::json_response(array('Tag' => '#166g269bae', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Keterangan maksimal terdapat 1500 karakter'));
				}
				else
				{
					$information   = Validation::SecureInput($add_reports_data->information);

					$finance_model = new app\http\models\Finance;

					$finance_model->connect();

					$finance_model->table = 'statistik_keuangan';

					$encode         = new Flare\Components\Encode;

					$encode->key    = $this->getEnv('KEY');

					$cookie         = new Flare\Network\Http\Cookie;

					$session 		= new Flare\Network\Http\Session;

					$session->start();

					$report_id    		= substr(str_shuffle('0123456789012345678901234567890123456789'),0,40);

					$treasurer_id   = $session->check('treasurer') ? $session->value('treasurer') : $encode->unprotected($cookie->value('treasurer'));

					$treasurer_model = new app\http\models\Treasurer;

					$treasurer_model->connect();

					$treasurer_model->table = 'bendahara';

					$treasurer_name = $treasurer_model->where($treasurer_id)->get('Nama', 'ID_Bendahara')->fetch();

					date_default_timezone_set('Asia/Hong_Kong');

					$date           = date("Y-m-d H:i:s");

					if ($finance_model->insert("ID_Laporan,Waktu,Dana_Masuk,Dana_Keluar,Keterangan,ID_Bendahara,Nama_Bendahara", "'$report_id','$date','$income','$spending','$information','$treasurer_id','".$treasurer_name['Nama']."'")) 
					{
						$finance_model->disconnect();

						Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Laporan berhasil ditambahkan'));
					}
					else
					{
						Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penambahan laporan tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
					}
				}
			}
		}
	}

	public function deleteReportAjax()
	{
		if (Ajax::Check())
		{
			$delete_report_data = Ajax::AngularInput();

			if (Validation::isEmpty($delete_report_data->report_id) == false)
			{
				$finance_model      = new app\http\models\Finance;

				$finance_model->connect();

				$finance_model->table  = 'statistik_keuangan';

				if ($finance_model->CheckID($delete_report_data->report_id))
				{
					if ($finance_model->where($delete_report_data->report_id)->delete('ID_Laporan'))
					{
						Ajax::json_response(array('Tag' => '#ba434e5b80', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Laporan berhasil dihapus'));
					}
					else
					{
						Ajax::json_response(array('Tag' => '#eca4ddce4b', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan laporan tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
					}
				}
				else
				{
					Ajax::json_response(array('Tag' => '#e1gbed84fg', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan laporan tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
				}

				$finance_model->disconnect();
			}
			else
			{
				Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan penghapusan laporan tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function searchReportAjax()
	{
		if (Ajax::check())
		{
			$search_report_data = Ajax::AngularInput();

			if (Validation::isEmpty($search_report_data->month))
			{
				Ajax::json_response(array('Tag' => '#6ae6abec7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Bulan masih kosong'));
			}
			else if (Validation::isEmpty($search_report_data->year))
			{
				Ajax::json_response(array('Tag' => '#daefgheefa', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tahun masih kosong'));
			}
			else
			{	
			
				$finance_model 	   = new app\http\models\Finance;

				$finance_model->connect();

				$finance_model->table = 'kategori_buku';

				$data_table		   = $finance_model->searchReport($search_report_data->month, $search_report_data->year);

				if (empty($data_table) == false OR is_null($data_table) == false)
				{
					$monthObj     = DateTime::createFromFormat('!m', $search_report_data->month);
					
					$monthName    = $monthObj->format('F');

					$monthListen  = array
									(
										'January' 	=> 'Januari',
										'February'	=> 'Februari',
										'March'		=> 'Maret',
										'April'		=> 'April',
										'May'		=> 'Mei',
										'June'		=> 'Juni',
										'July'		=> 'Juli',
										'August'	=> 'Agustus',
										'September'	=> 'September',
										'October'	=> 'Oktober',
										'November'	=> 'November',
										'December'	=> 'Desember' 
									);

					Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Type' => 'success', 'result' => $data_table, 'resultInfo' => 'Hasil untuk laporan pada bulan '.str_replace(array_keys($monthListen), array_values($monthListen), $monthName).' tahun '.$search_report_data->year.''));
				}
				else
				{
					$monthObj     = DateTime::createFromFormat('!m', $search_report_data->month);
					
					$monthName    = $monthObj->format('F');

					$monthListen  = array
									(
										'January' 	=> 'Januari',
										'February'	=> 'Februari',
										'March'		=> 'Maret',
										'April'		=> 'April',
										'May'		=> 'Mei',
										'June'		=> 'Juni',
										'July'		=> 'Juli',
										'August'	=> 'Agustus',
										'September'	=> 'September',
										'October'	=> 'Oktober',
										'November'	=> 'November',
										'December'	=> 'Desember' 
									);

					Ajax::json_response(array('Tag' => '#32fa4aedf0', 'Type' => 'no_result', 'result' => 'Tidak ada hasil untuk laporan pada bulan '.str_replace(array_keys($monthListen), array_values($monthListen), $monthName).' tahun '.$search_report_data->year.''));
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewEditReport()
	{
		if (isset($_GET['report_id']))
		{
			$session = new Flare\Network\Http\Session;

			$cookie  = new Flare\Network\Http\Cookie;

			$session->start();

			if ($session->check('treasurer') == true)
			{
				$treasurer_model           = new app\http\models\Treasurer;

				$treasurer_model->connect();

				$treasurer_model->table    = 'bendahara';

				if ($treasurer_model->CheckID($session->value('treasurer')))
				{
					$report_id        = $_GET['report_id'];

					$finance_model    = new app\http\models\Finance;

					$finance_model->connect();

					$finance_model->table  = 'statistik_keuangan';

					if ($finance_model->CheckID($report_id))
					{
						$data = array
								(
									"URL"    => $this->getEnv('BASE_URL'),
									"Data_Bendahara"  => $treasurer_model->getTreasurerData($session->value('treasurer')),
									"Data"   => $finance_model->getEditData($report_id)
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
			else if ($cookie->check('treasurer') == true)
			{
				$treasurer_model           = new app\http\models\Treasurer;

				$treasurer_model->connect();

				$treasurer_model->table    = 'bendahara';

				$encode         = new Flare\Components\Encode;

				$encode->key    = $this->getEnv('KEY');

				if ($treasurer_model->CheckID($encode->unprotected($cookie->value('treasurer'))))
				{
					$report_id        = $_GET['report_id'];

					$finance_model    = new app\http\models\Finance;

					$finance_model->connect();

					$finance_model->table  = 'statistik_keuangan';

					if ($finance_model->CheckID($report_id))
					{
						$data = array
								(
									"URL"    => $this->getEnv('BASE_URL'),
									"Data_Bendahara"  => $treasurer_model->getTreasurerData($encode->unprotected($cookie->value('treasurer'))),
									"Data"   => $finance_model->getEditData($report_id)
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

	public function editReportAjax()
	{
		if (Ajax::check())
		{
			$edit_reports_data  = Ajax::AngularInput();

			$income			   = array_key_exists('income', $edit_reports_data) ? $edit_reports_data->income : 0;

			$spending		   = array_key_exists('spending', $edit_reports_data) ? $edit_reports_data->spending : 0;

			if ($income == 0 AND $spending == 0)
			{
				Ajax::json_response(array('Tag' => '#7ea1bh18a3', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Dana masuk atau Dana keluar setidaknya diantara form tersebut harus diisi atau nilainya tidak boleh 0'));
			}
			else if (Validation::isEmpty(Validation::SecureInput($edit_reports_data->information)))
			{
				Ajax::json_response(array('Tag' => '#c174c2e630', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Keterangan masih kosong'));
			}
			else
			{
				if (Validation::Minimum(10, Validation::SecureInput($edit_reports_data->information)) == false)
				{
					Ajax::json_response(array('Tag' => '#f23830d6ae', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Keterangan minimal terdapat 10 karakter'));
				}
				else if (Validation::Maximum(1500, $edit_reports_data->information) == false)
				{
					Ajax::json_response(array('Tag' => '#166g269bae', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Keterangan maksimal terdapat 1500 karakter'));
				}
				else
				{
					$session = new Flare\Network\Http\Session;

					$cookie  = new Flare\Network\Http\Cookie;

					$session->start();

					$finance_model          = new app\http\models\Finance;

					$finance_model->connect();

					$finance_model->table   = 'statistik_keuangan';

					$treasurer_id   = $session->check('treasurer') ? $session->value('treasurer') : $encode->unprotected($cookie->value('treasurer'));

					$treasurer_model = new app\http\models\Treasurer;

					$treasurer_model->connect();

					$treasurer_model->table = 'bendahara';

					$treasurer_name = $treasurer_model->where($treasurer_id)->get('Nama', 'ID_Bendahara')->fetch();

					$date           = date("Y-m-d H:i:s");

					if ($finance_model->where($edit_reports_data->id)->update("Waktu='$date', Dana_Masuk='$edit_reports_data->income', Dana_Keluar='$edit_reports_data->spending', ID_Bendahara='$treasurer_id', Nama_Bendahara='".$treasurer_name['Nama']."'", "ID_Laporan"))
					{
						$finance_model->disconnect();

						Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Laporan berhasil diedit', 'new_income' => $edit_reports_data->income, 'new_spending' => $edit_reports_data->spending, 'new_information' => $edit_reports_data->information));
					}
					else
					{
						Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pengeditan laporan tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
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

?>