<?php

require '../../../vendor/autoload.php';

use Flare\Network\Http\Model;

$Settings = array
            (
            	'controllers'       => '../../../', 
            	'config'            => '../../../',
            	'custom_resources'  => '../../resources/treasurer_dashboard/',
            	'custom_errors'     => '../../resources/errors/'
            );

Model::setDirectory($Settings); 

Model::get('Treasurer#viewDashboard');