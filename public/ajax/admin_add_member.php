<?php

require '../../vendor/autoload.php';

use Flare\Network\Http\Model;

$Settings = array
            (
            	'controllers'      => '../../', 
            	'config'           => '../../',
            	'resources'        => '',
            	'custom_resources' => '',
            	'custom_errors'    => '../resources/errors/'
            );
            
Model::setDirectory($Settings); 

Model::post('Admin#addMemberAjax');