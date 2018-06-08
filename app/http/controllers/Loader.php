<?php

use Flare\Network\Http\Controller;

use Flare\Components\Loader as FileManage;

class Loader extends Controller
{
	public function Run()
	{
		FileManage::on();

		FileManage::loader();

		FileManage::off();
	}
}