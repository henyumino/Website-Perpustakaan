<?php

use Flare\Network\Http\Controller;

class Home extends Controller
{
	public function Index()
	{
		$this->load('home.php');
	}
}