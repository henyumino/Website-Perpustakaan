<?php

require '../../../vendor/autoload.php';

use Flare\Network\Http\Model;

$Settings = array
            (
            	'controllers'       => '../../../', 
            	'config'            => '../../../',
            	'custom_resources'  => '../../resources/treasurer_edit_report/',
            	'custom_errors'     => '../../resources/errors/'
            );

Model::setDirectory($Settings); 

Model::get('Treasurer#viewEditReport');