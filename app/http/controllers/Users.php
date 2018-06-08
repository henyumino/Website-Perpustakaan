<?php

use Flare\Network\Http\Controller;

use Flare\Components\Environment;

use Flare\Network\Http\Ajax;

use Flare\Components\Validation;

class Users extends Controller
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

	public function viewRegis()
	{
		$data = array
				(
					"URL" => $this->getEnv('BASE_URL')
				); 
						
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;		

		$session->start();

		if ($session->check('users') == true)
		{
		    $users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{
				$users_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/dashboard/');
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{
				$users_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/dashboard/');
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

	public function regisAjax()
	{
		if (Ajax::check())
		{
			$register_data      = Ajax::AngularInput();

			$users_model        = new app\http\models\Users;

			$users_model->connect();

			$users_model->table = 'pengguna'; 

			if (Validation::isEmpty($register_data->firstname))
			{
				Ajax::json_response(array('Tag' => '#b7h480f2cg', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama depan masih kosong'));
			}
			else if (Validation::isEmpty($register_data->lastname))
			{
				Ajax::json_response(array('Tag' => '#ehd7h053b9', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama belakang masih kosong'));
			}
			else if (Validation::isEmpty($register_data->dateofbirth))
			{
				Ajax::json_response(array('Tag' => '#h2c40gh3e3', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tangal lahir masih kosong'));
			}
			else if (Validation::isEmpty($register_data->monthofbirth))
			{
				Ajax::json_response(array('Tag' => '#6820b4ad82', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Bulan lahir masih kosong'));	
			}
			else if (Validation::isEmpty($register_data->yearofbirth))
			{
				Ajax::json_response(array('Tag' => '#f2ce01g2e4', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tahun lahir masih kosong'));	
			}
			else if (Validation::isEmpty($register_data->gender))
			{
				Ajax::json_response(array('Tag' => '#9dff8047hh', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jenis kelamin masih kosong'));
			}
			else if (Validation::isEmpty($register_data->address))
			{
				Ajax::json_response(array('Tag' => '#c9c28hhba5', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat masih kosong'));
			}
			else if (Validation::isEmpty($register_data->phonenumber))
			{
				Ajax::json_response(array('Tag' => '#fg9037c2dd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel masih kosong'));
			}
			else if (Validation::isEmpty($register_data->email))
			{
				Ajax::json_response(array('Tag' => '#1ah73hh02c', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email masih kosong'));
			}
			else if (Validation::isEmpty($register_data->password))
			{
				Ajax::json_response(array('Tag' => '#638a92829d', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi masih kosong'));
			}
			else if (Validation::isEmpty($register_data->confirmpassword))
			{
				Ajax::json_response(array('Tag' => '#cg334048ef', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Konfirmasi katasandi masih kosong'));
			}
			else 
			{
				if (Validation::Regex("/^[a-zA-Z ]*$/", $register_data->firstname) == false)
				{
					Ajax::json_response(array('Tag' => '#efg6cagcac', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama depan hanya boleh berisi huruf dan spasi'));
				}
				else if (Validation::Minimum(3, $register_data->firstname) == false)
				{
					Ajax::json_response(array('Tag' => '#f27e8gag37', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama depan minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(25, $register_data->firstname) == false)
				{
					Ajax::json_response(array('Tag' => '#70485964b6', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama depan maksimal terdapat 25 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z ]*$/", $register_data->lastname) == false) 
				{
					Ajax::json_response(array('Tag' => '#7c540886g8', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama belakang hanya boleh berisi huruf dan spasi'));
				}
				else if (Validation::Minimum(3, $register_data->lastname) == false)
				{
					Ajax::json_response(array('Tag' => '#b0f6d115b1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama belakang minimal terdapat 3 karakter'));
				}
				else if (Validation::Maximum(25, $register_data->lastname) == false)
				{
					Ajax::json_response(array('Tag' => '#790fb3461f', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nama belakang maksimal terdapat 25 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z-0-9 ]*$/", $register_data->address) == false) 
				{
					Ajax::json_response(array('Tag' => '#e7fdg3594b', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat hanya boleh berisi huruf, angka dan spasi'));
				}
				else if (Validation::Minimum(10, $register_data->address) == false)
				{
					Ajax::json_response(array('Tag' => '#fcg1a40b1g', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat minimal terdapat 10 karakter'));
				}
				else if (Validation::Maximum(50, $register_data->address) == false)
				{
					Ajax::json_response(array('Tag' => '#688543ehh9', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Alamat maksimal terdapat 50 karakter'));
				}
				else if (Validation::Regex("/08?[0-9]{10}$/", $register_data->phonenumber) == false)
				{
					Ajax::json_response(array('Tag' => '#52gh202e44', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format nomor ponsel yang anda masukkan salah'));
				}
				else if (Validation::Minimum(12, $register_data->phonenumber) == false)
				{
					Ajax::json_response(array('Tag' => '#d197e1g4hb', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel harus terdiri dari 12 digit'));
				}
				else if (Validation::Maximum(12, $register_data->phonenumber) == false)
				{
					Ajax::json_response(array('Tag' => '#f073b40c38', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Nomor ponsel harus terdiri dari 12 digit'));
				}
				else if (Validation::Regex("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/", $register_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#2ebc6gcg7b', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format email yang anda masukkan salah'));
				}
				else if (Validation::Minimum(15, $register_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#f220db1dg6', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email minimal terdapat 15 karakter'));
				}
				else if (Validation::Maximum(50, $register_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#07ed54be2c', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email maksimal terdapat 50 karakter'));
				}
				else if ($users_model->CheckEmail($register_data->email))
				{
					Ajax::json_response(array('Tag' => '#05fdg72846', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email yang anda gunakan sudah terdaftar'));
				}
				else if (Validation::Regex("/^[a-zA-Z-0-9]*$/", $register_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#bg53799h97', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $register_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#5b1ahg6ec0', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(25, $register_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#f98662e1c2', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi maksimal terdapat 25 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z-0-9]*$/", $register_data->confirmpassword) == false)
				{
					Ajax::json_response(array('Tag' => '#af900d742a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Konfirmasi katasandi hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $register_data->confirmpassword) == false)
				{
					Ajax::json_response(array('Tag' => '#eb9gd2685f', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Konfirmasi katasandi minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(25, $register_data->confirmpassword) == false)
				{
					Ajax::json_response(array('Tag' => '#aa5772b2hd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Konfirmasi katasandi maksimal terdapat 25 karakter'));
				}
				else if ($register_data->password != $register_data->confirmpassword)
				{
					Ajax::json_response(array('Tag' => '7edca7ac99', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi berbeda dengan konfirmasi katasandi'));
				}
				else
				{
					if ($register_data->gender == 'Pria' AND $register_data->gender != 'Wanita' OR $register_data->gender != 'Pria' AND $register_data->gender == 'Wanita')
					{

						$newpassword         = password_hash($register_data->password, PASSWORD_DEFAULT);

						$users_id         = substr(str_shuffle('0123456789012345678901234567890123456789'),0,40);

						$users_folder     = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,40);

						$users_img_fname  = $register_data->gender == 'Pria' ? '6gb12a88h51e7016b21g7371h.png' : 'd5991cc5b8f8dc8a4g26c335g.png';

						$users_img_path   = $register_data->gender == 'Pria' ? '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/6gb12a88h51e7016b21g7371h.png' : '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/d5991cc5b8f8dc8a4g26c335g.png';

						$verif_code       = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,50);

						$Name             = $register_data->firstname." ".$register_data->lastname;

						$msg              = "<html><head><style>a {text-decoration: none;color: blue;}</style></head><body>Yth, <strong>$Name</strong>. <br/><br/> Anda baru saja mendaftar di situs <a href='".$this->getEnv('BASE_URL')."'>Perpustakaan Nusantara</a> namun anda tidak bisa mengakses akun selagi anda belum melakukan verifikasi terhadap akun anda. Silahkan klik tautan yang ada dibawah ini untuk melakukan verifikasi terhadap akun anda. <br/><br/> <a href='".$this->getEnv('BASE_URL')."verif.php?users_id=".$users_id."&verif_code=".$verif_code."'>".$this->getEnv('BASE_URL')."verif.php?users_id=".$users_id."&verif_code=".$verif_code."</a> <br/><br/> Jika anda merasa tidak pernah mendaftar di situs kami silahkan abaikan email ini, terima kasih.</body></html>";

						$mailer = new Flare\Components\Mail;

						$mailer->timezone     	=  'Asia/Makassar';

						$mailer->senderName   	=  'Perpusnusantara';

						$mailer->thesubject   	=  'Konfirmasi Email Anda';

						$mailer->receiptEmail 	=  $register_data->email;

						$mailer->receiptName  	=  $Name;

						$mailer->senderEmail    =  $this->getEnv('EMAIL_ADDRESS');

						$mailer->senderPassword =  $this->getEnv('EMAIL_PASSWORD');

						$mailer->host_mail  	=  'smtp.gmail.com';

						$mailer->message     	=  $msg;

						if ($mailer->Send())
						{
							if ($users_model->insert("ID_Pengguna,Folder_Pengguna,Foto_Pengguna,Nama,Tanggal_Lahir,Bulan_Lahir,Tahun_Lahir,Jenis_Kelamin,Alamat,Ponsel,Email,Katasandi,Kode_Verifikasi_Email,Kode_Atur_Ulang_Katasandi,Akses_Atur_Ulang_Katasandi,Status_Akun", "'$users_id','$users_folder','$users_img_fname','$Name','$register_data->dateofbirth','$register_data->monthofbirth','$register_data->yearofbirth','$register_data->gender','$register_data->address','$register_data->phonenumber','$register_data->email','$newpassword','$verif_code','Tidak Ada','Tidak Aktif','Belum Terverifikasi'"))
							{
								if (!file_exists("../resources/assets/".$users_folder."/".$users_img_fname) OR !file_exists("../resources/assets/".$users_folder."/index.php"))
								{
									mkdir("../resources/assets/".$users_folder, 0777, true);

									if (copy($users_img_path, "../resources/assets/".$users_folder."/".$users_img_fname))
									{
										if (copy('../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/index.php', '../resources/assets/'.$users_folder.'/index.php'))
										{
											$users_model->disconnect();

											Ajax::json_response(array('Tag' => '#839bd7b1bh', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Pendaftaran anda telah berhasil dilakukan. Namun anda perlu melakukan verifikasi terhadap akun anda silahkan periksa email anda karena kami sudah mengirimkan tautan agar anda bisa melakukan verifikasi.'));	
										}
										else
										{
											Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pendaftaran anda tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.'));	
										}
									}
									else
									{
										Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pendaftaran anda tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.'));			
									}
								}
								else
								{
									Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pendaftaran anda tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.'));
								}
							}
							else
							{
								Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pendaftaran anda tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.'));
							}
						}
						else
						{
							Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan pendaftaran anda tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.'));
						}
					}
					else
					{
						Ajax::json_response(array('Tag' => '#99f340c1f4', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Jenis kelamin masih kosong'));
					}
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewVerifPage()
	{
		if (isset($_GET['users_id']) AND empty($_GET['users_id']) == false)
		{
			if (isset($_GET['verif_code']) AND empty($_GET['verif_code']) == false)
			{
				$users_id_get 	  = $_GET['users_id'];

				$verif_code_get   = $_GET['verif_code'];

				$users_model	  = new app\http\models\Users;

				$users_model->connect();

				$users_model->table = 'pengguna';

				if ($users_model->CheckAccessVerifPage($users_id_get, $verif_code_get))
				{
					if ($users_model->where($users_id_get)->update("Status_Akun='Terverifikasi'", "ID_Pengguna"))
					{
						$data = array
						(
							"URL"  => $this->getEnv('BASE_URL')
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

	public function viewLogin()
	{
		$data = array
				(
					"URL" => $this->getEnv('BASE_URL')
				); 

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;		

		$session->start();

		if ($session->check('users') == true)
		{
		    $users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{
				$users_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/dashboard/');
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{
				$users_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/dashboard/');
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
			$users_login_data      = Ajax::AngularInput();

			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if (Validation::isEmpty($users_login_data->email))
			{
				Ajax::json_response(array('Tag' => '#69e0bhf1c4', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email masih kosong'));
			}
			else if (Validation::isEmpty($users_login_data->password))
			{
				Ajax::json_response(array('Tag' => '#20e29h12gd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi masih kosong'));
			}
			else
			{
				if (Validation::Regex("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/", $users_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#2470g04118', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Format email yang anda masukkan salah'));
				}
				else if (Validation::Minimum(15, $users_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#5dh2gb9f7e', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email minimal terdapat 15 karakter'));
				}
				else if (Validation::Maximum(50, $users_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#3g946e7b5d', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email maksimal terdapat 50 karakter'));
				}
				else if (Validation::Regex("/^[a-zA-Z-0-9]*$/", $users_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#d991d452df', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi hanya boleh berisi huruf dan angka'));
				}
				else if (Validation::Minimum(5, $users_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#dgh9dcbeh9', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi minimal terdapat 5 karakter'));
				}
				else if (Validation::Maximum(25, $users_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#c86b5df820', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi maksimal terdapat 25 karakter'));
				}
				else if ($users_model->CheckEmail($users_login_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#1e5h24ce21', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email yang anda masukkan salah'));

				}
				else if ($users_model->CheckPassword($users_model->get(null, 'Katasandi')->fetch(), $users_login_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#1e87ab2a0a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi yang anda masukkan salah'));
				}
				else if ($users_model->CheckAccess($users_model->getId($users_login_data->email)))
				{
					Ajax::json_response(array('Tag' => '#c4956ef651', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Akun yang anda gunakan belum melakukan verifikasi email. Silahkan melakukan verifikasi email dengan cara mengunjungi tautan yang dikirim ke email akun ini'));
				}
				else 
				{
					if ($users_login_data->method == 'cookie')
					{
						$encode         = new Flare\Components\Encode;

						$encode->key    = $this->getEnv('KEY');

						$cookie         = new Flare\Network\Http\Cookie;

						$cookie->name   = 'users';

						$cookie->give()->use($encode->protect($users_model->getId($users_login_data->email)));

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Type' => 'success'));

						$users_model->disconnect();
					}
					else if ($users_login_data->method == 'session')
					{
						$session = new Flare\Network\Http\Session;

						$session->name = "users";

						$session->start();

						$session->give()->use($users_model->getId($users_login_data->email));

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Type' => 'success'));

						$users_model->disconnect();
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

		$book_model 		= new app\http\models\Book;

		$book_model->connect();

		$book_model->table  = 'buku';

		$limit_display      = 10;

		$set_page           = isset($_GET['page'])? (int)$_GET["page"]:1;
        
        $check_page         = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

		$total_rows         = $book_model->getBookRows();

		$ceilIt             = ceil($total_rows/$limit_display);

		$list_book 			= $book_model->getBook($check_page, $limit_display); 

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{
				$data = array
						(
							"URL" 			  => $this->getEnv('BASE_URL'),
							"Data_Pengguna"   => $users_model->getUsersData($session->value('users')),
							"Buku"            => $list_book,
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
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{
				$data = array
						(
							"URL" 			  => $this->getEnv('BASE_URL'),
							"Data_Pengguna"   => $users_model->getUsersData($encode->unprotected($cookie->value('users'))),
							"Buku"            => $list_book,
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

		if ($session->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{
				$users_model->disconnect();

				$session->take('users');

				self::redirect('http://localhost:8080/projekuas/login/');
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{
				$users_model->disconnect();

				$cookie->take('users');

				self::redirect('http://localhost:8080/projekuas/login/');
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

	public function viewForgotPasswordPage()
	{
		$data = array
				(
					"URL" => $this->getEnv('BASE_URL')
				); 

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;		

		$session->start();

		if ($session->check('users') == true)
		{
		    $users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{
				$users_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/dashboard/');
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{
				$users_model->disconnect();

				self::redirect('http://localhost:8080/projekuas/dashboard/');
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

			$users_model	   = new app\http\models\Users;

			$users_model->connect();

			$users_model->table = 'pengguna';

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
				else if ($users_model->CheckEmail($forgot_password_data->email) == false)
				{
					Ajax::json_response(array('Tag' => '#1e5h24ce21', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Email yang anda masukkan salah'));

				}
				else
				{

					$users_id     = $users_model->where($forgot_password_data->email)->get('ID_Pengguna', 'Email')->fetch();

					if ($users_model->CheckAccess($users_id['ID_Pengguna']) == false)
					{

						$name 			  = $users_model->where($forgot_password_data->email)->get('Nama', 'Email')->fetch();
					
						$reset_code       = substr(str_shuffle('abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789abcdefgh0123456789'),0,50);

					
						$msg              = "<html><head><style>a {text-decoration: none;color: blue;}</style></head><body>Yth, <strong>".$name['Nama']."</strong>. <br/><br/> Anda baru saja meminta permohonan untuk mengatur ulang katasandi anda. Silahkan klik tautan yang ada dibawah ini untuk mengatur ulang katasandi anda. <br/><br/> <a href='".$this->getEnv('BASE_URL')."reset_password_users.php?users_id=".$users_id['ID_Pengguna']."&reset_code=".$reset_code."'>".$this->getEnv('BASE_URL')."reset_password_users.php?users_id=".$users_id['ID_Pengguna']."&reset_code=".$reset_code."</a> <br/><br/> Jika anda merasa tidak pernah merasa untuk meminta mengatur ulang katasandi silahkan abaikan email ini, terima kasih.</body></html>";

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
							if ($users_model->where($users_id['ID_Pengguna'])->update("Kode_Atur_Ulang_Katasandi='$reset_code', Akses_Atur_Ulang_Katasandi='Aktif'", "ID_Pengguna"))
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
						Ajax::json_response(array('Tag' => '#730a403edd', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tidak bisa melakukan permohonan katasandi hal ini dikarenakan akun ini belum melakukan terverifikasi. Silahkan periksa email anda karena kami sudah mengirimkan tautan untuk melakuakn verifikasi akun anda.'));
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
		if (isset($_GET['users_id']) OR empty($_GET['users_id']) == false)
		{
			if (isset($_GET['reset_code']) OR empty($_GET['reset_code']) == false)
			{
				$users_id_get  	= $_GET['users_id'];

				$reset_code_get	= $_GET['reset_code'];

				$users_model   	= new app\http\models\Users;

				$users_model->connect();

				$users_model->table = 'pengguna';

				if ($users_model->CheckAccess2($users_id_get, $reset_code_get))
				{
					$data = array
							(
								'URL' => $this->getEnv('BASE_URL'),
								'ID_Pengguna'	=> $users_id_get
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

			$users_model            	= new app\http\models\Users;

			$users_model->connect();

			$users_model->table     	= 'pengguna';

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

					if ($users_model->where($reset_password_data->id)->update("Katasandi='$newpassword', Kode_Atur_Ulang_Katasandi='Tidak Ada', Akses_Atur_Ulang_Katasandi='Tidak Aktif'", "ID_Pengguna"))
					{
						$session         = new Flare\Network\Http\Session;

						$session->name   = "users";

						$session->start();

						$session->give()->use($reset_password_data->id);

						Ajax::json_response(array('Tag' => '#1cc795c5d7', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Pengaturan katasandi berhasil'));

						$users_model->disconnect();
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

	public function viewAccountSettings()
	{
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{
				$data = array
						(
							"URL"   => $this->getEnv('BASE_URL'),
							"Data"  => $users_model->getUsersData($session->value('users'))
						);

				$this->parts($data);
			}
			else
			{
				$this->error_404();
			}
		}
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{
				$data = array
						(
							"URL"   => $this->getEnv('BASE_URL'),
							"Data"  => $users_model->getUsersData($encode->unprotected($cookie->value('users')))
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

			$users_model		 = new app\http\models\Users;

			$users_model->connect();

			$users_model->table = 'pengguna';

			$system_profil_picture	= array
									  (
									  	'6gb12a88h51e7016b21g7371h.png',
									  	'd5991cc5b8f8dc8a4g26c335g.png'
									  );

			$get_profile_picture 	= $users_model->where($data_update_account->id)->get('Foto_Pengguna', 'ID_Pengguna')->fetch(); 

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
						if ($users_model->where($data_update_account->id)->update("Nama='$data_update_account->fullname', Tanggal_Lahir='$data_update_account->dateofbirth', Bulan_Lahir='$data_update_account->monthofbirth', Tahun_Lahir='$data_update_account->yearofbirth', Jenis_Kelamin='$data_update_account->gender', Alamat='$data_update_account->address', Ponsel='$data_update_account->phonenumber', Email='$data_update_account->email'", "ID_Pengguna"))
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
					else if ($data_update_account->gender != $data_update_account->gendernow AND in_array($get_profile_picture['Foto_Pengguna'], $system_profil_picture))
					{
						$users_model = new app\http\models\Users;

						$users_model->connect();

						$users_model->table = 'pengguna';

						$get_name_folder_now	= $users_model->where($data_update_account->id)->get('Folder_Pengguna', 'ID_Pengguna')->fetch();

						$get_name_img_now		= $users_model->where($data_update_account->id)->get('Foto_Pengguna', 'ID_Pengguna')->fetch();

						$img_now   = '../resources/assets/'.$get_name_folder_now['Folder_Pengguna'].'/'.$get_name_img_now['Foto_Pengguna'];

						$img_fname = $data_update_account->gender == 'Pria' ? '6gb12a88h51e7016b21g7371h.png' : 'd5991cc5b8f8dc8a4g26c335g.png'; 

						$from      = $data_update_account->gender == 'Pria' ? '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/6gb12a88h51e7016b21g7371h.png' : '../resources/assets/3gfah3eabdcf7176h5db0g854d79e8fg5hd8ce19/d5991cc5b8f8dc8a4g26c335g.png';

						if (unlink($img_now))
						{
							if (copy($from, '../resources/assets/'.$get_name_folder_now['Folder_Pengguna'].'/'.$img_fname))
							{
								if ($users_model->where($data_update_account->id)->update("Foto_Pengguna='$img_fname' , Nama='$data_update_account->fullname', Tanggal_Lahir='$data_update_account->dateofbirth', Bulan_Lahir='$data_update_account->monthofbirth', Tahun_Lahir='$data_update_account->yearofbirth', Jenis_Kelamin='$data_update_account->gender', Alamat='$data_update_account->address', Ponsel='$data_update_account->phonenumber', Email='$data_update_account->email'", "ID_Pengguna"))
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
					else if ($data_update_account->gender != $data_update_account->gendernow AND in_array($get_profile_picture['Foto_Pengguna'], $system_profil_picture) == false)
					{
						if ($users_model->where($data_update_account->id)->update("Nama='$data_update_account->fullname', Tanggal_Lahir='$data_update_account->dateofbirth', Bulan_Lahir='$data_update_account->monthofbirth', Tahun_Lahir='$data_update_account->yearofbirth', Jenis_Kelamin='$data_update_account->gender', Alamat='$data_update_account->address', Ponsel='$data_update_account->phonenumber', Email='$data_update_account->email'", "ID_Pengguna"))
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
										$users_model = new app\http\models\Users;

										$users_model->connect();

										$users_model->table = 'pengguna';

										$get_name_folder_now	= $users_model->where($id)->get('Folder_Pengguna', 'ID_Pengguna')->fetch();

										$get_folder_now 		= '../resources/assets/'.$get_name_folder_now['Folder_Pengguna'].'/';

										$this->deleteFolderNow($get_folder_now);

										if ($users_model->where($id)->update("Folder_Pengguna='$new_folder', Foto_Pengguna='$profil_picture_name', Nama='$fullname', Tanggal_Lahir='$dateofbirth', Bulan_Lahir='$monthofbirth', Tahun_Lahir='$yearofbirth', Jenis_Kelamin='$gender', Alamat='$address', Ponsel='$phonenumber', Email='$email'", "ID_Pengguna"))
										{
											$dataform = array
														(
										   	   				'fullname' 		=> $fullname,
										   	   				'dateofbirth'	=> $dateofbirth,
										   	   				'monthofbirth'	=> $monthofbirth,
										       				'yearofbirth'	=> $yearofbirth,
										       				'gender'		=> $gender,
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

			$users_model	   	   = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

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
				else if ($users_model->CheckPassword($users_model->get(null, 'Katasandi')->fetch(), $change_password_data->password) == false)
				{
					Ajax::json_response(array('Tag' => '#1e87ab2a0a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Katasandi lama yang anda masukkan salah'));
				}
				else
				{

					$hash_new_password = password_hash($change_password_data->newpassword, PASSWORD_DEFAULT);

					if ($users_model->where($change_password_data->id)->update("Katasandi='$hash_new_password'", "ID_Pengguna"))
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

	public function viewBookDetail()
	{

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		$book_model 		= new app\http\models\Book;

		$book_model->connect();

		$book_model->table  = 'buku';

		$list_recommended_book = $book_model->getRecommendedBook(1, 6); 

		if ($session->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{
				if (isset($_GET['id']) OR empty($_GET['id']) == false )
				{
					$book_id_get = $_GET['id'];

					$book_model	 = new app\http\models\Book;

					$book_model->connect();

					$book_model->table = 'buku';

					if ($book_model->CheckBooKID($book_id_get))
					{
						$data_table		   = $book_model->getEditData($book_id_get);

						$get_book_rating   = 0;

						if ($data_table['Total_Rating'] >= 50 AND $data_table['Total_Rating'] <= 80)
						{
							$get_book_rating = 1;
						}
						else if ($data_table['Total_Rating'] > 80 AND $data_table['Total_Rating'] <= 110)
						{
							$get_book_rating = 2;
						}
						else if ($data_table['Total_Rating'] > 110 AND $data_table['Total_Rating'] <= 140)
						{
							$get_book_rating = 3;
						}
						else if ($data_table['Total_Rating'] > 140 AND $data_table['Total_Rating'] <= 170)
						{
							$get_book_rating = 4;
						}
						else if ($data_table['Total_Rating'] > 170)
						{
							$get_book_rating = 5;
						}
						else
						{
							$get_book_rating = 0;
						}

						if (isset($_GET['borrow_book_id']) OR empty($_GET['borrow_book_id']) == false AND isset($_GET['borrow_code']) OR empty($_GET['borrow_code']) == false)
						{
							$book_id_get = $_GET['borrow_book_id'];

							$code_get    = $_GET['borrow_code'];

							$book_model	 = new app\http\models\Book;

							$book_model->connect();

							$book_model->table  = 'statistik_buku';

							if ($book_model->CheckPermission1($session->value('users'), $code_get))
							{

								$book_model->table  = 'buku';

								$users_model 	    = new app\http\models\Users;

								$users_model->connect();

								$users_model->table = 'pengguna';

								$data = array
										(
											"URL"    		=> $this->getEnv('BASE_URL'),
											"Data"	 	    => $data_table,
											"Data_Ulasan"   => $book_model->getReviewBook($book_id_get),
											"ID_Pengguna"   => $session->value('users'),
											"Jumlah_Ulasan" => $book_model->getNumRowReviewBOok($book_id_get),
											"Rating" 		=> $get_book_rating,
											"Data_Pengguna" => $users_model->getUsersData($session->value('users'))
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
            									'custom_resources'  => '../resources/borrow_book_detail/',
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

							$book_model->table   = 'ulasan_buku';

							$data = array
									(
										"URL"    		=> $this->getEnv('BASE_URL'),
										"Data"	 	    => $data_table,
										"Data_Ulasan"   => $book_model->getReviewBook($book_id_get),
										"ID_Pengguna"   => $session->value('users'),
										"Jumlah_Ulasan" => $book_model->getNumRowReviewBOok($book_id_get),
										"Rating" 		=> $get_book_rating,
										"Rekomendasi_Buku" => $list_recommended_book
									);
						
							$this->parts($data);
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
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{
				if (isset($_GET['id']) OR empty($_GET['id']) == false)
				{
					$book_id_get = $_GET['id'];

					$book_model	 = new app\http\models\Book;

					$book_model->connect();

					$book_model->table = 'buku';

					if ($book_model->CheckBooKID($book_id_get))
					{

						$data_table		   = $book_model->getEditData($book_id_get);

						$get_book_rating   = 0;

						if ($data_table['Total_Rating'] >= 50 AND $data_table['Total_Rating'] <= 80)
						{
							$get_book_rating = 1;
						}
						else if ($data_table['Total_Rating'] > 80 AND $data_table['Total_Rating'] <= 110)
						{
							$get_book_rating = 2;
						}
						else if ($data_table['Total_Rating'] > 110 AND $data_table['Total_Rating'] <= 140)
						{
							$get_book_rating = 3;
						}
						else if ($data_table['Total_Rating'] > 140 AND $data_table['Total_Rating'] <= 170)
						{
							$get_book_rating = 4;
						}
						else if ($data_table['Total_Rating'] > 170)
						{
							$get_book_rating = 5;
						}
						else
						{
							$get_book_rating = 0;
						}

						if (isset($_GET['borrow_book_id']) OR empty($_GET['borrow_book_id']) == false AND isset($_GET['borrow_code']) OR empty($_GET['borrow_code']) == false)
						{
							$book_id_get = $_GET['borrow_book_id'];

							$code_get    = $_GET['borrow_code'];

							$book_model	 = new app\http\models\Book;

							$book_model->connect();

							$book_model->table  = 'statistik_buku';

							if ($book_model->CheckPermission1($session->value('users'), $code_get))
							{

								$book_model->table  = 'buku';

								$users_model 	    = new app\http\models\Users;

								$users_model->connect();

								$users_model->table = 'pengguna';

								$data = array
										(
											"URL"    		=> $this->getEnv('BASE_URL'),
											"Data"	 	    => $data_table,
											"Data_Ulasan"   => $book_model->getReviewBook($book_id_get),
											"ID_Pengguna"   => $session->value('users'),
											"Jumlah_Ulasan" => $book_model->getNumRowReviewBOok($book_id_get),
											"Rating" 		=> $get_book_rating,
											"Data_Pengguna" => $users_model->getUsersData($session->value('users'))
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
            									'custom_resources'  => '../resources/borrow_book_detail/',
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

							$book_model->table   = 'ulasan_buku';

							$data = array
									(
										"URL"    		=> $this->getEnv('BASE_URL'),
										"Data"	 	    => $data_table,
										"Data_Ulasan"   => $book_model->getReviewBook($book_id_get),
										"ID_Pengguna"   => $session->value('users'),
										"Jumlah_Ulasan" => $book_model->getNumRowReviewBOok($book_id_get),
										"Rating" 		=> $get_book_rating,
										"Rekomendasi_Buku" => $list_recommended_book
									);
							$this->parts($data);
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

	public function borrowBookAjax()
	{
		if (Ajax::Check())
		{
			$borrow_book_data = Ajax::AngularInput();

			if (Validation::isEmpty($borrow_book_data->id) OR is_null($borrow_book_data->id))
			{
				Ajax::json_response(array('Tag' => '#8h1eh5gg4h', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
			}
			else if ($borrow_book_data->numberofbook <= 0)
			{
				Ajax::json_response(array('Tag' => '#0hd3b03606', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tidak dapat meminjam buku! Stoknya sudah habis'));
			}
			else
			{
				$book_model        = new app\http\models\Book;

				$book_model->connect();

				$book_model->table = 'statistik_buku';

				$borrow_id		   = substr(str_shuffle('01234567890ABCDEFGH'),0,10);

				date_default_timezone_set('Asia/Hong_Kong');

				$date              = date("Y-m-d H:i:s");

				if ($book_model->CheckBokkWanttoBorrow($borrow_book_data->id, $borrow_book_data->usersid) == 'type_1')
				{
					if ($book_model->insert("ID_Peminjaman,ID_Buku,Judul_Buku,Tanggal_Dipinjam,Tanggal_Dikembalikan,Keterangan,Status,ID_Pengguna", "'$borrow_id','$borrow_book_data->id','$borrow_book_data->booktitle','$date','$date','Proses Peminjaman','Belum Terverifikasi','$borrow_book_data->usersid'"))
					{
						Ajax::json_response(array('Tag' => '#490d9cfe96', 'Type' => 'success', 'borrow_code' => $borrow_id));
					}
					else
					{
						Ajax::json_response(array('Tag' => '#87535f8df1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
					}
				}
				else if ($book_model->CheckBokkWanttoBorrow($borrow_book_data->id, $borrow_book_data->usersid) == 'type_2')
				{
					$data_table = $book_model->query("SELECT ID_Peminjaman FROM statistik_buku WHERE ID_Buku='$borrow_book_data->id' AND ID_Pengguna='$borrow_book_data->usersid'")->fetch_assoc();

					Ajax::json_response(array('Tag' => '#h4f0655h1b', 'Type' => 'type_2', 'borrow_code' => $data_table['ID_Peminjaman']));
				}
				else if ($book_model->CheckBokkWanttoBorrow($borrow_book_data->id, $borrow_book_data->usersid) == 'type_3')
				{
					$data_table = $book_model->query("SELECT ID_Peminjaman FROM statistik_buku WHERE ID_Buku='$borrow_book_data->id' AND ID_Pengguna='$borrow_book_data->usersid'")->fetch_assoc();

					Ajax::json_response(array('Tag' => '#875h49dge7', 'Type' => 'type_3', 'borrow_code' => $data_table['ID_Peminjaman']));
				}
				else
				{
					Ajax::json_response(array('Tag' => '#87535f8df1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali'));
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewBorrowBookDetail()
	{

		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{
				if (isset($_GET['id']) OR empty($_GET['id']) == false AND isset($_GET['code']) OR empty($_GET['code']) == false)
				{
					$book_id_get = $_GET['id'];

					$code_get    = $_GET['code'];

					$book_model	 = new app\http\models\Book;

					$book_model->connect();

					$book_model->table = 'buku';

					if ($book_model->CheckBooKID($book_id_get))
					{
						$book_model->table  = 'statistik_buku';

						if ($book_model->CheckPermission1($session->value('users'), $code_get))
						{

							$book_model->table  = 'buku';

							$users_model 	    = new app\http\models\Users;

							$users_model->connect();

							$users_model->table = 'pengguna';

							$data = array
									(
										"URL"    		=> $this->getEnv('BASE_URL'),
										"Data_Buku"     => $book_model->getEditData($book_id_get),
										"Data_Pengguna" => $users_model->getUsersData($session->value('users'))
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
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{
				if (isset($_GET['id']) OR empty($_GET['id']) == false AND isset($_GET['code']) OR empty($_GET['code']) == false)
				{
					$book_id_get = $_GET['id'];

					$code_get    = $_GET['code'];

					$book_model	 = new app\http\models\Book;

					$book_model->connect();

					$book_model->table = 'buku';

					if ($book_model->CheckBooKID($book_id_get))
					{
						$book_model->table  = 'statistik_buku';

						if ($book_model->CheckPermission1($encode->unprotected($cookie->value('users')), $code_get))
						{

							$book_model->table  = 'buku';

							$users_model 	    = new app\http\models\Users;

							$users_model->connect();

							$users_model->table = 'pengguna';

							$data = array
									(
										"URL"    		  => $this->getEnv('BASE_URL'),
										"Data_Buku"       => $book_model->getEditData($book_id_get),
										"Data_Pengguna"   => $users_model->getUsersData($encode->unprotected($cookie->value('users')))
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
		else
		{
			$this->error_404();
		}
	}

	public function borrowBookStep2Ajax()
	{
		if (Ajax::Check())
		{
			$borrow_book_data  = Ajax::AngularInput();

			if (Validation::isEmpty($borrow_book_data->day))
			{
				Ajax::json_response(array('Tag' => '#87535f8df1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Kolom berapa lama meminjam masih kosong'));
			}
			else
			{
				$book_model     = new app\http\models\Book;

				$book_model->table  = 'statistik_buku';

				$book_model->connect();

				if ($book_model->CheckPermission1($borrow_book_data->usersid, $borrow_book_data->code))
				{
					if ($borrow_book_data->numberofbook > 0)
					{

						date_default_timezone_set('Asia/Hong_Kong');

						$dateDB   = $book_model->where($borrow_book_data->code)->get("Tanggal_Dipinjam", "ID_Peminjaman")->fetch();

						$date     = date_create($dateDB['Tanggal_Dipinjam']);
							
						date_add($date,date_interval_create_from_date_string($borrow_book_data->day." days"));

						$date     = date_format($date, "Y-m-d H:i:s");

						if ($book_model->where($borrow_book_data->code)->update("Tanggal_Dikembalikan='$date', Keterangan='Proses Peminjaman',Status='Terverifikasi'", "ID_Peminjaman"))
						{
							Ajax::json_response(array('Tag' => '#490d9cfe96', 'Type' => 'success'));
						}
						else
						{
							Ajax::json_response(array('Tag' => '#0f9af0g574', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.'));		
						}
					}
					else
					{
						Ajax::json_response(array('Tag' => '#5855e762e1', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Tidak dapat meminjam buku! Stoknya sudah habis'));
					}
				}
				else
				{
					Ajax::json_response(array('Tag' => '#311g024gbc', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.'));
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewMyBook()
	{
		$session 		= new Flare\Network\Http\Session;

		$cookie  		= new Flare\Network\Http\Cookie;

		$encode         = new Flare\Components\Encode;

		$encode->key    = $this->getEnv('KEY');

		$session->start();

		if ($session->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{

				$usersId           = $session->value('users');

				$book_model		   = new app\http\models\Book;

				$book_model->connect();

				$book_model->table = 'statistik_buku';

				$limit_display     = 5;

				$set_page          = isset($_GET['page'])? (int)$_GET["page"]:1;
        
        		$check_page        = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

        		$total_rows        = $book_model->getBookRows();

        		$ceilIt            = ceil($total_rows/$limit_display);

			    $list_my_book      = $book_model->getListMyBook($usersId, $check_page, $limit_display);

			    $data 			   = array
									 (
										"URL"             => $this->getEnv('BASE_URL'),
										"Data_Pengguna"   => $users_model->getUsersData($session->value('users')),
										"List_Buku"       => $list_my_book,
										"Halaman_Paging"  => $set_page,
										"Total_Halaman"   => $ceilIt,
										"ID_Pengguna"     => $usersId
									 ); 

				$this->parts($data);
			}
			else
			{
				$this->error_404();	
			}
		}
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{

				$usersId           = $encode->unprotected($cookie->value('users'));

				$book_model		   = new app\http\models\Book;

				$book_model->connect();

				$book_model->table = 'statistik_buku';

				$limit_display     = 5;

				$set_page          = isset($_GET['page'])? (int)$_GET["page"]:1;
        
        		$check_page        = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

        		$total_rows        = $book_model->getBookRows();

        		$ceilIt            = ceil($total_rows/$limit_display);

			    $list_my_book      = $book_model->getListMyBook($usersId, $check_page, $limit_display);

			    $data 			   = array
									 (
										"URL"             => $this->getEnv('BASE_URL'),
										"Data_Pengguna"   => $users_model->getUsersData($encode->unprotected($cookie->value('users'))),
										"List_Buku"       => $list_my_book,
										"Halaman_Paging"  => $set_page,
										"Total_Halaman"   => $ceilIt,
										"ID_Pengguna"     => $usersId
									 ); 

				$this->parts($data);
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function searchBorrowedBookAjax()
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

					$book_model->table = 'statistik_buku';

					$data_table		   = $book_model->searchMyBook($search_book_data->usersid, $keyword);

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

	public function viewTodo()
	{
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{
				if (isset($_GET['id']) OR empty($_GET['id']) == false AND isset($_GET['code']) OR empty($_GET['code']) == false)
				{
					$book_id_get = $_GET['id'];

					$code_get    = $_GET['code'];

					$book_model	 = new app\http\models\Book;

					$book_model->connect();

					$book_model->table = 'buku';

					if ($book_model->CheckBooKID($book_id_get))
					{
						$book_model->table  = 'statistik_buku';

						if ($book_model->CheckPermission2($session->value('users'), $code_get))
						{
							$data = array
									(
										"URL"    		=> $this->getEnv('BASE_URL'),
										"Data_Buku"       => $book_model->getEditData($book_id_get),
										"Data_Pengguna" => $users_model->getUsersData($session->value('users'))
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
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{
				if (isset($_GET['id']) OR empty($_GET['id']) == false AND isset($_GET['code']) OR empty($_GET['code']) == false)
				{
					$book_id_get = $_GET['id'];

					$code_get    = $_GET['code'];

					$book_model	 = new app\http\models\Book;

					$book_model->connect();

					$book_model->table = 'buku';

					if ($book_model->CheckBooKID($book_id_get))
					{
						$book_model->table  = 'statistik_buku';

						if ($book_model->CheckPermission2($encode->unprotected($cookie->value('users')), $code_get))
						{
							$users_model 	    = new app\http\models\Users;

							$users_model->connect();

							$users_model->table = 'pengguna';

							$data = array
									(
										"URL"    		  => $this->getEnv('BASE_URL'),
										"Data_Buku"       => $book_model->getEditData($book_id_get),
										"Data_Pengguna"   => $users_model->getUsersData($encode->unprotected($cookie->value('users')))
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
		else
		{
			$this->error_404();
		}
	}

	public function viewReviewBook()
	{
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{
				if (isset($_GET['bookid']) OR empty($_GET['bookid']) == false)
				{
					$book_id_get   	   = $_GET['bookid'];

					$book_model    	   = new app\http\models\Book;

					$book_model->table = 'buku';

					if ($book_model->CheckBookID($book_id_get))
					{
						$users_id      = $session->value('users');

						$book_model->table = 'statistik_buku';

						if ($book_model->CheckUsersCanReviewBook($book_id_get, $users_id))
						{
							$book_model->table = 'buku';

							$data = array
									(
										"URL"   => $this->getEnv('BASE_URL'),
										"Data"  => $book_model->getEditData($book_id_get),
										"ID_Pengguna" => $users_id
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
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{
				if (isset($_GET['bookid']) OR empty($_GET['bookid']) == false)
				{
					$book_id_get   	   = $_GET['bookid'];

					$book_model    	   = new app\http\models\Book;

					$book_model->table = 'buku';

					if ($book_model->CheckBookID($book_id_get))
					{
						$users_id      = $encode->unprotected($cookie->value('users'));

						$book_model->table = 'statistik_buku';

						if ($book_model->CheckUsersCanReviewBook($book_id_get, $users_id))
						{
							$book_model->table = 'buku';

							$data = array
									(
										"URL"   => $this->getEnv('BASE_URL'),
										"Data"  => $book_model->getEditData($book_id_get),
										"ID_Pengguna" => $users_id
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
		else
		{
			$this->error_404();
		}
	}

	public function ReviewBookAjax()
	{
		if (Ajax::Check())
		{
			$review_book_data = Ajax::AngularInput();

			if (Validation::isEmpty($review_book_data))
			{
				Ajax::json_response(array('Tag' => '#311g024gbc', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan dalam mengulas buku tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.'));	
			}
			else
			{
				$users_model        = new app\http\models\Users;

				$users_model->table = 'pengguna';

				$users_model->connect();

				$getUsersName       = $users_model->where($review_book_data->usersid)->get("Nama", "ID_Pengguna")->fetch();

				$name               = $getUsersName['Nama'];

				$users_model->disconnect();

				$book_model		    = new app\http\models\Book;

				$book_model->table  = 'buku';

				$book_model->connect();

				$securedInputReview = Validation::SecureInput($review_book_data->usersreview);

				if ($book_model->CheckBookID($review_book_data->bookid))
				{
					$getOldRating = $book_model->where($review_book_data->bookid)->get("Total_Rating", "ID_Buku")->fetch();

					$newRating    = $getOldRating['Total_Rating'] + $review_book_data->usersrating;

					$review_id    = substr(str_shuffle('0123456789012345678901234567890123456789'),0,40);
					
					$book_model->table = 'ulasan_buku';

					$date              = date("Y-m-d H:i:s");

					if ($book_model->insert("ID_Ulasan,ID_Buku,ID_Pengguna,Nama,Isi_Ulasan,Jumlah_Rating,Tanggal_Diulas", "'$review_id', '$review_book_data->bookid', '$review_book_data->usersid', '$name','$securedInputReview','$review_book_data->usersrating','$date'"))
					{
						$book_model->table = 'buku';

						if ($book_model->where($review_book_data->bookid)->update("Total_Rating='$newRating'", "ID_Buku"))
						{
							$book_model->table = 'statistik_buku';

							$getBorrowID       = $book_model->getBorrowID($review_book_data->bookid, $review_book_data->usersid);

							$borrow_id         = $getBorrowID['ID_Peminjaman'];

							if ($book_model->where($borrow_id)->update("Keterangan='Diulas'", "ID_Peminjaman"))
							{
								Ajax::json_response(array('Tag' => '#05b11af5a2', 'Title' => 'Berhasil', 'Type' => 'success', 'Message' => 'Berhasil mengulas buku.', 'review_id' => $review_id, 'book_id' => $review_book_data->bookid));
							}
							else
							{
								Ajax::json_response(array('Tag' => '#e76a44e6da', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan dalam mengulas buku tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.'));
							}
						}
						else
						{
							Ajax::json_response(array('Tag' => '#d99bd58c8f', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan dalam mengulas buku tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.'));
						}
					}
					else
					{
						Ajax::json_response(array('Tag' => '#4f9f73d39a', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan dalam mengulas buku tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.'));
					}
				}
				else
				{
					Ajax::json_response(array('Tag' => '#33aabca137', 'Title' => 'Kesalahan', 'Type' => 'error', 'Message' => 'Terjadi kesalahan sistem yang menyebabkan dalam mengulas buku tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.'));
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	public function viewListBookReview()
	{
		$session = new Flare\Network\Http\Session;

		$cookie  = new Flare\Network\Http\Cookie;

		$session->start();

		if ($session->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{
				if (isset($_GET['book_id']) OR empty($_GET['book_id']))
				{
					$book_id   			= $_GET['book_id'];

					$book_model 		= new app\http\models\Book;

					$book_model->connect();

					$book_model->table  = 'buku';

					if ($book_model->CheckBooKID($book_id))
					{
						$book_data		    = $book_model->getEditData($book_id);

						$book_model->table  = 'ulasan_buku';
					
						$limit_display      = 10;

						$set_page           = isset($_GET['page'])? (int)$_GET["page"]:1;
        
				 	    $check_page         = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

						$total_rows         = $book_model->getBookReviewRows();

						$ceilIt             = ceil($total_rows/$limit_display);

						$book_model->table  = 'buku';

						$bookName           = $book_model->where($book_id)->get("Judul_Buku", "ID_Buku")->fetch();

						$list_review 	    = $book_model->getReview($book_id, $check_page, $limit_display);

						$data 				= array
										  	  (
												"URL" 			   => $this->getEnv('BASE_URL'),
												"Data_Pengguna"   => $users_model->getUsersData($session->value('users')),
												"Ulasan"           => $list_review,
												"Halaman_Paging"   => $set_page,
												"Total_Halaman"    => $ceilIt,
												"Data_Buku"        => $book_data
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
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			$encode         = new Flare\Components\Encode;

			$encode->key    = $this->getEnv('KEY');

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{
				if (isset($_GET['book_id']) OR empty($_GET['book_id']))
				{
					$book_id   			= $_GET['book_id'];

					$book_model 		= new app\http\models\Book;

					$book_model->connect();

					$book_model->table  = 'buku';

					if ($book_model->CheckBooKID($book_id))
					{
						$book_data		    = $book_model->getEditData($book_id);

						$book_model->table  = 'ulasan_buku';
					
						$limit_display      = 10;

						$set_page           = isset($_GET['page'])? (int)$_GET["page"]:1;
        
				 	    $check_page         = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

						$total_rows         = $book_model->getBookReviewRows();

						$ceilIt             = ceil($total_rows/$limit_display);

						$book_model->table  = 'buku';

						$bookName           = $book_model->where($book_id)->get("Judul_Buku", "ID_Buku")->fetch();

						$list_review 	    = $book_model->getReview($book_id, $check_page, $limit_display);

						$data 				= array
										  	  (
												"URL" 			   => $this->getEnv('BASE_URL'),
												"Data_Pengguna"   => $users_model->getUsersData($encode->unprotected($cookie->value('users'))),
												"Ulasan"           => $list_review,
												"Halaman_Paging"   => $set_page,
												"Total_Halaman"    => $ceilIt,
												"Judul_Buku"       => $bookName['Judul_Buku']
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

	public function viewBookCategory()
	{
		$session 		= new Flare\Network\Http\Session;

		$cookie  		= new Flare\Network\Http\Cookie;

		$encode         = new Flare\Components\Encode;

		$encode->key    = $this->getEnv('KEY');

		$session->start();

		if ($session->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($session->value('users')))
			{
				if (isset($_GET['id']) OR empty($_GET['id']) == false)
				{

					$book_model		   = new app\http\models\Book;

					$book_model->connect();

					$book_model->table = 'kategori_buku';

					if ($book_model->CheckCategoryID($_GET['id']))
					{

						$categoryName      = $book_model->where($_GET['id'])->get('Nama', 'ID_Kategori_Buku')->fetch();

						$book_model->table = 'buku';

						$limit_display     = 5;

						$set_page          = isset($_GET['page'])? (int)$_GET["page"]:1;
        
    	    			$check_page        = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

        				$total_rows        = $book_model->query("SELECT * FROM buku")->num_rows;

        				$ceilIt            = ceil($total_rows/$limit_display);

					    $list_book_cat     = $book_model->getBookCategory($categoryName['Nama'], $check_page, $limit_display);

				    	$data 			   = array
											 (
												"URL"             => $this->getEnv('BASE_URL'),
												"Data_Pengguna"   => $users_model->getUsersData($session->value('users')),
												"List_Buku"       => $list_book_cat,
												"Halaman_Paging"  => $set_page,
												"Total_Halaman"   => $ceilIt,
												"Kategori" => $categoryName['Nama']
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
		else if ($cookie->check('users') == true)
		{
			$users_model           = new app\http\models\Users;

			$users_model->connect();

			$users_model->table    = 'pengguna';

			if ($users_model->CheckID($encode->unprotected($cookie->value('users'))))
			{

				if (isset($_GET['id']) OR empty($_GET['id']) == false)
				{

					$book_model		   = new app\http\models\Book;

					$book_model->connect();

					$book_model->table = 'kategori_buku';

					if ($book_model->CheckCategoryID($_GET['id']))
					{

						$categoryName      = $book_model->where($_GET['id'])->get('Nama', 'ID_Kategori_Buku')->fetch();

						$book_model->table = 'buku';

						$limit_display     = 5;

						$set_page          = isset($_GET['page'])? (int)$_GET["page"]:1;
        
    	    			$check_page        = ($set_page>1) ? ($set_page * $limit_display) - $limit_display : 0;

        				$total_rows        = $book_model->query("SELECT * FROM buku")->num_rows;

        				$ceilIt            = ceil($total_rows/$limit_display);

					    $list_book_cat     = $book_model->getBookCategory($categoryName['Nama'], $check_page, $limit_display);

				    	$data 			   = array
											 (
												"URL"             => $this->getEnv('BASE_URL'),
												"Data_Pengguna"   => $users_model->getUsersData($encode->unprotected($cookie->value('users'))),
												"List_Buku"       => $list_book_cat,
												"Halaman_Paging"  => $set_page,
												"Total_Halaman"   => $ceilIt,
												"Kategori" => $categoryName['Nama']
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
		}
		else
		{
			$this->error_404();
		}
	}
}