<?php

use Flare\Network\Http\Controller;

use Flare\Components\Environment;

class Website extends Controller
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

	public function Index()
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
}

?>