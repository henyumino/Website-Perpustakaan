<?php

require '../vendor/autoload.php';

use Flare\Network\Http\Model;

$Settings = array
            (
            	'controllers'       => '../', 
            	'config'            => '../',
            	'custom_resources'  => 'resources/users_verif/',
            	'custom_errors'     => 'resources/errors/'
            );

Model::setDirectory($Settings);

Model::get('Users#viewVerifPage');